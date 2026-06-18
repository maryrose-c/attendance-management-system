<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $classId = $request->get('class_id');

        $students = Student::with(['classModel', 'attendance'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('student_number', 'like', "%{$search}%")
                        ->orWhere('contact_number', 'like', "%{$search}%");
                });
            })
            ->when($classId, fn ($query) => $query->where('class_id', $classId))
            ->latest()
            ->get();

        $classes = ClassModel::orderBy('name')->get();

        return view('students.index', compact('students', 'classes', 'search', 'classId'));
    }

    public function create()
    {
        $classes = ClassModel::latest()->get();

        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => 'nullable|exists:class_models,id',
            'student_number' => 'nullable|string|max:100|unique:students,student_number',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'contact_number' => 'nullable|string|max:30',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['qr_code'] = (string) Str::uuid();
        $data['photo_path'] = $this->storePhoto($request);
        unset($data['photo']);

        Student::create($data);

        return redirect()->route('students.index')
            ->with('success', 'Student added successfully. QR code is ready.');
    }

    public function show(Student $student)
    {
        $student->load(['classModel', 'attendance.classModel']);

        $total = $student->attendance()->count();
        $present = $student->attendance()->where('present', 'present')->count();
        $absent = $student->attendance()->where('present', 'absent')->count();
        $late = $student->attendance()->where('present', 'late')->count();
        $rate = $total > 0 ? round(($present / $total) * 100, 2) : 0;

        $recentAttendance = $student->attendance()
            ->with('classModel')
            ->latest('date')
            ->take(10)
            ->get();

        return view('students.profile', compact(
            'student',
            'total',
            'present',
            'absent',
            'late',
            'rate',
            'recentAttendance'
        ));
    }

    public function profileByQr(string $qrCode)
    {
        $student = Student::where('qr_code', $qrCode)->firstOrFail();

        return $this->show($student);
    }

    public function qrCard(Student $student)
    {
        $student->load('classModel');

        $profileUrl = route('students.profile.qr', $student->qr_code);

        return view('students.qr-card', compact('student', 'profileUrl'));
    }

    public function qrCards()
    {
        $students = Student::with('classModel')->orderBy('name')->get();

        return view('students.qr-cards', compact('students'));
    }

    public function qrImage(Student $student)
    {
        $profileUrl = route('students.profile.qr', $student->qr_code);

        return response(
            QrCode::format('svg')->size(320)->margin(2)->generate($profileUrl),
            200,
            ['Content-Type' => 'image/svg+xml']
        );
    }

    public function edit(Student $student)
    {
        $classes = ClassModel::latest()->get();

        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'class_id' => 'nullable|exists:class_models,id',
            'student_number' => 'nullable|string|max:100|unique:students,student_number,' . $student->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'contact_number' => 'nullable|string|max:30',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $newPhoto = $this->storePhoto($request, $student->photo_path);
        if ($newPhoto) {
            $data['photo_path'] = $newPhoto;
        }
        unset($data['photo']);

        $student->update($data);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->photo_path && File::exists(public_path($student->photo_path))) {
            File::delete(public_path($student->photo_path));
        }

        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    private function storePhoto(Request $request, ?string $oldPhoto = null): ?string
    {
        if (!$request->hasFile('photo')) {
            return null;
        }

        if ($oldPhoto && File::exists(public_path($oldPhoto))) {
            File::delete(public_path($oldPhoto));
        }

        $folder = public_path('uploads/students');
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $file = $request->file('photo');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $filename);

        return 'uploads/students/' . $filename;
    }
}
