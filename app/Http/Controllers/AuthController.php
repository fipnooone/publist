<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function login(Request $request) {
        if(Auth::check())
            return redirect(route('home'));

        $formFields = $request->only(['email', 'password']);

        if(Auth::attempt($formFields)) {
            return redirect()->intended(route('home'));
        }

        return redirect(route('login'))->withErrors([
            'wrongAuth' => 'Wrong email or password'
        ]);
    }

    public function registration(Request $request) {
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
            return redirect(route('home'));
        }

        return redirect(route('login'))->withErrors([
            'formError' => 'Server error'
        ]);
    }
}
