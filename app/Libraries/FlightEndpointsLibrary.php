<?php

namespace App\Libraries;

use App\Models\Flight;
use App\Models\GpsFrame;
use App\Services\Geonames;
use GeoJson\Geometry\Point;
use Illuminate\Support\Collection;

/**
 * Class FlightEndpointsLibrary
 * @package App\Libraries
 */
class FlightEndpointsLibrary
{
    public function __construct(
        private readonly Geonames $geonames,
        private readonly DistanceLibrary $distanceLibrary
    ) {}

    public function get(Flight $flight): array
    {
        $flightEndpoints = [];

        $endpoints = new Collection();
        $distances = new Collection();

        /** @var GpsFrame $startFrame */
        $startFrame = $flight->gpsFramesFirst->first();
        $address = $startFrame ? $this->geonames->getAddress($startFrame->lat, $startFrame->long) : null;

        $flight->gpsFramesFirst->each(function (GpsFrame $gpsFrame) use (&$flightEndpoints, &$endpoints, &$distances) {
            $point = new Point([$gpsFrame->long, $gpsFrame->lat]);
            $flightEndpoints[] = [
                'timestamp' => strtotime($gpsFrame->timestamp->toDateTimeLocalString()) * 1000,
                'type' => $point->getType(),
                'coordinates' => $point->getCoordinates(),
            ];
            $endpoints->push([$gpsFrame->long, $gpsFrame->lat]);
            $distances->push([
                'timestamp' => $gpsFrame->timestamp,
                'lat' => $gpsFrame->lat,
                'long' => $gpsFrame->long,
            ]);
        });

        return [$flightEndpoints, [
            'type' => 'LineString',
            'coordinates' => array_values($endpoints->unique()->toArray())
        ], $this->distanceLibrary->get($distances), $address];
    }
}
