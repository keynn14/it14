<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'lrn', 'first_name', 'last_name', 'middle_name', 'birth_date', 
        'gender', 'address', 'phone', 'email', 'student_type', 'status'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // CORRECT ENUM values based on your database
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_GRADUATED = 'graduated';
    const STATUS_TRANSFERRED = 'transferred';

    // Student type values
    const TYPE_NEW = 'new';
    const TYPE_OLD = 'old';
    const TYPE_RETURNEE = 'returnee';
    const TYPE_TRANSFEREE = 'transferee';

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function transfereeInfo()
    {
        return $this->hasOne(Transferee::class);
    }

    public function returneeInfo()
    {
        return $this->hasOne(Returnee::class);
    }

    public function academicRecords()
    {
        return $this->hasMany(AcademicRecord::class);
    }

    public function getFullNameAttribute()
    {
        $name = "{$this->first_name}";
        if ($this->middle_name) {
            $name .= " {$this->middle_name}";
        }
        $name .= " {$this->last_name}";
        return $name;
    }

    public function getCurrentEnrollmentAttribute()
    {
        return $this->enrollments()->where('status', Enrollment::STATUS_APPROVED)->first();
    }
}