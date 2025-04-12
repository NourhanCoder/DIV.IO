<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/',[PostController::class, 'home']);

Route::get('posts',[PostController::class, 'index']);
Route::get('posts/create',[PostController::class,'create']);
Route::get('posts/search',[PostController::class, 'search']);
Route::get('posts/{id}',[PostController::class, 'show']);
Route::post('posts',[PostController::class,'store']);
Route::get('posts/{id}/edit',[PostController::class,'edit']);
Route::put('posts/{id}',[PostController::class,'update']);
Route::delete('posts/{id}', [PostController::class,'destroy']);




