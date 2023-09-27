<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::get('/servidores', [UserController::class, 'index']);
Route::get('/servidor/{matriculaSiape}', [UserController::class, 'show']);
Route::put('/servidor/{matriculaSiape}', [UserController::class, 'update']);
Route::delete('/servidor/{matriculaSiape}', [UserController::class, 'delete']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
