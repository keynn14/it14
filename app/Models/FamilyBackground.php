<?php
// app/Models/FamilyBackground.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_id',
        'father_last_name',
        'father_first_name',
        'father_middle_name',
        'father_contact',
        'mother_last_name',
        'mother_first_name',
        'mother_middle_name',
        'mother_contact',
        'guardian_last_name',
        'guardian_first_name',
        'guardian_middle_name',
        'guardian_contact',
    ];

    // RELATIONSHIP - One FamilyBackground belongs to One Learner
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    // CUSTOM METHODS
    public function getFatherFullNameAttribute()
    {
        $name = $this->father_last_name . ', ' . $this->father_first_name;
        if ($this->father_middle_name) {
            $name .= ' ' . $this->father_middle_name;
        }
        return $name;
    }

    public function getMotherFullNameAttribute()
    {
        $name = $this->mother_last_name . ', ' . $this->mother_first_name;
        if ($this->mother_middle_name) {
            $name .= ' ' . $this->mother_middle_name;
        }
        return $name;
    }

    public function getGuardianFullNameAttribute()
    {
        $name = $this->guardian_last_name . ', ' . $this->guardian_first_name;
        if ($this->guardian_middle_name) {
            $name .= ' ' . $this->guardian_middle_name;
        }
        return $name;
    }
}