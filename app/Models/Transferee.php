<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'previous_school',
        'previous_school_address',
        'school_type',
        'previous_grade',
        'desired_grade',
        'last_school_year',
        'transfer_reason',
        'form_137_path',
        'good_moral_path',
        'birth_certificate_path',
        'status'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function enrollment()
    {
        return $this->hasOne(Enrollment::class, 'student_id', 'student_id');
    }

    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }
}