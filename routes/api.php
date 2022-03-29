<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\OAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('api')->group(function () {
    
// });

Route::post('login', [OAuthController::class, 'login']);
Route::post('registration', [OAuthController::class, 'registration']);

Route::middleware('auth:api')->group(function () {
    Route::get('logout', function() {
        Auth::logout();
    });
    //Route::post('/book', [LoginController::class, 'save']);
    //Route::get('/book', [LoginController::class, 'save']);
});

Route::prefix('books')->group(function () {
    Route::get('', [BooksController::class, 'index']); // 
    Route::get('{id}', [BooksController::class, 'show']); // 
    Route::get('searchByAuthor/{name}', [BooksController::class, 'searchByAuthorName']);
    Route::post('', [BooksController::class, 'save']);
});