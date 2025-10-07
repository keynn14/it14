<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'school_year', 'grade_level', 'enrollment_type', 
        'status', 'remarks', 'documents',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}