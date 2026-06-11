<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete']);
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit']);
Route::patch('/tasks/{task}', [TaskController::class, 'update']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
Route::get('/tasks/completed', [TaskController::class, 'completed']);
Route::get('/tasks/report', [TaskController::class, 'report']);