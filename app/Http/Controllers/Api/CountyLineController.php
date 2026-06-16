<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountyLineResource;
use App\Models\CountyLine;

class CountyLineController extends Controller
{
    public function index()
    {
        $data = cache()->remember('api.county_lines', 3600, function () {
            $lines = CountyLine::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
            return CountyLineResource::collection($lines)->response()->getData(true)['data'];
        });

        return response()->json(['data' => $data]);
    }
}
