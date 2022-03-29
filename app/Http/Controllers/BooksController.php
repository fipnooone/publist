<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::getAll();
        //return Book::all()->join()
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchByAuthorName($name)
    {   
        $author = Author::where('name', $name)->get();
        if (!count($author) || !$author)
            return [ 'error' => 'Books not found' ];
        return Book::where('id', $author[0]['id'])->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        if(!Auth::check())
            return [ 'error' => 'Not Authorized' ];
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1024'
        ]);

        $book = Book::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'author_id' => Auth::user()->id
        ]);
        if($book) {
            return [ 'book_id' => $book['id'] ];
        }
        
        //return redirect()->withErrors(['newBookError' => 'Book creation error']);
        return [ 'error' => 'Book creation error' ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Book::where('id', '=', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
