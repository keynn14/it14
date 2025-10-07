<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturneeController extends Controller
{
    public function showEnrollmentForm()
    {
        return view('enrollment/returnee');
    }
}