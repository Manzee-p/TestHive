<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Backend\KategoriController;
use App\Http\Controllers\Backend\QuizController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\KelasController;
use App\Http\Controllers\Backend\MataPelajaranController;
use App\Http\Controllers\Backend\HasilUjianController;
use App\Http\Controllers\QuizSessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [FrontendController::class, 'index'])->name('dashboard');
    Route::get('/historiPengerjaan', [HasilUjianController::class, 'index'])->name('histori-pengerjaan');

    Route::post('/quiz/cek-kode', [FrontendController::class, 'checkKode'])->name('quiz.checkKode');
    Route::get('/quiz/{id}/detail', [FrontendController::class, 'detail'])->name('quiz.detail');
    Route::get('/quiz/{id}/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/{id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::post('/quiz/{id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/hasil/{id}', [QuizController::class, 'hasil'])->name('backend.quiz.hasil');
    Route::post('/quiz/{id}/session', [QuizSessionController::class, 'handleSession'])->name('quiz.session');
    Route::post('/quiz/{id}/complete', [QuizSessionController::class, 'completeSession'])->name('quiz.complete');

});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth', Admin::class]], function() {
    Route::get('/', [BackendController::class, 'index']);
    Route::resource('kategori', KategoriController::class);
    Route::resource('quiz', QuizController::class);
    Route::resource('users', UserController::class);
    Route::resource('kelas', KelasController::class);

    Route::get('/matapelajaran', [MataPelajaranController::class, 'index'])->name('matapelajaran.index');
    Route::post('/matapelajaran', [MataPelajaranController::class, 'store'])->name('matapelajaran.store');
    Route::put('/matapelajaran/{id}', [MataPelajaranController::class, 'update'])->name('matapelajaran.update');
    Route::delete('/matapelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('matapelajaran.destroy');
});
