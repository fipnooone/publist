<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{   
    public function index()
    {   
        return view('home', [
            'books' => Book::getAll(),
            'authors' => Author::getAll(),
            'modal' => [
                'open' => false,
                'view' => view()
            ]
        ]);
    }

    public function create()
    {   
        return view('home', [
            'books' => Book::getAll(),
            'authors' => Author::getAll(),
            'modal' => [
                'open' => true,
                'view' => view('modal', [
                    'open' => true
                ])
            ]
        ]);
    }

    public function getModal($state=false)
    {
        return view('modal', [
            'open' => $state
        ]);
    }
}