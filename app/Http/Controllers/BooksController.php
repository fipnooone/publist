<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {   
        return Book::with('Author:id,name')->get();
    }
    /**
     * Display a listing of the resource.
     *
     */
    public function searchByAuthorName($name)
    {   
        $author = Author::select('id')->where('name', '=', $name)->first();

        if(!$author)
            return [
                'error' => 'Author not found'
            ];

        return Book::where('author_id', $author->id)->get(); 
    }
    /**
     * Store a newly created resource in storage.
     *
     */
    public function create(Request $request)
    {   
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
            return redirect()->back();
        }
        
        return redirect()->back()->withErrors(['error' => 'Book creation error']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        
        if(!$book)
            return ['error'=>'Book not found'];
        
        return $book;
    }

    /**
     * Update Book (patch)
     *
     */

    public function edit(Request $request) {
        $fields = $request->validate([
            'id' => 'required|integer',
            'title' => 'string',
            'description' => 'string',
            'author_id' => 'integer'
        ]);

        $book = Book::find($fields['id']);

        if (!$book)
            return ['error'=>'Book not found'];

        if(Auth::user()->id != $book->author_id && !Auth::user()->admin)
            return ['error'=>'No access'];

        $book->update($fields);

        return ['success'=>true];
    }

    private function withView($res)
    {
        if($res && array_key_exists('success', $res))
            return redirect()->back();
        
        return redirect()->back()->withErrors($res);
    }

    public function editView(Request $request)
    {      
        return $this->withView($this->edit($request));
    }

    /**
     * Delete book (delete)
     *
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|integer'
        ]);

        $book = Book::find($fields['id']);

        if (!$book)
            return ['error'=>'Book not found'];

        if(Auth::user()->id != $book->author_id && !Auth::user()->admin)
            return ['error'=>'No access'];

        $book->delete();

        return ['success'=>true];
    }

    public function destroyView(Request $request)
    {
        return $this->withView($this->destroy($request));
    }
}
