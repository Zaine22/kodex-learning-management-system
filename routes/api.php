<?php

use App\Modules\Auth\Http\Controllers\Api\AuthController;
use App\Modules\Auth\Http\Controllers\Api\InstructorController;
use App\Modules\Categories\Http\Controllers\Api\CategoryController;
use App\Modules\Languages\Http\Controllers\Api\LanguageController;
use App\Modules\ProfessionalField\Http\Controller\Api\ProfessionalFieldController;
use App\Modules\Roles\Http\Controllers\Api\RoleController;
use App\Modules\User\Http\Controllers\Api\UserController as ApiUserController;
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
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/changePassword', [AuthController::class, 'changePassword'])->name('changePassword');
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('/v1')->group(function () {
        Route::post('instructor/create', [InstructorController::class, 'instructorCreate']);
    });

    Route::prefix('/v1')->group(function () {
        Route::resource('professionalField', ProfessionalFieldController::class);
    });

});

Route::prefix('/v1')->middleware(['auth:sanctum'])->group(function () {
    Route::resource('/users', ApiUserController::class);
    Route::resource('roles', RoleController::class)->middleware('CheckAdmin');
    Route::resource('categories', CategoryController::class);
    Route::resource('languages', LanguageController::class);
});
