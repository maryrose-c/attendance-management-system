<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {

            $table->string('name')->after('id');
            $table->string('email')->unique()->after('name');
            $table->string('qr_code')->nullable()->after('email');

        });

        Schema::table('attendances', function (Blueprint $table) {

            $table->foreignId('class_id')
                ->constrained('class_models')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('date');

            $table->enum('present', [
                'present',
                'absent',
                'late'
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {

            $table->dropColumn([
                'name',
                'email',
                'qr_code'
            ]);

        });

        Schema::table('attendances', function (Blueprint $table) {

            $table->dropColumn([
                'class_id',
                'student_id',
                'date',
                'present'
            ]);

        });
    }
};