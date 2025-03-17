<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContinentController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\DosetteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PouetController;

Route::post('/login', [AuthController::class, 'login']); // login

Route::get('/pays', [PaysController::class, 'getpays']); // pays marche
Route::get('/pays-names', [PaysController::class, 'getPaysNames']);

Route::get('/check-token', [AuthController::class, 'checkToken']); // Vérifier le token



Route::get('/marque', [MarqueController::class, 'getmarque']); // marque

Route::get('/all', [PouetController::class, 'allDosette']); // marche

Route::get('/filter', [PouetController::class, 'filterDosettes']); // marche

Route::post('/login', [AuthController::class, 'login']);

Route::get('/showdosette/{id}', [PouetController::class, 'show']);

// Route::middleware(['auth.token'])->group(function () {
    Route::post('/store', [PouetController::class, 'store']);
    Route::put('/update/{id}', [PouetController::class, 'update']);
    Route::delete('/dosettes/{id}', [PouetController::class, 'destroy']);
// });
