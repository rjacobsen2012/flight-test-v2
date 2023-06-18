<?php

namespace App\Contracts\Libraries;

use App\Models\Flight;

/**
 * Interface FlightEndpointsContract
 * @package App\Contracts\Libraries
 */
interface FlightEndpointsContract
{
    public function get(Flight $flight): array;
}
