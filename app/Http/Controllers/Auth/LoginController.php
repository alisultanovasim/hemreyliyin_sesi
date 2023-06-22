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
        return redirect()->route('admin');
    }
    return redirect()->back()->with('error', 'Invalid login credentials');
}

    public function voices()
    {
        $voices = Voice::query()->with(['user:id,name,surname'])->get();
        return view('voices',compact('voices'));
    }
    public function admin()
    {
        return view('admin');
    }

}
