<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;

/**
 * 地方区分コントローラー
 */
class ClassificationController extends Controller
{
    /**
     * 一覧取得
     *
     * @return void
     */
    public function index()
    {
        return Classification::all();
    }
}
