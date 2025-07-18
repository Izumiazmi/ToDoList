<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\TodoController;

Route::get('/ToDoList', [TodoController::class, 'index'])->name('todo.index');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
Route::get('/ToDoList/filter/{status}', [TodoController::class, 'filter'])->name('todo.filter');
Route::put('/ToDoList/{id}', [TodoController::class, 'update'])->name('todos.update');