<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\Backend\KategoriController;
use App\Http\Controllers\Backend\QuizController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth', Admin::class]], function() {
    Route::get('/', [BackendController::class, 'index']);

    Route::resource('kategori', KategoriController::class);
    Route::resource('quiz', QuizController::class);
});
