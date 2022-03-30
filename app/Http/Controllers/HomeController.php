<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{   
    public function index()
    {   
        return view('home', 
            Auth::user()->isAdmin() ? 
                [
                    'hasAccess' => true,
                    'books' => Book::with('Author:id,name')->get(),
                    'authors' => Author::withCount('Books')->get(),
                    'modal' => [
                        'open' => false,
                        'view' => view()
                    ]
                ] : [
                    'hasAccess' => false
                ]
        );
    }
}
