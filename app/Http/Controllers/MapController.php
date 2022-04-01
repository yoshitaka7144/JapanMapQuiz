<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Map;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $classification_id = $request->classificationId;
        if (isset($classification_id)) {
            return Map::whereIn("classification_id", $classification_id)->inRandomOrder()->get();
        } else {
            return Map::all();
        }
    }

    public function names(Request $request)
    {
        $classification_id = $request->classificationId;
        if (isset($classification_id)) {
            return Map::whereIn("classification_id", $classification_id)->select("name")->orderBy("id", "asc")->get();
        } else {
            return Map::select("name", "classification_id")->orderBy("id", "asc")->get();
        }
    }
}
