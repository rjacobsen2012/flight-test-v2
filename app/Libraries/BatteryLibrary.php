<?php

namespace App\Libraries;

use App\Contracts\Libraries\BatteryContract;
use App\Models\Battery;
use App\Models\Drone;

/**
 * Class BatteryLibrary
 * @package App\Libraries
 */
class BatteryLibrary implements BatteryContract
{
    public function __construct(private readonly BatteryDetailsLibrary $batteryFrameLibrary)
    {}

    public function get(Drone $drone): array
    {
        $batteries = [];

        $drone->batteries->each(function (Battery $battery) use (&$batteries) {
            list($batteryTemperatures, $batteryPercents) = $this->batteryFrameLibrary->get($battery);

            $batteries[] = [
                'battery_sn' => $battery->battery_sn,
                'battery_name' => $battery->battery_name,
                'battery_temperatures' => $batteryTemperatures,
                'battery_percents' => $batteryPercents,
            ];
        });

        return $batteries;
    }
}
