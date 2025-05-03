<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use App\Models\Quiz;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalModules' => Module::count(),
            'totalLessons' => Lesson::count(),
            'totalQuizzes' => Quiz::count(),
            'totalStudents' => User::where('role', 'student')->count(),
        ];

        $recentActivity = User::with('lessons')
            ->where('role', 'student')
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar' => $user->profile_photo_url,
                    ],
                    'description' => 'Completed lesson: ' . $user->lessons->last()?->title,
                    'created_at' => $user->lessons->last()?->pivot->completed_at?->diffForHumans(),
                ];
            });

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity,
        ]);
    }
}