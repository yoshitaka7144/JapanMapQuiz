<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizCountValue;

class QuizCountValueController extends Controller
{
    public function index()
    {
        return QuizCountValue::all();
    }
}
