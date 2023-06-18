<?php

namespace App\Services;

use App\Contracts\Services\GeonamesContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Geonames
 * @package App\Services
 */
class Geonames implements GeonamesContract
{
    public function __construct(protected Client $client)
    {}

    public function getAddress($lat, $long): array
    {
        $address = null;

        try {
            $url = $this->getAddressUrl($lat, $long);
            $address = (array) $this->query($url, true)->address;
        } catch (GuzzleException $e) {
            catch_and_return('There was a problem retrieving the address data.', $e);
        }

        return $address;
    }

    public function getCountry($lat, $long): array
    {
        $country = null;

        try {
            $url = $this->getCountryUrl($lat, $long);
            $country = (array) $this->query($url)->countryName;
        } catch (GuzzleException $e) {
            catch_and_return('There was a problem retrieving the country data.', $e);
        }

        return $country;
    }

    protected function getAddressUrl($lat, $long): string
    {
        return config('geonames.url') .
            "/extendedFindNearby?lat={$lat}&lng={$long}&username=" .
            config('geonames.user');
    }

    protected function getCountryUrl($lat, $long): string
    {
        return config('geonames.url') .
            "/countryCodeJSON?lat={$lat}&lng={$long}&username=" .
            config('geonames.user');
    }

    /**
     * @throws GuzzleException
     */
    protected function query(string $url, $rest = false): mixed
    {
        if ($rest) {
            $response = $this->client->request(
                'GET',
                $url,
                ['headers' => ['Accept' => 'application/json', 'Content-type' => 'application/json']]);
        } else {
            $response = $this->client->request('GET', $url);
        }

        return json_decode($response->getBody()->getContents());
    }
}
