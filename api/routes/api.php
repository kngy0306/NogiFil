<?php

use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('video', [VideoController::class, 'index'])->name('video');
Route::get('video/{tag_name}', [VideoController::class, 'getVideosByTagname']);