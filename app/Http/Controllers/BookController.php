<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class BookController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
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
            $sortOrder = $request->input('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);
        }

        // Groupování
        if ($request->has('group_by')) {
            $groupBy = $request->input('group_by');
            $query->groupBy($groupBy);
        }

        // Stránkování
        $perPage = $request->input('per_page', 10);
        return $query->paginate($perPage);
    }
}
