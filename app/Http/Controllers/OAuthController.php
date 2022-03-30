<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

class OAuthController extends Controller
{
    public function login(Request $request) {
        if(Auth::check())
            Auth::logout();

        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:255'
        ]);

        if(Auth::attempt($fields)) {
            $token = $request->user()->createToken(Str::random(10));
            return ['token' => $token->plainTextToken];
        }

        return [
            'error' => 'Wrong email or password'
        ];
    }

    public function registration(Request $request) {
        if(Auth::check())
            Auth::logout();
        
        $validateFields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|max:255|unique:authors,email',
            'password' => 'required|max:255'
        ]);

        $user = Author::create($validateFields);
        if($user) {
            Auth::login($user);
            $token = $request->user()->createToken(Str::random(10));
            return ['token' => $token->plainTextToken];
        }

        return [
             'error' => 'Server error'
        ];

    }
}
