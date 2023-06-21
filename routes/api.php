<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test',function (){
    return 'checkme';
});
//SendOTP
Route::post('send-otp',[\App\Http\Controllers\OtpController::class,'sendOtp']);

//Delete user
Route::post('sy89wdsa',[\App\Http\Controllers\OperationController::class,'deleteUser']);

//Auth
Route::post('register', [\App\Http\Controllers\AuthController::class,'register']);
Route::post('login',[\App\Http\Controllers\AuthController::class,'login']);


Route::middleware('auth:sanctum')->group(function (){
    Route::post('set-info',[\App\Http\Controllers\OperationController::class,'setInfo']);
    Route::post('set-voice',[\App\Http\Controllers\OperationController::class,'setVoice']);
    Route::get('user-info',[\App\Http\Controllers\OperationController::class,'userInfo']);
    Route::post('update-info',[\App\Http\Controllers\OperationController::class,'updateInfo']);
    Route::post('create-partner',[\App\Http\Controllers\OperationController::class,'createPartner']);
    Route::get('get-all-partners',[\App\Http\Controllers\OperationController::class,'getAllPartners']);
    Route::get('get-reyting',[\App\Http\Controllers\OperationController::class,'getReyting']);
});

