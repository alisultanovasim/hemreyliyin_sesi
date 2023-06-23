<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Voice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function loginForm()
    {
        return view('login');
    }
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        return redirect()->route('home');
    }
    return redirect()->back()->with('error', 'Invalid login credentials');
}

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Logged out successfully');

    }

}
