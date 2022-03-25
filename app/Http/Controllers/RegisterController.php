<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function save(Request $request) {
        if(Auth::check())
            return redirect('/');
            
        $validateFields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|max:255|unique:authors,email',
            'password' => 'required|max:255'
        ]);

        $user = Author::create($validateFields);
        if($user) {
            Auth::login($user);
            return redirect(route('private'));
        }

        return redirect(route('login'))->withErrors([
            'formError' => 'Server error'
        ]);
    }
}
