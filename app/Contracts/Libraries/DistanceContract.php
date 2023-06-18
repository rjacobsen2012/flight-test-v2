<?php

namespace App\Contracts\Libraries;

use Illuminate\Support\Collection;

/**
 * Interface DistanceContract
 * @package App\Contracts\Libraries
 */
interface DistanceContract
{
    public function get(Collection $distances): int;
}
