<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     //Debugbar::error('INFO');

//     return view('welcome');
// });

//Route::get('/books', [BooksController::class, 'index']);

Route::resource('books', BooksController::class);

// Route::name('user.')->group(function() {
    
// });

Route::view('/', 'home')->middleware('auth')->name('home');
    
Route::get('/login', function() {
    if(Auth::check()) {
        return redirect(route('home'));
    }

    return view('login');
})->name('login');

Route::get('/registration', function() {
    if(Auth::check()) {
        return redirect(route('home'));
    }

    return view('registration');
})->name('registration');

Route::get('/logout', function() {
    Auth::logout();
    return redirect(route('login'));
})->name('logout');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/registration', [RegisterController::class, 'save']);