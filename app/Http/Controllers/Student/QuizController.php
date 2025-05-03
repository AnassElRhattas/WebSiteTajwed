<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        $quiz->load('lesson');
        
        return Inertia::render('Student/Quizzes/Show', [
            'quiz' => array_merge($quiz->toArray(), [
                'questions' => $quiz->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'question' => $question->question,
                        'options' => $question->options,
                    ];
                }),
            ]),
        ]);
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $score = 0;
        $totalQuestions = $quiz->questions->count();
        $results = [];

        foreach ($quiz->questions as $question) {
            $userAnswer = $validated['answers'][$question->id] ?? null;
            $isCorrect = $userAnswer === $question->correct_answer;
            
            if ($isCorrect) {
                $score += (100 / $totalQuestions);
            }

            $results[$question->id] = [
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'explanation' => $question->explanation,
            ];
        }

        $score = round($score, 2);
        $passed = $score >= $quiz->passing_score;

        $attempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'answers' => $results,
            'passed' => $passed,
        ]);

        if ($passed) {
            // Check for achievements
            $passedQuizzes = auth()->user()->quizAttempts()
                ->where('passed', true)
                ->count();

            if ($passedQuizzes === 1) {
                auth()->user()->achievements()->attach(3); // First quiz passed
            } elseif ($passedQuizzes === 5) {
                auth()->user()->achievements()->attach(4); // 5 quizzes passed
            }
        }

        return Inertia::render('Student/Quizzes/Results', [
            'attempt' => $attempt->load('quiz'),
            'results' => $results,
        ]);
    }

    public function history()
    {
        $attempts = auth()->user()->quizAttempts()
            ->with('quiz.lesson')
            ->latest()
            ->paginate(10);

        return Inertia::render('Student/Quizzes/History', [
            'attempts' => $attempts,
        ]);
    }
}