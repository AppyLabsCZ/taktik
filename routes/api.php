<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/new-book', [BookController::class, 'store']);
    Route::put('/update-book/{id}', [BookController::class, 'update']);
    Route::delete('/book/{id}', [BookController::class, 'destroy']);
});
