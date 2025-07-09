<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/', [TodoController::class, 'index'])->name('todos.index');
Route::resource('todos', TodoController::class);
Route::patch('todos/{todo}/complete', [TodoController::class, 'complete'])->name('todos.complete');