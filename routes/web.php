<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HasilUjianController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizSessionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', function () {
    $user = Auth::user();
    
    if ($user) {
        if ($user->isAdmin == '1' || $user->isAdmin == '2') {
            // Admin diarahkan langsung ke dashboard
            return redirect()->route('dashboard');
        } else {
            // User biasa diarahkan ke halaman welcome terlebih dahulu
            return redirect('/');
        }
    }
    
    return redirect()->route('login');
})->middleware('auth')->name('home');


// Quiz routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [FrontendController::class, 'index'])->name('dashboard');
    Route::get('/historiPengerjaan', [HasilUjianController::class, 'index'])->name('histori-pengerjaan');

    Route::get('/quiz/{id}/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/{id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/hasil/{id}', [QuizController::class, 'hasil'])->name('quiz.hasil');
    Route::post('/quiz/{id}/session', [QuizSessionController::class, 'handleSession'])->name('quiz.session');
    Route::post('/quiz/{id}/complete', [QuizSessionController::class, 'completeSession'])->name('quiz.complete');
    Route::post('/quiz/cek-kode', [FrontendController::class, 'checkKode'])->name('quiz.checkKode');
    Route::get('/quiz/{id}/detail', [FrontendController::class, 'detail'])->name('quiz.detail');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', Admin::class]], function () {
    Route::get('/', [BackendController::class, 'index'])->name('admin.quiz-terbaru');
    Route::get('/dashboard', [BackendController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('quiz', QuizController::class);
    Route::patch('/quiz/{id}/toggle-aktivasi', [QuizController::class, 'toggleAktivasi'])->name('quiz.toggleAktivasi');

    Route::get('/hasil-keseluruhan', [QuizController::class, 'hasilKeseluruhan'])->name('quiz.hasil.keseluruhan');
    Route::get('/hasil/{hasilId}/detail-admin', [QuizController::class, 'detailHasilAdmin'])->name('quiz.hasil.detail');
    Route::delete('/hasil/{hasilId}/hapus', [QuizController::class, 'hapusHasil'])->name('quiz.hasil.hapus');

    Route::prefix('quiz/essay')->name('quiz.essay.')->group(function () {
        // Main grading page
        Route::get('/grading', [QuizController::class, 'essayGrading'])->name('grading');
        
        // Single essay grading
        Route::get('/grade/{detailId}', [QuizController::class, 'gradeEssay'])->name('grade');
        Route::post('/grade/{detailId}', [QuizController::class, 'storeEssayGrade'])->name('store-grade');
        
        // Multiple essays grading
        Route::post('/grade-multiple', [QuizController::class, 'gradeMultipleEssay'])->name('grade-multiple');
        Route::get('/grade-user/{userId}', [QuizController::class, 'gradeUserEssays'])->name('grade-user');
        
        // Statistics
        Route::get('/stats', [QuizController::class, 'essayGradingStats'])->name('stats');
        
        // Mass grading untuk soal tertentu
        Route::get('/mass-grade/{soal}', [QuizController::class, 'massGradeEssay'])->name('mass-grade');
    });

    Route::resource('kategori', KategoriController::class);
    Route::resource('users', UserController::class);
    Route::resource('matapelajaran', MataPelajaranController::class);
    Route::resource('kelas', KelasController::class);
});