<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['lesson', 'questions'])->get();
        
        return Inertia::render('Admin/Quizzes/Index', [
            'quizzes' => $quizzes,
            'lessons' => Lesson::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
            'questions.*.points' => 'required|integer|min:1'
        ]);

        $quiz = Quiz::create([
            'lesson_id' => $validated['lesson_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'passing_score' => $validated['passing_score'],
            'is_active' => $validated['is_active']
        ]);

        foreach ($validated['questions'] as $questionData) {
            $quiz->questions()->create($questionData);
        }

        return redirect()->back()->with('success', 'Quiz created successfully');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean'
        ]);

        $quiz->update($validated);

        return redirect()->back()->with('success', 'Quiz updated successfully');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->back()->with('success', 'Quiz deleted successfully');
    }
}
