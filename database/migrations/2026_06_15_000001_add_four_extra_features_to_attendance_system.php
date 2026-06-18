<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_models', function (Blueprint $table) {
            $table->string('room')->nullable()->after('name');
            $table->string('schedule_day')->nullable()->after('room');
            $table->time('start_time')->nullable()->after('schedule_day');
            $table->time('end_time')->nullable()->after('start_time');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->string('student_number')->nullable()->unique()->after('class_id');
            $table->string('contact_number')->nullable()->after('email');
            $table->string('photo_path')->nullable()->after('contact_number');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('present');
            $table->string('source')->default('manual')->after('remarks');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['remarks', 'source']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['student_number']);
            $table->dropColumn(['student_number', 'contact_number', 'photo_path']);
        });

        Schema::table('class_models', function (Blueprint $table) {
            $table->dropColumn(['room', 'schedule_day', 'start_time', 'end_time']);
        });
    }
};
