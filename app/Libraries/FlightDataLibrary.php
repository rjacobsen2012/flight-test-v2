<?php

namespace App\Libraries;

use App\Contracts\Libraries\FlightDataContract;
use App\Models\Battery;
use App\Models\Drone;
use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class FlightDataLibrary
 * @package App\Libraries
 */
class FlightDataLibrary implements FlightDataContract
{
    public function save(Request $request): void
    {
        /**
         * @var Flight $flight
         * @var Drone $drone
         */
        [$flight, $drone] = $this->getFlight($request);
        $batteries = $this->addBatteries($request, $drone);
        $this->addFrames($request, $batteries, $flight);
    }

    protected function getFlight(Request $request): array
    {
        /** @var Flight $flight */
        $flight = Flight::where('uuid', $request->json('uuid'))->first();
        $drone = $this->getDrone($request);

        if (!$flight) {
            $flight = $drone->flights()->create([
                'uuid' => $request->json('uuid'),
            ]);
        }

        return [$flight, $drone];
    }

    protected function getDrone(Request $request): Drone
    {
        /** @var Drone $drone */
        $drone = Drone::where('aircraft_sn', $request->json('aircraft_sn'))->first();

        if (!$drone) {
            $drone = Drone::create([
                'aircraft_name' => $request->json('aircraft_name'),
                'aircraft_sn' => $request->json('aircraft_sn')
            ]);
        }

        return $drone;
    }

    protected function addBatteries(Request $request, Drone $drone): array
    {
        $batteries = [];

        foreach ($request->json('batteries') as $batteryData) {
            $batteries[$batteryData['battery_sn']] = $this->getBattery($drone, $batteryData);
        }
        return $batteries;
    }

    protected function getBattery(Drone $drone, $batteryData): Battery
    {
        $battery = $drone->batteries->where('battery_sn', $batteryData['battery_sn'])->first();

        if (!$battery) {
            $battery = $drone->batteries()->create([
                'battery_sn' => $batteryData['battery_sn'],
                'battery_name' => $batteryData['battery_name'],
            ]);
        }

        return $battery;
    }

    protected function addFrames(Request $request, array $batteries, Flight $flight): void
    {
        foreach ($request->json('frames') as $frame) {
            $seconds = $frame['timestamp'] / 1000;
            $timestamp = Carbon::parse(date('m/d/Y H:i:s', $seconds));
            switch ($frame['type']) {
                case 'battery':
                    $this->addBatteryFrame($frame, $batteries, $timestamp);
                    break;
                case 'gps':
                    $this->addGpsFrame($flight, $frame, $timestamp);
                    break;
            }
        }
    }

    protected function addBatteryFrame($frame, array $batteries, Carbon $timestamp): void
    {
        if (array_key_exists($frame['battery_sn'], $batteries)) {
            $batteries[$frame['battery_sn']]->batteryFrames()->create([
                'timestamp' => $timestamp,
                'battery_percent' => $frame['battery_percent'],
                'battery_temperature' => $frame['battery_temperature'],
            ]);
        }
    }

    protected function addGpsFrame(Flight $flight, $frame, Carbon $timestamp): void
    {
        $flight->gpsFrames()->create([
            'timestamp' => $timestamp,
            'lat' => $frame['lat'],
            'long' => $frame['long'],
            'alt' => $frame['alt'],
        ]);
    }
}
