<?php
// app/Models/Address.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_id',
        'street_address',
        'city',
        'state',
        'zip_code',
        'country',
    ];

    // RELATIONSHIP - One Address belongs to One Learner
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    // CUSTOM METHODS
    public function getFullAddressAttribute()
    {
        return $this->street_address . ', ' . $this->city . ', ' . $this->state . ' ' . $this->zip_code . ', ' . $this->country;
    }
}