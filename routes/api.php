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

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
    $user = User::where('email', $request->email)->first();
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

//register user
// store
Route::post('/register',[AuthenticationController::class, 'createAccount']);

//login user
// Route::get('/users',[UserController::class,'index']);
Route::post('/login',[AuthenticationController::class,'signin']);

//using middleware
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthenticationController::class, 'signout']);
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    // get by id
    Route::get('/users',[UserController::class,'show']);
    // update
    Route::post('/users',[UserController::class,'update']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
