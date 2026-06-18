<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Teacher',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        $class = ClassModel::updateOrCreate(
            ['name' => 'BSIT 2A'],
            [
                'teacher_id' => $admin->id,
                'room' => 'NET LAB',
                'schedule_day' => 'Monday',
                'start_time' => '08:00',
                'end_time' => '10:00',
            ]
        );

        $students = collect([
            ['student_number' => '2026-IT-0041', 'name' => 'Juan Dela Cruz', 'email' => 'juan@example.com', 'contact_number' => '09123456781'],
            ['student_number' => '2026-IT-0042', 'name' => 'Maria Santos', 'email' => 'maria@example.com', 'contact_number' => '09123456782'],
            ['student_number' => '2026-IT-0043', 'name' => 'Pedro Reyes', 'email' => 'pedro@example.com', 'contact_number' => '09123456783'],
        ])->map(fn ($data) => Student::updateOrCreate(
            ['email' => $data['email']],
            [
                'class_id' => $class->id,
                'student_number' => $data['student_number'],
                'name' => $data['name'],
                'contact_number' => $data['contact_number'],
                'qr_code' => (string) Str::uuid(),
            ]
        ));

        foreach ($students as $index => $student) {
            Attendance::updateOrCreate(
                [
                    'class_id' => $class->id,
                    'student_id' => $student->id,
                    'date' => now()->subDays($index)->toDateString(),
                ],
                [
                    'present' => $index === 1 ? 'late' : 'present',
                    'remarks' => $index === 1 ? 'Arrived after the scheduled start time.' : 'Seeded attendance record.',
                    'source' => 'manual',
                ]
            );
        }
    }
}
