<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImagenController; 



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('index'); // Corrige aquí
    })->name('dashboard');
});


Route::get('/imagen/show', [ImagenController::class, 'show'])->name('imagen.show');
Route::get('/imagen/create', [ImagenController::class, 'crear'])->name('crear');
Route::post('/imagen/store/{id}',[ImagenController::class, 'store'])->name('imagen.store');


Route::get('/editar', [ImagenController::class, 'editar'])->name('editar');
Route::put('/imagen/update/{id}', [ImagenController::class, 'update'])->name('imagen.update');


Route::delete('/imagen/{id}', [ImagenController::class, 'destroy'])->name('imagen.destroy');

Route::get('/', [ImagenController::class, 'index'])->name('index');