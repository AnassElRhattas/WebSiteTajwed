<?php

require __DIR__.'/auth.php';

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Student\ModuleController as StudentModuleController;
use Illuminate\Support\Facades\Route;
use App\Services\QuranApiService;

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
    Route::middleware(['auth'])->name('student.')->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/student/progress', [StudentDashboardController::class, 'progress'])->name('progress');
        
        // Modules and Lessons
        Route::middleware(['auth'])->group(function () {
            Route::prefix('modules')->group(function () {
                Route::get('/{module}/lessons/{lesson}', [StudentLessonController::class, 'show'])
                    ->name('lessons.show');
                Route::post('/{module}/lessons/{lesson}/complete', [StudentLessonController::class, 'completeLesson'])->name('lessons.complete');
            });
        });
        
        // Student Modules (for direct module access)
        Route::get('/modules', [StudentModuleController::class, 'index'])->name('modules');
        Route::get('/modules/{module}', [StudentModuleController::class, 'show'])->name('modules.show');

        // Quizzes
        Route::get('/quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('quizzes.show');
        Route::post('/quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');
        Route::get('/quiz-history', [StudentQuizController::class, 'history'])->name('quizzes.history');

        // Achievements
        Route::get('/achievements', [StudentDashboardController::class, 'achievements'])->name('achievements');

        // Profile
        Route::get('/profile', [StudentDashboardController::class, 'edit'])->name('edit');
        // Route::patch('/profile', [StudentDashboardController::class, 'update'])->name('update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('destroy');

        // Settings
        Route::get('/settings', [StudentDashboardController::class, 'settings'])->name('settings');
        Route::post('/settings', [StudentDashboardController::class, 'updateSettings'])->name('settings.update');

        // Quran API
        Route::get('/chapters', [StudentLessonController::class, 'showChapters']);
        Route::get('/test-token', [QuranApiService::class, 'getAccessToken']);
    });
});
