<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContinentController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\DosetteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PouetController;

//Connexion + TOKEN
Route::post('/login', [AuthController::class, 'login']);
Route::get('/check-token', [AuthController::class, 'checkToken']);
Route::get('/protected-route', [AuthController::class, 'checkToken'])->middleware('auth:api');


//GET infos
Route::get('/pays', [PaysController::class, 'getpays']);
Route::get('/pays-names', [PaysController::class, 'getPaysNames']);
Route::get('/marque', [MarqueController::class, 'getmarque']);
Route::get('/all', [PouetController::class, 'allDosette']);
Route::get('/showdosette/{id}', [PouetController::class, 'show']);


//Admin
Route::get('/admin', [AuthController::class, 'checkAdmin']);
Route::put('/update/{id}', [PouetController::class, 'update']);
Route::delete('/dosettes/{id}', [PouetController::class, 'destroy']);
Route::post('/store', [PouetController::class, 'store']);//Create dosette

//Trie +filtre
Route::get('/dosettes/sort', [PouetController::class, 'sortDosettesByName']);
Route::get('/filter', [PouetController::class, 'filterDosettes']);

//Commande + Adresse
Route::put('/utilisateur/{id}/adresse', [AuthController::class, 'updateAdresse']);
Route::get('/utilisateur/{id}/factures-produits', [AuthController::class, 'getFacturesProduits']);
Route::get('/utilisateur/{id}/adresse', [AuthController::class, 'getAdresse']);
Route::post('/utilisateur/{id}/commande', [CommandeController::class, 'enregistrerCommande']);
