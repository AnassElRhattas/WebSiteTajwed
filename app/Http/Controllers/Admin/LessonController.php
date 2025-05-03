<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Lessons/Index', [
            'lessons' => Lesson::with('module', 'audioResources')->get(),
            'modules' => Module::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'explanation' => 'required|string',
            'order' => 'required|integer|min:0',
            'audio' => 'nullable|file|mimes:mp3,wav',
        ]);

        $lesson = Lesson::create($validated);

        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('audio', 'public');
            $lesson->audioResources()->create([
                'title' => $lesson->title . ' Audio',
                'file_path' => $path,
            ]);
        }

        return redirect()->back()->with('success', 'Lesson created successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->back()->with('success', 'Lesson deleted successfully.');
    }
}
