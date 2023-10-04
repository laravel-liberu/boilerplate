<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\JsonResponse;


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

Route::namespace('Auth')
    ->middleware('api')
    ->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('login/{provider}', fn($provider) => (new LoginController())->redirectToProvider($provider))->name('login.provider');
            Route::get('login/{provider}/callback', fn($provider): JsonResponse => (new LoginController())->handleProviderCallback($provider))->name('login.provider.callback');

            Route::post('login', fn(Request $request) => (new LoginController())->login($request))->name('login');
        });

    });