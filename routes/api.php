<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Auth\LoginController;
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

Route::post('auth/login', LoginController::class);

Route::prefix('tasks')->as('task')->group(function () {
    Route::get('', [TaskController::class, 'index'])->name('.all');
    Route::post('',  [TaskController::class, 'store'])->name('.store');
    Route::get('{task}',  [TaskController::class, 'show'])->name('.get');
    Route::put('{task}',  [TaskController::class, 'update'])->name('.update');
    Route::delete('{task}',  [TaskController::class, 'destroy'])->name('.destroy');
});
