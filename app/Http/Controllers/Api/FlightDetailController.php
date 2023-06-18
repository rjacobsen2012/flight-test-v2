<?php

namespace App\Http\Controllers\Api;

use App\Libraries\FlightDetailLibrary;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * Class FlightDetailController
 * @package App\Http\Controllers\Api
 */
class FlightDetailController extends Controller
{
    public function index(FlightDetailLibrary $flightDetailLibrary): JsonResponse
    {
        return response()->json($flightDetailLibrary->getAll());
    }

    public function show($uuid, FlightDetailLibrary $flightDetailLibrary): JsonResponse
    {
        return response()->json($flightDetailLibrary->get($uuid));
    }
}
