<?php

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

if (! function_exists('catch_and_return')) {
    function catch_and_return(
        string $message,
        Exception|GuzzleException $exception,
        bool $showStackTrace = true,
        bool $showTime = true
    ): string {
        $time = Carbon::now()->toDateTimeString();
        $message = $showTime ? "{$time}: {$message}" : $message;

        if ($showStackTrace) {
            Log::critical($message . PHP_EOL .
                $exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
        } else {
            Log::critical($message . PHP_EOL .
                $exception->getMessage());
        }

        return $message;
    }
}
