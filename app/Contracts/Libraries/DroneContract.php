<?php

namespace App\Contracts\Libraries;

use App\Models\Drone;

/**
 * Interface DroneContract
 * @package App\Contracts\Libraries
 */
interface DroneContract
{
    public function getBatteries(Drone $drone): array;
}
