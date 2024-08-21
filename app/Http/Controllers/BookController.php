<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class BookController extends Controller
{
    public function index(): Collection
    {
        return Book::with(['author', 'genres'])->get();
    }
}
