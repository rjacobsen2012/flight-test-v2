<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\FlightListLibrary;
use Illuminate\Http\JsonResponse;

/**
 * Class FlightListController
 * @package App\Http\Controllers\Api
 */
class FlightListController extends Controller
{
    public function index(FlightListLibrary $flightListLibrary): JsonResponse
    {
        return response()->json($flightListLibrary->getAll());
    }

    public function show($uuid, FlightListLibrary $flightListLibrary): JsonResponse
    {
        return response()->json($flightListLibrary->get($uuid));
    }
}
