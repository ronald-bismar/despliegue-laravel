<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Categoria;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentasController;
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


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::apiResource('ventas', VentasController::class);
Route::apiResource('categoria', Categoria::class);


Route::middleware(['auth:sanctum'])->group(function(){
//forma para llamar de general
    Route::delete('/users/{id}', [AuthController::class, 'delete']);
    Route::patch('/users/{id}', [AuthController::class, 'update']);
    Route::get('list', [AuthController::class, 'list']);
    
    Route::apiResource('producto', ProductoController::class);
    Route::post('productoFecha', [ProductoController::class, 'consultaFecha']);
    Route::get('logout', [AuthController::class, 'logout']);
});

//empoints son para llamar mas espcifcios o por grupo
/*Route::get('categoria', [Categoria::class, 'index']);
Route::get('categoria/{id}', [Categoria::class, 'show']);
Route::post('categoria', [Categoria::class, 'store']);
Route::put('categoria/{id}', [Categoria::class, 'update']);
Route::delete('categoria/{id}', [Categoria::class, 'destroy']);*/

