<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'student_number',
        'name',
        'email',
        'contact_number',
        'photo_path',
        'qr_code'
    ];

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}