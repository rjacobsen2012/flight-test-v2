<?php

namespace App\Contracts\Libraries;

use App\Models\Flight;

/**
 * Interface GpsFrameContract
 * @package App\Contracts\Libraries
 */
interface GpsFrameContract
{
    public function getPointDurationCountry(Flight $flight): array;
}
