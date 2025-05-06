<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class DashboardController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $completedLessons = $user->lessons()->wherePivot('lesson_completed', true)->count();
        $totalLessons = \App\Models\Lesson::count();
        
        $currentModule = $user->modules()
            ->with(['lessons' => function ($query) use ($user) {
                $query->withPivot('lesson_completed')
                    ->where('user_id', $user->id);
            }])
            ->orderBy('order')
            ->first();

        $currentModuleProgress = 0;
        if ($currentModule) {
            $completedModuleLessons = $currentModule->lessons
                ->where('pivot.lesson_completed', true)
                ->count();
            $totalModuleLessons = $currentModule->lessons->count();
            $currentModuleProgress = $totalModuleLessons > 0 
                ? ($completedModuleLessons / $totalModuleLessons) * 100 
                : 0;
        }

        $recentAchievements = $user->achievements()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($achievement) {
                return [
                    'id' => $achievement->id,
                    'title' => $achievement->title,
                    'description' => $achievement->description,
                    'earned_at' => $achievement->pivot->created_at->diffForHumans(),
                ];
            });

        $quizResults = $user->quizAttempts()
            ->with('quiz')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($attempt) {
                return [
                    'id' => $attempt->id,
                    'quiz_title' => $attempt->quiz->title,
                    'score' => $attempt->score,
                    'passed' => $attempt->score >= $attempt->quiz->passing_score,
                    'completed_at' => $attempt->created_at->diffForHumans(),
                ];
            });

        return Inertia::render('Student/Dashboard', [
            'overallProgress' => $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0,
            'completedLessons' => $completedLessons,
            'totalLessons' => $totalLessons,
            'currentModule' => $currentModule,
            'currentModuleProgress' => $currentModuleProgress,
            'recentAchievements' => $recentAchievements,
            'quizResults' => $quizResults,
        ]);
    }
}