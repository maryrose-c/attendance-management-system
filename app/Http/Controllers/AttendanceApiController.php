<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    public function index(Request $request) {
        // When a user accidentally opens /api/attendance in a browser,
        // show the normal styled Attendance History page instead of a raw API error.
        if (str_contains($request->header('accept', ''), 'text/html')) {
            return redirect('/attendance');
        }

        return response()->json([
            'message' => 'Attendance records retrieved successfully.',
            'data' => Attendance::with(['student', 'classModel'])->latest()->get(),
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'class_id' => 'required|exists:class_models,id',
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'present' => 'required|in:present,absent,late',
            'remarks' => 'nullable|string|max:1000',
            'source' => 'nullable|string|max:50',
        ]);

        $data['source'] = $data['source'] ?? 'api';
        $attendance = Attendance::create($data);
        return response()->json($attendance, 201);
    }

    public function show($id) {
        return Attendance::with(['student', 'classModel'])->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $attendance = Attendance::findOrFail($id);

        $data = $request->validate([
            'class_id' => 'required|exists:class_models,id',
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'present' => 'required|in:present,absent,late',
            'remarks' => 'nullable|string|max:1000',
            'source' => 'nullable|string|max:50',
        ]);

        $attendance->update($data);
        return response()->json($attendance);
    }

    public function destroy($id) {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return response()->json(['message' => 'Attendance deleted successfully.']);
    }
}