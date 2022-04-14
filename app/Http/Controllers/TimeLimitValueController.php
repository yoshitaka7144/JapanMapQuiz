<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeLimitValue;

/**
 * 制限時間マスタコントローラー
 */
class TimeLimitValueController extends Controller
{
    /**
     * 制限時間マスタデータ取得
     *
     * @return void
     */
    public function index()
    {
        return TimeLimitValue::all();
    }
}
