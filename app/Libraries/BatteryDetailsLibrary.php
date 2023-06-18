<?php

namespace App\Libraries;

use App\Contracts\Libraries\BatteryDetailsContract;
use App\Models\Battery;
use App\Models\BatteryFrame;

/**
 * Class BatteryDetailsLibrary
 * @package App\Libraries
 */
class BatteryDetailsLibrary implements BatteryDetailsContract
{
    public function get(Battery $battery): array
    {
        $batteryTemperatures = [];
        $batteryPercents = [];

        $battery->batteryFramesFirst->each(function (BatteryFrame $batteryFrame) use (
            &$batteryTemperatures,
            &$batteryPercents
        ) {
            $timestamp = strtotime($batteryFrame->timestamp->toDateTimeLocalString()) * 1000;
            $batteryTemperatures[] = $this->getTemperature($batteryFrame, $timestamp);
            $batteryPercents[] = $this->getPercent($batteryFrame, $timestamp);
        });

        return array($batteryTemperatures, $batteryPercents);
    }

    protected function getPercent(BatteryFrame $batteryFrame, $timestamp): array
    {
        return [
            'timestamp' => $timestamp,
            'battery_percent' => $batteryFrame->battery_percent,
        ];
    }

    protected function getTemperature(BatteryFrame $batteryFrame, $timestamp): array
    {
        return [
            'timestamp' => $timestamp,
            'battery_temperature' => $batteryFrame->battery_temperature,
        ];
    }
}
