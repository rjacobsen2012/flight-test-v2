<?php

namespace App\Contracts\Libraries;

use App\Models\Flight;
use Illuminate\Support\Collection;

/**
 * Interface FlightListContract
 * @package App\Contracts\Libraries
 */
interface FlightListContract
{
    public function get($uuid): array;

    /**
     * @return Flight[]|Collection
     */
    public function getAll(): array|Collection;
}
