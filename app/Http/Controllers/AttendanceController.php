<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $classId = $request->get('class_id');
        $date = $request->get('date');

        $attendanceRecords = Attendance::with(['student', 'classModel'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('student_number', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('present', $status))
            ->when($classId, fn ($query) => $query->where('class_id', $classId))
            ->when($date, fn ($query) => $query->whereDate('date', $date))
            ->latest('date')
            ->get();

        $classes = ClassModel::orderBy('name')->get();

        return view('attendance.index', compact('attendanceRecords', 'classes', 'search', 'status', 'classId', 'date'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        $students = Student::all();

        return view('attendance.create', compact('classes', 'students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => 'required|exists:class_models,id',
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'present' => 'required|in:present,absent,late',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $data['source'] = 'manual';

        Attendance::create($data);

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    public function show($id)
    {
        $attendance = Attendance::with(['student', 'classModel'])->findOrFail($id);

        return view('attendance.show', compact('attendance'));
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $classes = ClassModel::all();
        $students = Student::all();

        return view('attendance.edit', compact('attendance', 'classes', 'students'));
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $data = $request->validate([
            'class_id' => 'required|exists:class_models,id',
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'present' => 'required|in:present,absent,late',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $attendance->update($data);

        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully.');
    }

    public function scan()
    {
        return view('attendance.scan');
    }

    public function storeScan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $qrCode = $this->extractQrCode($request->qr_code);

        $student = Student::with('classModel')->where('qr_code', $qrCode)->first();

        if (!$student) {
            return back()->with('error', 'Student not found. Please scan a valid student QR code.');
        }

        $classId = $student->class_id ?? ClassModel::value('id');

        if (!$classId) {
            return redirect()->route('students.show', $student)
                ->with('error', 'Student profile found, but no class exists yet. Add a class first before recording attendance.');
        }

        $alreadyMarked = Attendance::where('student_id', $student->id)
            ->whereDate('date', Carbon::today())
            ->exists();

        if (!$alreadyMarked) {
            Attendance::create([
                'student_id' => $student->id,
                'class_id' => $classId,
                'date' => Carbon::today(),
                'present' => 'present',
                'remarks' => 'Marked using QR scanner.',
                'source' => 'qr',
            ]);

            return redirect()->route('students.show', $student)
                ->with('success', $student->name . ' marked present today.');
        }

        return redirect()->route('students.show', $student)
            ->with('error', 'Attendance already recorded today. Student profile loaded.');
    }

    private function extractQrCode(string $raw): string
    {
        $raw = trim($raw);

        $path = parse_url($raw, PHP_URL_PATH);

        if ($path && str_contains($path, '/scan/student/')) {
            return basename($path);
        }

        if ($path && str_contains($path, '/students/profile/')) {
            return basename($path);
        }

        return $raw;
    }
}
