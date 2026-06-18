<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $classes = ClassModel::with(['teacher', 'students'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('room', 'like', "%{$search}%")
                    ->orWhere('schedule_day', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('classes.index', compact('classes', 'search'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'room' => 'nullable|string|max:255',
            'schedule_day' => 'nullable|string|max:50',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);

        $data['teacher_id'] = Auth::id();
        ClassModel::create($data);

        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function edit(ClassModel $classModel)
    {
        return view('classes.edit', compact('classModel'));
    }

    public function update(Request $request, ClassModel $classModel)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'room' => 'nullable|string|max:255',
            'schedule_day' => 'nullable|string|max:50',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);

        $classModel->update($data);

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(ClassModel $classModel)
    {
        $classModel->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Class deleted successfully.');
    }

    public function show(ClassModel $classModel)
    {
        return redirect()->route('classes.index');
    }
}
