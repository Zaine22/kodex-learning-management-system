<?php

use App\Modules\Auth\Http\Controllers\Api\AuthController;
use App\Modules\Auth\Http\Controllers\Api\ProfessionalFieldController;
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

Route::prefix('/v1/auth')->name('api.auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/changePassword',[AuthController::class,'changePassword'])->name('changePassword');

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('/v1')->group(function () {
        Route::resource('professionalField', ProfessionalFieldController::class);
    });
});
