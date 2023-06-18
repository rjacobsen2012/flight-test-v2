<?php

namespace App\Libraries;

use App\Contracts\Libraries\FlightDetailContract;
use App\Models\Flight;

/**
 * Class FlightDetailLibrary
 * @package App\Libraries
 */
class FlightDetailLibrary implements FlightDetailContract
{
    public function __construct(
        private readonly BatteryLibrary $batteryLibrary,
        private readonly FlightEndpointsLibrary $flightEndpointsLibrary
    ) {}

    public function get($uuid): array
    {
        /** @var Flight $flight */
        $flight = Flight::where('uuid', $uuid)->first();

        if (!$flight) {
            return ['error' => 'Flight uuid not found'];
        }

        [$flightEndpoints, $flightPath, $distance, $address] = $this->flightEndpointsLibrary->get($flight);

        return [
            'uuid' => $flight->uuid,
            'flight_endpoints' => $flightEndpoints,
            'battery_details' => $this->batteryLibrary->get($flight->drone),
            'flight_path' => $flightPath,
            'distance' => $distance,
            'address' => $address,
        ];
    }

    public function getAll(): array
    {
        return Flight::all()->map(function (Flight $flight) {
            return $this->get($flight->uuid);
        })->toArray();
    }
}
