<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\Attendance;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard with Analytics Logic
Route::get('/dashboard', function () {
    $totalClasses = ClassModel::count();
    $totalStudents = Student::count();
    $totalAttendance = Attendance::count();

    $presentToday = Attendance::whereDate('date', today())->where('present', 'present')->count();
    $absentToday  = Attendance::whereDate('date', today())->where('present', 'absent')->count();
    $lateToday    = Attendance::whereDate('date', today())->where('present', 'late')->count();

    $presentCount = Attendance::where('present', 'present')->count();
    $absentCount = Attendance::where('present', 'absent')->count();
    $lateCount = Attendance::where('present', 'late')->count();
    $attendanceRate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 2) : 0;

    $lastSevenDays = collect(range(6, 0))->map(function ($daysAgo) {
        $date = today()->subDays($daysAgo);

        return [
            'label' => $date->format('M d'),
            'present' => Attendance::whereDate('date', $date)->where('present', 'present')->count(),
            'absent' => Attendance::whereDate('date', $date)->where('present', 'absent')->count(),
            'late' => Attendance::whereDate('date', $date)->where('present', 'late')->count(),
        ];
    })->values();

    $topStudents = Student::withCount([
        'attendance as present_count' => fn ($query) => $query->where('present', 'present'),
        'attendance as total_logs_count'
    ])->orderByDesc('present_count')->take(5)->get();

    $lowAttendanceStudents = Student::withCount([
        'attendance as present_count' => fn ($query) => $query->where('present', 'present'),
        'attendance as total_logs_count'
    ])->get()->filter(function ($student) {
        return $student->total_logs_count > 0
            && (($student->present_count / $student->total_logs_count) * 100) < 75;
    })->take(5);

    return view('dashboard', compact(
        'totalClasses', 'totalStudents', 'totalAttendance',
        'presentToday', 'absentToday', 'lateToday', 'attendanceRate',
        'presentCount', 'absentCount', 'lateCount', 'lastSevenDays', 'topStudents', 'lowAttendanceStudents'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');


// Authenticated Users Group
Route::middleware(['auth'])->group(function () {

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student QR/profile routes
    Route::get('/student-profile/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/qr-cards/print', [StudentController::class, 'qrCards'])->name('students.qr.cards');
    Route::get('/students/{student}/qr-card', [StudentController::class, 'qrCard'])->name('students.qr.card');
    Route::get('/students/{student}/qr', [StudentController::class, 'qrImage'])->name('students.qr');
    Route::get('/scan/student/{qrCode}', [StudentController::class, 'profileByQr'])->name('students.profile.qr');
    Route::post('/scan/student', [AttendanceController::class, 'storeScan'])->name('students.scan.store');

    // QR Scanner Routes
    Route::get('/attendance/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');
    Route::post('/attendance/scan', [AttendanceController::class, 'storeScan'])->name('attendance.storeScan');

    // Attendance Resource
    Route::resource('attendance', AttendanceController::class);

    // Reports with import/export
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/import', [ReportController::class, 'importForm'])->name('reports.import');
    Route::post('/reports/import/students', [ReportController::class, 'importStudents'])->name('reports.import.students');
    Route::get('/reports/export/{format}', [ReportController::class, 'export'])->name('reports.export');
});


// Admin Only Group
Route::middleware(['auth', 'admin'])->group(function () {

    // Classes
    Route::resource('classes', ClassController::class)
        ->parameters(['classes' => 'classModel']);

    // Students
    Route::resource('students', StudentController::class)->except(['show']);
});

require __DIR__.'/auth.php';