<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthorsController extends Controller
{
    public function index() {
        return Author::withCount('Books')->get();
    }

    public function edit(Request $request) {
        $input_id = $request->input('id');

        if ($input_id && Auth::user()->admin)
            $userId = $input_id;
        else
            $userId = Auth::user()->id;

        $fields = $request->validate([
            'name' => 'string',
            'email' => 'string|email|unique:authors,email,' . $userId,
            'password' => 'string|nullable'
        ]);

        if (array_key_exists('password', $fields) && $fields['password']) $fields['password'] = Hash::make($fields['password']);
        else unset($fields['password']);

        Author::whereId($userId)->update($fields);

        return ['success'=>true];
    }

    private function withView($res)
    {
        if($res && array_key_exists('success', $res))
            return redirect()->back();
        
        return redirect()->back()->withErrors($res);
    }

    public function editView(Request $request) {
        $this->withView($this->edit($request));
    }

    public static function getByIdWithBooks($id) {
        $author = Author::select('name', 'email')->whereId($id)->first();

        if(!$author)
            return [
                'error' => 'Author not found'
            ];

        return [
            'name' => $author->name,
            'email' => $author->email,
            'books' => Book::where('author_id', '=', $id)->get()
        ];
    }

    public function create(Request $request)
    {
        if (!Auth::user()->admin)
            return redirect()->back()->withErrors(['error' => 'No access']);
        
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|max:255|unique:authors,email',
            'password' => 'required|string|max:255'
        ]);

        $user = Author::create($fields);

        if($user) {
            return redirect()->back();
        }

        return redirect()->back()->withErrors([
            'error' => 'Server error'
        ]);
    }

    public function destroy(Request $request)
    {   
        if (!Auth::user()->admin)
            return redirect()->back()->withErrors(['error' => 'No access']);

        $fields = $request->validate([
            'id' => 'integer'
        ]);

        Author::destroy($fields['id']);

        return redirect()->back();
    }
}
