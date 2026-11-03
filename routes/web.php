<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/books', [BookController::class, 'index'])
        ->middleware('permission:books.view')->name('books.index');

    Route::middleware('permission:books.create')->group(function () {
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
    });

    Route::middleware('permission:books.update')->group(function () {
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    });

    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->middleware('permission:books.delete')->name('books.destroy');

    Route::get('/books/{book}', [BookController::class, 'show'])
        ->middleware('permission:books.view')->name('books.show');

    Route::middleware('permission:users.manage-roles')->group(function () {
        Route::get('/users', [UserRoleController::class, 'index'])->name('users.index');
        Route::put('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.role.update');
    });
});

require __DIR__.'/auth.php';
