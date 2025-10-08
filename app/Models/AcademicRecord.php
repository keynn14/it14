<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject',
        'grade',
        'school_year',
        'semester',
        'remarks'
    ];

    protected $casts = [
        'grade' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getStatusAttribute()
    {
        return $this->grade >= 75 ? 'passed' : 'failed';
    }

    public function getGradeColorAttribute()
    {
        if ($this->grade >= 90) return 'text-green-600';
        if ($this->grade >= 80) return 'text-blue-600';
        if ($this->grade >= 75) return 'text-yellow-600';
        return 'text-red-600';
    }
}