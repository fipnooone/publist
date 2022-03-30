<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('auth')->group(function() {
    Route::get('', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logOut'])->name('logout');

    Route::prefix('author/edit')->group(function () {
        Route::post('', [AuthorsController::class, 'create']);
        Route::delete('', [AuthorsController::class, 'destroy']);
        Route::patch('', [AuthorsController::class, 'editView']);
    });

    Route::prefix('book/edit')->group(function () {
        Route::post('', [BooksController::class, 'create']);
        Route::delete('', [BooksController::class, 'destroyView']);
        Route::patch('', [BooksController::class, 'editView']);
    });
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/registration', [AuthController::class, 'showRegister'])->name('registration');

Route::get('/book/{id}', [BooksController::class, 'show']);

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/registration', [AuthController::class, 'registration']);

Route::post('/edit', [ModalController::class, 'hat'])->middleware('auth')->name('edit');