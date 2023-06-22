<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('test',function (){
    return 'checkme';
});

// routes/web.php

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class,'loginForm']);
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class,'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class,'home'])->name('home');
    Route::get('/voices', [\App\Http\Controllers\AdminController::class,'voices'])->name('voices');
    Route::get('/users-has-record', [\App\Http\Controllers\AdminController::class,'usersHasRecord'])->name('users-has-record');
    Route::get('/users-has-no-record', [\App\Http\Controllers\AdminController::class,'usersHasNoRecord'])->name('users-has-no-record');
    Route::get('/users', [\App\Http\Controllers\AdminController::class,'usersHasRecord'])->name('users');
    Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');
});


