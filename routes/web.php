<?php

require __DIR__.'/auth.php';

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use Illuminate\Support\Facades\Route;

// Root route
Route::get('/', function () {
    return view('welcome');
});

// Default dashboard route that redirects based on user role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('modules', ModuleController::class);
        Route::resource('lessons', LessonController::class);
        Route::resource('quizzes', QuizController::class);
    });

    // Student routes
    Route::name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        
        // Lessons
        Route::get('/lessons', [StudentLessonController::class, 'index'])->name('lessons.index');
        Route::get('/lessons/{lesson}', [StudentLessonController::class, 'show'])->name('lessons.show');
        Route::post('/lessons/{lesson}/complete', [StudentLessonController::class, 'markAsCompleted'])
            ->name('lessons.complete');

        // Quizzes
        Route::get('/quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('quizzes.show');
        Route::post('/quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');
        Route::get('/quiz-history', [StudentQuizController::class, 'history'])->name('quizzes.history');
    });
});
