<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\TodosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', [ApiController::class, 'health']);

Route::get('/todos', [TodosController::class, 'index']);
Route::post('/todos', [TodosController::class, 'store']);
Route::get('/todos/{id}', [TodosController::class, 'show']);
Route::put('/todos/{id}', [TodosController::class, 'update']);
Route::delete('/todos/{id}', [TodosController::class, 'destroy']);
