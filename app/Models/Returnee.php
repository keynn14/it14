<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returnee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'status', // Add this
        'previous_school_year',
        'previous_grade_level',
        'new_grade_level',
        'reason_for_return',
        'academic_status',
        'documents_path',
        'remarks'
    ];

    protected $casts = [
        'academic_status' => 'array',
    ];

    // Add status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Add scope for pending returnees
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function calculatePromotionStatus()
    {
        $records = AcademicRecord::where('student_id', $this->student_id)
            ->where('school_year', $this->previous_school_year)
            ->get();

        $failedSubjects = $records->filter(function ($record) {
            return $record->grade < 75;
        });

        $status = [
            'failed_count' => $failedSubjects->count(),
            'failed_subjects' => $failedSubjects->pluck('subject')->toArray(),
            'can_proceed' => $failedSubjects->count() <= 3,
            'average_grade' => $records->avg('grade'),
            'status' => $failedSubjects->count() <= 3 ? 'eligible' : 'needs_review'
        ];

        $this->update(['academic_status' => $status]);
        return $status;
    }
}