<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'lrn', 'first_name', 'last_name', 'middle_name', 'extension', 'sex', 'birth_date', 
        'birth_place', 'indigenous_group', 'mother_tongue', 'address', 'father_name', 
        'mother_name', 'guardian_name', 'guardian_contact', 'last_grade', 'last_school_year', 
        'last_school', 'last_school_id', 'status',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name} {$this->extension}";
    }
}