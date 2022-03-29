<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    /**
     * Update the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function update($user)
    {
        $token = Str::random(60);
 
        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();
 
        return $token;
    }

    
    public function login(Request $request) {
        if(Auth::check())
            Auth::logout();

        $formFields = $request->only(['email', 'password']);

        if(Auth::attempt($formFields)) {
            $token = Auth::user()->api_token;
            if (!$token) {
                $token = $this->update(Auth::user());
            }
            return ['api_token' => $token];
        }

        return [
            'wrongAuth' => 'Wrong email or password'
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
            $token = Auth::user()->api_token;
            if (!$token) {
                $token = $this->update(Auth::user());
            }
            return ['api_token' => $token];
        }

        return redirect(route('login'))->withErrors([
            'formError' => 'Server error'
        ]);

    }
}
