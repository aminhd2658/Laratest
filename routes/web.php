<?php

use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SingleController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/single/{post}', [SingleController::class, 'index'])->name('single');
Route::middleware('auth:web')->post('/single/{post}/comment', [SingleController::class, 'comment'])->name('single.comment');


Route::prefix('admin')->middleware('admin')->group(function () {
    Route::resource('post', PostsController::class)->except('show');
    Route::resource('tag', TagsController::class)->except('show');
});

Auth::routes();
