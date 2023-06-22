<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtpRequest;
use App\Models\Otp;
use App\Models\User;
use App\Models\Voice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function home()
    {
        $lastUsers = User::query()->latest()->get();
        $allUsers = User::query()->count();
        $hasRecord = User::query()->has('voice')->count();
        $hasNoRecord = User::query()->doesntHave('voice')->count();
        $allRecord = Voice::query()->count();
        return view('home',compact('allRecord','hasRecord','hasNoRecord','allUsers','lastUsers'));
    }
    public function voices()
    {
        $voices = Voice::query()->with(['user:id,name,surname'])->get();
        return view('voices',compact('voices'));
    }

    public function usersHasRecord()
    {
        $users = User::query()->has('voice')->get();
        return view('users',compact('users'));
    }
    public function usersHasNoRecord()
    {
        $users = User::query()->doesntHave('voice')->get();
        return view('users',compact('users'));
    }

}
