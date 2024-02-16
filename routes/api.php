<?php

use App\Http\Controllers\API\SingleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->post('/single/{post}/comment', [SingleController::class, 'comment'])->name('api.single.comment');

