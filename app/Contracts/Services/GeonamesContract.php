<?php

namespace App\Contracts\Services;

/**
 * Interface GeonamesContract
 * @package App\Contracts\Services
 */
interface GeonamesContract
{
    public function getAddress($lat, $long): array;

    public function getCountry($lat, $long): array;
}
