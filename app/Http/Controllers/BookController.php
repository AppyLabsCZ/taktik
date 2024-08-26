<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
}
