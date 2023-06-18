<?php

namespace App\Libraries;

use App\Contracts\Libraries\DistanceContract;
use Illuminate\Support\Collection;

/**
 * Class DistanceLibrary
 * @package App\Libraries
 */
class DistanceLibrary implements DistanceContract
{
    public function get(Collection $distances): int
    {
        $distance = 0;

        foreach ($distances as $key => $data) {
            if ($key) {
                $this->calculate(
                    $distance,
                    $distances[$key - 1]['lat'],
                    $distances[$key - 1]['long'],
                    $data['lat'],
                    $data['long']
                );
            }
        }

        return $distance;
    }

    protected function calculate(&$distance, $lat1, $long1, $lat2, $long2): void
    {
        $distance += $this->calculator($lat1, $long1, $lat2, $long2);
    }

    protected function calculator($lat1, $lon1, $lat2, $lon2): float|int
    {
        if (($lat1 === $lat2) && ($lon1 === $lon2)) {
            return 0;
        }

        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $kilometers = $miles * 1.609344;

            return $kilometers * 1000;
        }
    }
}
