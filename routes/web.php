<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\RegisterController;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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



Route::resource('books', BooksController::class);


// Route::view('/', 'home', [
//     'books' => Book::all(),
//     'authors' => Author::all()
// ])->middleware('auth')->name('home');

Route::get('', [HomeController::class, 'index'])->middleware('auth')->name('home');

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

Route::get('/book/{id}', [BooksController::class, 'show']);

Route::get('/logout', function() {
    Auth::logout();
    return redirect(route('login'));
})->name('logout');

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/registration', [AuthController::class, 'registration']);
//Route::post('/book', [LoginController::class, 'save']);

Route::post('/edit', [ModalController::class, 'hat'])->middleware('auth')->name('edit');