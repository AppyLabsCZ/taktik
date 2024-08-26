<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['author', 'genres']);

        // Filtrování
        if ($request->has('filter')) {
            $filters = $request->input('filter');
            foreach ($filters as $field => $value) {
                $query->where($field, 'like', "%$value%");
            }
        }

        // Řazení
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc'); // výchozí hodnota je 'asc'
            $query->orderBy($sortBy, $sortOrder);
        }

        // Stránkování
        $perPage = $request->input('per_page', 10); // výchozí hodnota je 10
        $books = $query->paginate($perPage);

        // --- Seskupování v paměti ---
        if ($request->has('group_by')) {
            $groupBy = $request->input('group_by');
            $grouped = $books->getCollection()->groupBy($groupBy);

            // Převedeme skupiny zpět do paginátoru
            $books = new LengthAwarePaginator(
                $grouped,
                $books->total(),
                $books->perPage(),
                $books->currentPage(),
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath()
                ]
            );
        }

        return response()->json($books);
    }

    public function store(Request $request)
    {
        // Validace vstupu
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|integer|exists:authors,id',
        ]);

        // Vytvoříme novou knihu
        $book = Book::create([
            'title' => $request->input('title'),
            'author_id' => $request->input('author_id'),
        ]);

        // Vrátíme odpověď v JSON
        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $book = Book::findOrFail($id);
        $book->update($validated);

        return response()->json($book, 201);
    }

    public function destroy($id): JsonResponse
    {
        $book = Book::findOrFail($id);

        // Odstranit související záznamy v book_genres
        $book->genres()->detach();

        // Nyní můžeme bezpečně odstranit samotnou knihu
        $book->delete();

        return response()->json(null, 204);
    }
}
