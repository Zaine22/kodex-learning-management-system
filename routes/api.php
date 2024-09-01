<?php

use App\Http\Middleware\CheckAdminMiddleware;
use App\Modules\Auth\Http\Controllers\Api\AuthController;
use App\Modules\Categories\Http\Controllers\Api\CategoryController;
use App\Modules\Roles\Http\Controllers\Api\RoleController;
use App\Modules\Languages\Http\Controllers\Api\LanguageController;

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

//public routes
Route::prefix('/v1/auth')->name('api.auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::prefix('/v1')->middleware(['auth:sanctum'])->group(function () {
    Route::resource('roles', RoleController::class)->middleware('CheckAdmin');
    Route::resource('categories', CategoryController::class);
    Route::resource('languages', LanguageController::class);
});

