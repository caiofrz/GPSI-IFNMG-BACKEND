<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PortariaController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Registered;
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


Route::get('/servidor/{matriculaSiape}/minhasPortarias', [UserController::class, 'minhasPortarias']);

Route::get('/relatorio/ranking', [RelatoriosController::class, 'ranking']);
Route::get('/relatorio/portarias/publicas', [RelatoriosController::class, 'portariasPublicas']);
Route::get('/relatorio/portarias/privadas', [RelatoriosController::class, 'portariasPrivadas']);
Route::get('/relatorio/portarias/permanentes', [RelatoriosController::class, 'portariasPermanentes']);



Route::middleware(['admin', 'superAdmin'])->group(function () {

    Route::get('/servidores', [UserController::class, 'index']);
    Route::get('/servidor/{matriculaSiape}', [UserController::class, 'show']);
    Route::post('/servidor', [RegisteredUserController::class, 'store']);
    Route::put('/servidor/{matriculaSiape}', [UserController::class, 'update']);
    Route::delete('/servidor/{matriculaSiape}', [UserController::class, 'delete']);

    Route::get('/portarias', [PortariaController::class, 'index']);
    Route::get('/portaria/{numeroPortaria}', [PortariaController::class, 'show']);
    Route::get('/portaria/{numeroPortaria}/documento', [PortariaController::class, 'getDocumento']);
    Route::post('/portaria', [PortariaController::class, 'store']);
    Route::put('/portaria/{numeroPortaria}', [PortariaController::class, 'update']);
    Route::delete('/portaria/{numeroPortaria}', [PortariaController::class, 'delete']);
});


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
