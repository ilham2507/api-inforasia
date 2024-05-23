<?php

use App\Http\Controllers\authentication;
use App\Http\Controllers\login;
use App\Http\Controllers\PenerimaProyekController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskProyekController;
use App\Http\Controllers\UserController;
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

// view
Route::get('/tes', [authentication::class, 'index']);

// login
Route::post('/login', [authentication::class, 'login']);

//logout
Route::get('/logout', [authentication::class, 'logout'])->middleware(['auth:sanctum']);

//cek user on
Route::get('/aktif', [authentication::class, 'aktif'])->middleware(['auth:sanctum']);

//user API
Route::get('/users', [UserController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/users-manager', [UserController::class, 'getManager'])->middleware(['auth:sanctum']);
Route::get('/users/{id}', [UserController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/users', [UserController::class, 'store'])->middleware(['auth:sanctum']);
Route::post('/users-update/{id}', [UserController::class, 'update'])->middleware(['auth:sanctum']);
Route::post('/users-delete/{id}', [UserController::class, 'destroy'])->middleware(['auth:sanctum']);

// proyek api
Route::get('/proyeks', [ProyekController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/recent', [ProyekController::class, 'recent'])->middleware(['auth:sanctum']);
Route::get('/proyeks/{id}', [ProyekController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/proyeks', [ProyekController::class, 'store'])->middleware(['auth:sanctum']);
Route::get('/proyeks-count', [ProyekController::class, 'getProyek'])->middleware(['auth:sanctum']);
Route::get('/proyeks-chart', [ProyekController::class, 'getProyekChart'])->middleware(['auth:sanctum']);
Route::post('/proyeks-update/{id}', [ProyekController::class, 'update'])->middleware(['auth:sanctum']);
Route::post('/proyeks-delete/{id}', [ProyekController::class, 'destroy'])->middleware(['auth:sanctum']);

// task Proyek API
Route::get('/tasks', [TaskProyekController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/tasks/{id}', [TaskProyekController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/tasks', [TaskProyekController::class, 'store'])->middleware(['auth:sanctum']);
Route::post('/tasks-update/{id}', [TaskProyekController::class, 'update'])->middleware(['auth:sanctum']);
Route::post('/tasks-delete/{id}', [TaskProyekController::class, 'destroy'])->middleware(['auth:sanctum']);

//penerima Proyek API
Route::get('/penerima-proyeks', [PenerimaProyekController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/penerima-proyeks/{id}', [PenerimaProyekController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/penerima-proyeks', [PenerimaProyekController::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/penerima-proyeks/{id}', [PenerimaProyekController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/penerima-proyeks/{id}', [PenerimaProyekController::class, 'destroy'])->middleware(['auth:sanctum']);

//role API
Route::get('/roles', [RoleController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/roles/{id}', [RoleController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/roles', [RoleController::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/roles/{id}', [RoleController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->middleware(['auth:sanctum']);
