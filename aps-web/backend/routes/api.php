<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OurServiceController;
use App\Http\Controllers\SupportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|lang
*/

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::get('/news', [NewsController::class, 'index']);
    // Route::get('/our-services', [OurServiceController::class, 'index']);
    Route::post('/send', [SupportController::class, 'store']);
    Route::get('/messages', [SupportController::class, 'index']);
    Route::get('/messages-admin/{id}', [SupportController::class, 'getMessage']);
    Route::post('response-message', [SupportController::class, 'responseMessage']);
    Route::get('/profile-me', [SupportController::class, 'profile']);
    Route::get('/statistics', [SupportController::class, 'statistics']);
    Route::get('/chart', [SupportController::class, 'chart']);
    Route::get('/chart_all', [SupportController::class, 'currentUser']);

    Route::get('/people', [SupportController::class, 'people']);
    Route::get('/user', [\App\Http\Controllers\UserManagement\UserManagementController::class, 'user']);
    Route::post('/change-password', [\App\Http\Controllers\UserManagement\UserManagementController::class, 'changePassword']);

    Route::group(['prefix' => 'user-management'], function () {
        Route::resource('users', \App\Http\Controllers\UserManagement\UserManagementController::class);
        Route::resource('customers', \App\Http\Controllers\UserManagement\CustomersController::class);
        Route::resource('suppliers', \App\Http\Controllers\UserManagement\SupplierController::class);
        Route::resource('roles', \App\Http\Controllers\UserManagement\RoleController::class);

        Route::middleware(['isSuperAdmin'])->group(function () {
            Route::resource('permission-groups', \App\Http\Controllers\UserManagement\PermissionGroupController::class);
            Route::post('permission-groups/update-order', [\App\Http\Controllers\UserManagement\PermissionGroupController::class, 'updatePermissionSort']);
            Route::resource('permission', \App\Http\Controllers\UserManagement\PermissionController::class);
        });

        Route::group(['prefix' => 'activity-log'], function () {
            Route::get('', [\App\Http\Controllers\UserManagement\ActivityLogController::class, 'index']);
            Route::get('user-log/{user}', [\App\Http\Controllers\UserManagement\ActivityLogController::class, 'getUserLog']);
            Route::get('{log}', [\App\Http\Controllers\UserManagement\ActivityLogController::class, 'getActivityLog']);
            Route::post('restore-log/{log}', [\App\Http\Controllers\UserManagement\ActivityLogController::class, 'restoreLog']);
        });


        Route::get('login-log', [\App\Http\Controllers\UserManagement\UserManagementController::class, 'loginLog']);
    });

    Route::group(['prefix' => 'configurations'], function () {

        Route::resource('languages', \App\Http\Controllers\Configurations\LanguagesController::class);
        Route::resource('language/words', \App\Http\Controllers\Configurations\LanguageWordController::class);
        Route::get('backup/run', [\App\Http\Controllers\Configurations\BackupController::class, 'run']);
        Route::get('backup/list', [\App\Http\Controllers\Configurations\BackupController::class, 'list']);
        Route::post('backup/change', [\App\Http\Controllers\Configurations\BackupController::class, 'change']);
        Route::delete('backup/delete/{db}', [\App\Http\Controllers\Configurations\BackupController::class, 'delete']);
        Route::resource('backup', \App\Http\Controllers\Configurations\BackupController::class);
    });

    Route::resource('notifications', \App\Http\Controllers\NotificationController::class);
});
Route::get('language/words', [\App\Http\Controllers\Configurations\LanguagesController::class, 'languageWords']);
Route::middleware('auth:sanctum')->post('/logout', [\App\Http\Controllers\UserManagement\UserManagementController::class, 'logout']);

Route::post('/login', [\App\Http\Controllers\UserManagement\UserManagementController::class, 'login']);
Route::any('general/{what}', [\App\Http\Controllers\GeneralController::class, "what"]);

// routes/api.php
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
