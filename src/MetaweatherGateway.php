<?php

namespace Codium\CleanCode;

use GuzzleHttp\Client;

class MetaweatherGateway {

    const BASE_PATH = 'https://www.metaweather.com/api/location';

    const WOEID_KEY = 'woeid';
    const CONSOLIDATED_WEATHER_KEY = 'consolidated_weather';

    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function obtainWoeId(string $city) {
        return json_decode($this->client->get(self::BASE_PATH."/search/?query=$city")->getBody()->getContents(),
            true)[0][self::WOEID_KEY];
    }

    public function obtainWeather(string $woeid) {
        return json_decode($this->client->get(self::BASE_PATH."/$woeid")->getBody()->getContents(),
        true)[self::CONSOLIDATED_WEATHER_KEY];
    }

}