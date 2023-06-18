<?php

namespace App\Libraries;

use App\Contracts\Libraries\FlightListContract;
use App\Models\Flight;
use Illuminate\Support\Collection;

/**
 * Class FlightListLibrary
 * @package App\Libraries
 */
class FlightListLibrary implements FlightListContract
{
    public function __construct(
        private readonly GpsFrameLibrary $gpsFrameLibrary,
        private readonly DroneLibrary $droneLibrary
    ) {}

    public function get($uuid): array
    {
        /** @var Flight $flight */
        $flight = Flight::where('uuid', $uuid)->first();

        if (!$flight) {
            return ['error' => 'Flight uuid not found'];
        }

        $drone = $flight->drone;
        [$point, $duration, $countryOfFlight] = $this->gpsFrameLibrary->getPointDurationCountry($flight);
        $batteries = $this->droneLibrary->getBatteries($drone);

        return [
            'uuid' => $flight->uuid,
            'aircraft_name' => $drone->aircraft_name,
            'aircraft_sn' => $drone->aircraft_sn,
            'home_point' => $point,
            'flight_duration' => $duration,
            'batteries' => $batteries,
            'country' => $countryOfFlight
        ];
    }

    /**
     * @return Flight[]|Collection
     */
    public function getAll(): array|Collection
    {
        return Flight::all()->map(function (Flight $flight) {
            return $this->get($flight->uuid);
        })->toArray();
    }
}
