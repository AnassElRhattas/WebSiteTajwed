<?php

    namespace App\Http\Controllers\Student;

    use App\Http\Controllers\Controller;
    use App\Models\Lesson;
    use App\Models\Module;
    use App\Services\QuranApiService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Inertia\Inertia;

    class LessonController extends Controller
    {
        public function show(Module $module, Lesson $lesson)
        {
            // Verify lesson belongs to module
            if ($lesson->module_id !== $module->id) {
                abort(404);
            }

            $lesson->load(['module', 'audioResources', 'quiz']);

            $user = auth()->user();
            $lessonProgress = $user
                ->lessons()
                ->where('lesson_id', $lesson->id)
                ->first();

            $nextLesson = Lesson::where('module_id', $lesson->module_id)
                ->where('order', '>', $lesson->order)
                ->orderBy('order')
                ->first();

            return Inertia::render('Student/Lessons/Show', [
                'lesson' => array_merge($lesson->toArray(), [
                    'completed' => $lessonProgress?->pivot?->completed ?? false,
                    'next_lesson' => $nextLesson ? [
                        'id' => $nextLesson->id,
                        'title' => $nextLesson->title,
                    ] : null,
                    'verse_keys' => $lesson->verse_keys ?? [],
                ]),
            ]);
        }

        public function markAsCompleted(Lesson $lesson)
        {
            $user = auth()->user();

            $user->lessons()->syncWithoutDetaching([
                $lesson->id => [
                    'completed' => true,
                    'completed_at' => now(),
                ]
            ]);

            // Check for achievements
            $completedLessonsCount = $user
                ->lessons()
                ->wherePivot('completed', true)
                ->count();

            // Example achievement triggers
            if ($completedLessonsCount === 1) {
                $user->achievements()->attach(1);  // First lesson completed
            } elseif ($completedLessonsCount === 5) {
                $user->achievements()->attach(2);  // 5 lessons completed
            }

            return redirect()->back()->with('success', 'Lesson marked as completed!');
        }

        public function showChapters(QuranApiService $quran)
        {
            $chapters = $quran->getChapters();
            return response()->json($chapters);
        }

        public function index()
        {
            $user = auth()->user();
            $modules = $user
                ->modules()
                ->with(['lessons' => function ($query) use ($user) {
                    $query
                        ->withPivot('completed', 'completed_at')
                        ->orderBy('order');
                }])
                ->orderBy('order')
                ->get();

            return Inertia::render('Student/Lessons/Index', [
                'modules' => $modules,
            ]);
        }
    }
