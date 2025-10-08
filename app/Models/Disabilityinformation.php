<?php
// app/Models/DisabilityInformation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisabilityInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_id',
        'disability_type',
        'special_requirements',
        'medical_conditions',
    ];

    // RELATIONSHIP - One DisabilityInformation belongs to One Learner
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    // CUSTOM METHODS
    public function hasDisability()
    {
        return $this->disability_type !== 'none';
    }

    public function getDisabilityTypeTextAttribute()
    {
        $types = [
            'none' => 'No Disability',
            'physical' => 'Physical Disability',
            'learning' => 'Learning Disability',
            'visual' => 'Visual Impairment',
            'hearing' => 'Hearing Impairment',
            'speech' => 'Speech Impairment',
            'other' => 'Other',
        ];
        return $types[$this->disability_type] ?? 'Unknown';
    }
}