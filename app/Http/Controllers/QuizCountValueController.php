<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizCountValue;

/**
 * 問題数マスタコントローラー
 */
class QuizCountValueController extends Controller
{
    /**
     * 問題数マスタデータ一覧取得
     *
     * @return void
     */
    public function index()
    {
        return QuizCountValue::all();
    }
}
