<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ModalController extends Controller
{
    private function getModel($type) {
        if ($type == 0)
            return Book::class;
        else
            return Author::class;
            
    }

    public function hat(Request $request) {
        if (!Auth::check() || !Auth::user()->admin)
            return redirect()->back();
        
        $id = $request->input('id');
        // $name = $request->input('name');
        // $author_id = $request->input('author_id');
        // $description = $request->input('description');
        // $title = $request->input('title');
        // $email = $request->input('email');
        // $password = $request->input('password');
        $type = $request->input('type');

        if($type == 0) {
            $fields = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'author_id' => 'required|integer'
            ]);
        } else {
            $fields = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|max:255|unique:authors,email' . ($id ? ", $id" : ''),
                'password' => ($id ? '' : 'required|') . 'max:255'
            ]);

            if (array_key_exists('password', $fields) && $fields['password']) $fields['password'] = Hash::make($fields['password']);
        }
        
         Debugbar::info('working');

        if ($request->submit == 'save') {
            Debugbar::info('save');
            if ($id) {
                Debugbar::info('update');
                $newData = [];
                if ($type == 0) 
                    $checkFields = ['title', 'description', 'author_id'];
                else
                    $checkFields = ['name', 'email', 'password'];
                
                foreach ($checkFields as $cfield) {
                    if (array_key_exists($cfield, $fields) && $fields[$cfield]) $newData = array_merge($newData, [$cfield => $fields[$cfield]]);
                }
                $this->getModel($type)::whereId($id)->update($newData);
            } else {
                Debugbar::info('create');
                $this->getModel($type)::create(($type == 0) ? 
                    [
                        'title' => $fields['title'],
                        'description' => $fields['description'],
                        'author_id' => $fields['author_id']
                    ] : [
                        'name' => $fields['name'],
                        'email' => $fields['email'],
                        'password' => $fields['password']
                    ]);
                // Book::create([
                //     'title' => $fields['title'],
                //     'description' => $fields['description'],
                //     'author_id' => 2
                // ]);
            }
        } elseif ($request->submit == 'delete') {
            $this->getModel($type)::destroy($id);
        }
        return redirect()->back();
    }
}
