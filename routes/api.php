<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\OAuthController;
use App\Models\Author;
use Illuminate\Support\Facades\Route;

Route::post('login', [OAuthController::class, 'login']);
Route::post('registration', [OAuthController::class, 'registration']);

Route::prefix('books')->group(function () {
    Route::get('', [BooksController::class, 'index']);
    Route::get('{id}', [BooksController::class, 'show']);
    Route::patch('', [BooksController::class, 'edit'])->middleware('auth:sanctum');
    Route::delete('', [BooksController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::prefix('authors')->group(function() {
    Route::get('', [Author::class, 'getAll']);
    Route::get('{id}', [Author::class, 'getByIdWithBooks']);
    Route::get('books/{name}', [BooksController::class, 'searchByAuthorName']);
    Route::patch('', [Author::class, 'edit'])->middleware('auth:sanctum');;
});

