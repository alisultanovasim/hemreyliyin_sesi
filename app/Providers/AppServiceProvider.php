<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Voice;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $allUsers = User::query()->count();
        $hasRecord = User::query()->has('voice')->count();
        $hasNoRecord = User::query()->doesntHave('voice')->count();
        $allRecord = Voice::query()->count();
        view()->share(['allUsers'=> $allUsers,'hasRecord'=>$hasRecord,'hasNoRecord'=>$hasNoRecord,'allRecord'=>$allRecord]);
    }
}
