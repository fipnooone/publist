<?php

namespace App\Http\Controllers;

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchByAuthorName($name)
    {   
        $author = DB::table('authors')->select('id')->where('name', $name)->get();
        if (!count($author) || !$author)
            return [ ];
        return Book::where('id', $author[0]->id)->get();
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
        $book = Book::where('id', '=', $id)->get();
        
        if(!count($book))
            return ['error'=>'Book not found'];
        
        return $book[0];
    }

    /**
     * Update Book (patch)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|integer',
            'title' => 'string',
            'description' => 'integer',
            'author_id' => 'integer'
        ]);

        $book = Book::whereId($fields['id'])->get()[0];

        if(Auth::user()->id != $book->author_id)
            return ['error'=>'No access'];

        $newData = [];

        foreach (['title', 'description', 'author_id'] as $key) {
            if (array_key_exists($key, $fields) && $fields[$key])
                $newData[$key] = $fields[$key];
        }

        if (!count($newData))
            return ['error'=>'No data provided'];

        $book->update($newData);

        return ['success'=>true];
    }

    /**
     * Delete book (delete)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|integer'
        ]);

        $book = Book::whereId($fields['id'])->get()[0];

        if(Auth::user()->id != $book->author_id)
            return ['error'=>'No access'];

        $book->delete();

        return ['success'=>true];
    }
}
