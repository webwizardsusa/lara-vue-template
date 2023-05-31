<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;

//Authetication
Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResources([
        'users' => UserController::class,
        'posts' => PostController::class
    ]);
});
