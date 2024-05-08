<?php

use App\Http\Controllers\FacebookLoginController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json([
        'msg' => 'hello'
    ]);
});

Route::get('auth/{provider}', [SocialiteController::class, 'loginSocial'])
    ->name('socialite.auth');

Route::get('auth/{provider}/callback', [SocialiteController::class, 'callbackSocial'])
    ->name('socialite.callback');
