<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeLimitValue;

class TimeLimitValueController extends Controller
{
    public function index()
    {
        return TimeLimitValue::all();
    }
}
