<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('lessons')->orderBy('order')->get();
        return Inertia::render('Admin/Modules/Index', [
            'modules' => $modules
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        Module::create($validated);

        return redirect()->back()->with('success', 'Module created successfully');
    }

    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $module->update($validated);

        return redirect()->back()->with('success', 'Module updated successfully');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->back()->with('success', 'Module deleted successfully');
    }
}
