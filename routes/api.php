<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminTeamController;
use App\Http\Controllers\DashboardAdminTeamMemberController;
use App\Http\Controllers\DashboardAdminUserController;
use App\Http\Controllers\TeamPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('lead')->group(function () {
            Route::resource('/user',DashboardAdminUserController::class);
            Route::resource('/team',DashboardAdminTeamController::class);
    
            Route::post('/teams/{teamId}/users', [DashboardAdminTeamMemberController::class, 'addUserToTeam']);
            Route::delete('/teams/{teamId}/users/{userId}', [DashboardAdminTeamMemberController::class, 'removeUserFromTeam']);

            Route::post('/teams/{team_id}/posts', [TeamPostController::class, 'store']);
            Route::put('/posts/{id}', [TeamPostController::class, 'update']);
            Route::delete('/posts/{id}', [TeamPostController::class, 'destroy']);
        });

        Route::get('/teams/{team_id}/posts', [TeamPostController::class, 'index']);
        Route::get('/posts/{id}', [TeamPostController::class, 'show']);
    });

});
