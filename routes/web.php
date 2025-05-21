<?php

use App\Http\Controllers\AjaxTagController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/', [PostController::class, 'home']);
Route::get('posts/search', [PostController::class, 'search']);

Route::middleware('auth')->group(function () {
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/create', [PostController::class, 'create']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts/{id}/edit', [PostController::class, 'edit']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);

    Route::resource('users', UserController::class)->middleware('can:admin-control');
    Route::get('user/{id}/posts', [UserController::class, 'posts'])->name('user.posts')->middleware('can:admin-control');

    Route::resource('tags', TagController::class)->middleware('can:admin-control');
    Route::resource('ajax-tags', AjaxTagController::class)->middleware('can:admin-control');
});




Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
