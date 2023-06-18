<?php

namespace App\Contracts\Libraries;

use App\Models\Battery;

/**
 * Interface BatteryDetailsContract
 * @package App\Contracts\Libraries
 */
interface BatteryDetailsContract
{
    public function get(Battery $battery): array;
}
