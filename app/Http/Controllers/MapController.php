<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Map;

/**
 * 地図データコントローラー
 */
class MapController extends Controller
{
    /**
     * データ一覧取得
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        // 地方区分id
        $classification_id = $request->classificationId;

        if (isset($classification_id)) {
            // 対象の地方の地図データ取得
            return Map::whereIn("classification_id", $classification_id)->inRandomOrder()->get();
        } else {
            // 全地図データ取得
            return Map::all();
        }
    }

    /**
     * 地図名データ取得
     *
     * @param Request $request
     * @return void
     */
    public function names(Request $request)
    {
        // 地方区分id
        $classification_id = $request->classificationId;

        if (isset($classification_id)) {
            // 対象の地方の地図の名前取得
            return Map::whereIn("classification_id", $classification_id)->select("name")->orderBy("id", "asc")->get();
        } else {
            // 全地図データの名前取得
            return Map::select("name", "classification_id")->orderBy("id", "asc")->get();
        }
    }
}
