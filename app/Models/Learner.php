<?php
// app/Models/Learner.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    use HasFactory;

    // Fields that can be mass assigned
    protected $fillable = [
        'psa_birth_certificate',
        'last_name',
        'first_name',
        'middle_name',
        'extension_name',
        'lrn',
        'birthdate',
        'gender',
        'age',
        'ip_community',
        'ip_specify',
        'fourps_beneficiary',
        'fourps_household_id',
        'mother_tongue',
    ];

    // Data type casting
    protected $casts = [
        'birthdate' => 'date',
    ];

    // RELATIONSHIPS - One Learner has One of each
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function familyBackground()
    {
        return $this->hasOne(FamilyBackground::class);
    }

    public function disabilityInformation()
    {
        return $this->hasOne(DisabilityInformation::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function enrollmentRecord()
    {
        return $this->hasOne(EnrollmentRecord::class);
    }

    // CUSTOM METHODS
    public function getFullNameAttribute()
    {
        $name = $this->last_name . ', ' . $this->first_name;
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        if ($this->extension_name) {
            $name .= ' ' . $this->extension_name;
        }
        return $name;
    }

    public function getAgeAttribute()
    {
        return $this->birthdate->age;
    }
}