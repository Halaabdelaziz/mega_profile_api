<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\User;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthenticationController;

//register user route
Route::post('/register',[AuthenticationController::class, 'createAccount']);

//login user route
Route::post('/login',[AuthenticationController::class,'signin']);

//using middleware 
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::post('/logout', [AuthenticationController::class, 'signout']);
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    // get user info by id
    Route::get('/users',[UserController::class,'show']);
    // update user info
    Route::post('/users',[UserController::class,'update']);
});