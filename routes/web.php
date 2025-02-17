<?php

use App\Http\Controllers\TodoController;
use App\Models\Todo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [TodoController::class, 'index'])->name('index');
Route::post('/store', [TodoController::class, 'store'])->name('store');
Route::get('/edit/{id}', [TodoController::class, 'edit'])->name('edit');
Route::put('/update/{id}', [TodoController::class, 'update'])->name('update');
Route::post('/update-status/{id}', [TodoController::class, 'updateStatus'])->name('updateStatus');
Route::delete('/destroy/{id}', [TodoController::class, 'destroy'])->name('destroy');