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

Route::middleware('auth')->get('/voices', [\App\Http\Controllers\Auth\LoginController::class,'voices'])->name('voices');
Route::middleware('auth')->get('/admin', [\App\Http\Controllers\Auth\LoginController::class,'admin'])->name('admin');



