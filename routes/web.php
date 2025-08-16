<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('posts.all');
});


Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/posts/all', [PostController::class, 'index'])->name('posts.all');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/save', [PostController::class, 'save'])->name('posts.save');
    Route::post('/posts/save/{id?}', [PostController::class, 'save'])->name('posts.save');
    Route::get('/posts/edit/{post}', [PostController::class, 'edit'])->name('posts.edit');
    Route::post('/posts/update/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::get('/posts/delete/{post}', [PostController::class, 'delete'])->name('posts.delete');

    Route::get('/categories/all', [CategoryController::class, 'index'])->name('categories.all');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/save', [CategoryController::class, 'save'])->name('categories.save');
    Route::post('/categories/save/{id?}', [CategoryController::class, 'save'])->name('categories.save');
    Route::get('/categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/delete/{category}', [CategoryController::class, 'delete'])->name('categories.delete');
});

require __DIR__.'/auth.php';


