<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtpRequest;
use App\Models\Otp;
use App\Models\User;
use App\Models\Voice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function home()
    {
        $monthlyCounts = User::query()
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $allMonths = [];

        foreach (range(1, 12) as $month) {
            $count = $monthlyCounts->where('month', $month)->pluck('count')->first() ?? 0;
            $allMonths[] = [
                'month' => $month,
                'count' => $count,
            ];
        }
        $lastUsers = User::query()->latest()->get();
        return view('home',compact('lastUsers','monthlyCounts','allMonths'));
    }
    public function voices()
    {
        $voices = Voice::query()->with(['user:id,name,surname'])->get();
        return view('voices',compact('voices'));
    }

    public function usersHasRecord()
    {
        $header = 'İştirak edən istifadəçilər';
        $users = User::query()->has('voice')->get();
        return view('users',compact('users','header'));
    }
    public function usersHasNoRecord()
    {
        $header = 'İştirak etməyən istifadəçilər';
        $users = User::query()->doesntHave('voice')->get();
        return view('users',compact('users','header'));
    }

}
