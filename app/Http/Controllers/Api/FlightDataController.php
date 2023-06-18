<?php

namespace App\Http\Controllers\Api;

use App\Libraries\FlightDataLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class FlightDataController
 * @package App\Http\Controllers\Api
 */
class FlightDataController extends Controller
{
    public function store(Request $request, FlightDataLibrary $flightDataLibrary): JsonResponse
    {
        $flightDataLibrary->save($request);

        return response()->json(['status' => 'success']);
    }
}
