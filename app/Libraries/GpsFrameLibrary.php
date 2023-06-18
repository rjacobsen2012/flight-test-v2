<?php

namespace App\Libraries;

use App\Contracts\Libraries\GpsFrameContract;
use App\Models\Flight;
use App\Models\GpsFrame;
use App\Services\Geonames;

/**
 * Class GpsFrameLibrary
 * @package App\Libraries
 */
class GpsFrameLibrary implements GpsFrameContract
{
    public function __construct(private readonly Geonames $geonames)
    {}

    public function getPointDurationCountry(Flight $flight): array
    {
        /** @var GpsFrame $startFrame */
        $startFrame = $flight->gpsFramesFirst->first();

        /** @var GpsFrame $lastFrame */
        $lastFrame = $flight->gpsFramesLast->first();

        $countryOfFlight = $startFrame ? $this->geonames->getCountry($startFrame->lat, $startFrame->long) : null;

        $point = $startFrame ? ['lat' => $startFrame->lat, 'long' => $startFrame->long] : '';
        $duration = $startFrame && $lastFrame ? $startFrame->timestamp->diffInSeconds($lastFrame->timestamp) : '';

        return [$point, $duration, $countryOfFlight ?: 'Unknown'];
    }
}
