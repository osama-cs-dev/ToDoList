<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'timer_hours'   => 'nullable|integer|min:0|max:23',
            'timer_minutes' => 'nullable|integer|min:0|max:59',
            'timer_seconds' => 'nullable|integer|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tasks', 'public');
        }

        $totalSeconds = (($request->timer_hours ?? 0) * 3600) + (($request->timer_minutes ?? 0) * 60);

        Task::create([
            'title'          => $request->title,
            'description'    => $request->description,
            'timer_seconds'  => $totalSeconds,
            'image'          => $imagePath,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added!');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'timer_hours'   => 'nullable|integer|min:0|max:23',
            'timer_minutes' => 'nullable|integer|min:0|max:59',
            'timer_seconds' => 'nullable|integer|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $task->image;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('tasks', 'public');
        }

        $totalSeconds = (($request->timer_hours ?? 0) * 3600) + (($request->timer_minutes ?? 0) * 60);

        $task->update([
            'title'          => $request->title,
            'description'    => $request->description,
            'timer_seconds'  => $totalSeconds,
            'image'          => $imagePath,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }

    public function toggle(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        return response()->json(['completed' => $task->completed]);
    }

    public function saveTimer(Request $request, Task $task)
    {
        $request->validate([
            'elapsed_seconds' => 'required|integer|min:0',
        ]);
        $task->update(['elapsed_seconds' => $request->elapsed_seconds]);
        return response()->json(['ok' => true]);
    }
}
