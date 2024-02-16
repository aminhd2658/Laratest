<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SingleController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/single/{post}', [SingleController::class, 'index'])->name('single');
Route::middleware('auth:web')->post('/single/{post}/comment', [SingleController::class, 'comment'])->name('single.comment');

Auth::routes();
