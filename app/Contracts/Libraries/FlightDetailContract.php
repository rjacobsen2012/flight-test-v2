<?php

namespace App\Contracts\Libraries;

/**
 * Interface FlightDetailContract
 * @package App\Contracts\Libraries
 */
interface FlightDetailContract
{
    public function get($uuid): array;

    public function getAll(): array;
}
