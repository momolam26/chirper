<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //Attempt to login
        if (Auth::attempt($credentials, $request->boolean('remember'))){
        //Regenerate sesion for security
        $request->session()->regenerate();

        //Redirect to intended page or home
        return redirect()->intended('/')->with('success', 'Welcome Back !');
        }
        //If login fails, redirect back with error
        return back()
        ->withErrors(['email' => 'We can\'t find this email'])
        ->onlyInput('email');
    }
}
