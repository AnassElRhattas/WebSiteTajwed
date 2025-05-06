<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModuleController extends Controller
{
    public function index()
    {
        // Load all modules with their lessons and user progress
        $modules = Module::with(['lessons.userProgress' => function($query) {
            $query->where('user_id', auth()->id());
        }])->get();

        return Inertia::render('Student/Modules/Index', [
            'modules' => $modules
        ]);
    }

    public function show(Module $module)
    {
        // Load the module with its lessons and user progress
        $module->load(['lessons' => function($query) {
            $query->orderBy('order');
        }]);

        // Get the authenticated user
        $user = auth()->user();
        
        // Get the user's completed lessons
        $completedLessons = $user->lessons()
            ->where('completed', true)
            ->pluck('lesson_id')
            ->toArray();

        // Add completed status to each lesson
        $module->lessons->transform(function ($lesson) use ($completedLessons) {
            $lesson->completed = in_array($lesson->id, $completedLessons);
            return $lesson;
        });

        return Inertia::render('Student/Modules/Show', [
            'module' => $module
        ]);
    }
}