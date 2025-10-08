<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'school_year', 'grade_level', 'enrollment_type', 
        'status', 'remarks', 'documents', 'section', 'track', 'strand'
    ];

    // CORRECT ENUM values based on your database
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Enrollment types
    const TYPE_NEW = 'new';
    const TYPE_OLD = 'old';
    const TYPE_RETURNEE = 'returnee';
    const TYPE_TRANSFEREE = 'transferee';

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function isActive()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }
}