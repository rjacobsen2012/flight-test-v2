<?php

namespace App\Contracts\Libraries;

use App\Models\Drone;

/**
 * Interface BatteryContract
 * @package App\Contracts\Libraries
 */
interface BatteryContract
{
    public function get(Drone $drone): array;
}
