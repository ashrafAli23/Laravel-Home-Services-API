<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\ServicesCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/**
 * User Routes
 */
Route::prefix('user')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        // User profile
        Route::get("/profile", [UserController::class, 'profile']);
        Route::post("/profile/update", [UserController::class, 'updateProfile']);

        /**
         * User Logout Route
         */
        Route::get('logout', [AuthController::class, 'logout']);
    });
});
//  =======================================

/**
 * Service Provider Routes
 */

Route::prefix('service-provider')->group(function () {
    // get service provider profile for user
    Route::get('/details', [ServiceProviderController::class, 'getProfileDetailes']);

    Route::middleware(['auth:sanctum', 'service_provider'])->group(function () {
        // create services
        Route::post('/create-service', [ServiceProviderController::class, 'createService']);

        Route::get("/profile", [UserController::class, 'profile']);
        Route::post("/profile/update", [UserController::class, 'updateProfile']);
    });
});

//  =======================================

/**
 * Admin Routes
 */
Route::prefix('admin')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        /**
         * Admin service category
         */
        Route::prefix('services-category')->group(function () {
            Route::get('/', [ServicesCategoryController::class, 'getByPaginate']);
            Route::post('/add', [ServicesCategoryController::class, 'addNewCategory']);
            Route::put('/{id}', [ServicesCategoryController::class, 'updateCategory']);
            Route::delete('/{id}', [ServicesCategoryController::class, 'deleteCategory']);
        });

        /**
         * Admin services
         */
        Route::get('/{category_slug}/services', [ServiceController::class, 'getServicesByCategory']);
        Route::prefix('services')->group(function () {
            Route::get('/', [ServiceController::class, 'getByPaginate']);
            Route::post('/add', [ServiceController::class, 'addNewService']);
            Route::put('/{service_slug}', [ServiceController::class, 'updateService']);
            Route::delete('/{service_id}', [ServiceController::class, 'deleteService']);
        });

        /**
         * Admin Logout
         */
        Route::get('logout', [AuthController::class, 'logout']);
    });
});
//  =======================================

/**
 * Services CAtegory Route
 */
Route::get("/services-category", [ServicesCategoryController::class, 'index']);

//  =======================================
