<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LearningController extends Controller
{
    public function modules()
    {
        $modules = Module::with(['lessons' => function($query) {
            $query->where('is_active', true);
        }])->where('is_active', true)->orderBy('order')->get();

        return Inertia::render('Student/Modules/Index', [
            'modules' => $modules
        ]);
    }

    public function lessons(Module $module)
    {
        $lessons = $module->lessons()
            ->where('is_active', true)
            ->orderBy('order')
            ->with(['quiz', 'audioResources'])
            ->get();

        return Inertia::render('Student/Lessons/Index', [
            'module' => $module,
            'lessons' => $lessons
        ]);
    }

    public function showLesson(Lesson $lesson)
    {
        $lesson->load(['module', 'quiz', 'audioResources']);
        
        return Inertia::render('Student/Lessons/Show', [
            'lesson' => $lesson
        ]);
    }

    public function completeLesson(Request $request, Lesson $lesson)
    {
        UserProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lesson_id' => $lesson->id
            ],
            [
                'lesson_completed' => true,
                'completed_at' => now()
            ]
        );

        return redirect()->back()->with('success', 'Lesson completed successfully');
    }

    public function showQuiz(Quiz $quiz)
    {
        $quiz->load(['questions', 'lesson']);
        
        return Inertia::render('Student/Quizzes/Show', [
            'quiz' => $quiz
        ]);
    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string'
        ]);

        $score = 0;
        $questions = $quiz->questions;

        foreach ($questions as $question) {
            if (isset($validated['answers'][$question->id]) && 
                $validated['answers'][$question->id] === $question->correct_answer) {
                $score += $question->points;
            }
        }

        $finalScore = ($score / $questions->sum('points')) * 100;

        UserProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'quiz_id' => $quiz->id,
                'lesson_id' => $quiz->lesson_id
            ],
            [
                'quiz_completed' => true,
                'quiz_score' => $finalScore,
                'completed_at' => now()
            ]
        );

        return redirect()->back()->with([
            'success' => 'Quiz submitted successfully',
            'score' => $finalScore
        ]);
    }
}
