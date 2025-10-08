<?php
// app/Models/EnrollmentRecord.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_id',
        'school_year',
        'status',
        'terms_accepted',
        'submitted_at',
    ];

    protected $casts = [
        'terms_accepted' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    // RELATIONSHIP - One EnrollmentRecord belongs to One Learner
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    // CUSTOM METHODS
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function markAsSubmitted()
    {
        $this->update([
            'submitted_at' => now(),
            'status' => 'pending'
        ]);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];
        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}