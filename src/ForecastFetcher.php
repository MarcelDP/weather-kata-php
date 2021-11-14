<?php

namespace Codium\CleanCode;

use Exception;

class ForecastFetcher {

    const WIND_SPEED_KEY = 'wind_speed';
    const WEATHER_STATE_KEY = 'weather_state_name';
    const PREDICTION_PERIOD = '+6 days 00:00:00';
    const DATE_KEY = 'applicable_date';

    const DATE_FORMAT = 'Y-m-d';
    
    private $metaweatherGateway;

    public function __construct(MetaweatherGateway $metaweatherGateway) {
        $this->metaweatherGateway = $metaweatherGateway;
    }

    public function getWind(string $city, \DateTime $datetime = null) : string {
        return $this->predict($city, $datetime)[self::WIND_SPEED_KEY]??"";
    }

    public function getWeather(string $city, \DateTime $datetime = null) : string {
        return $this->predict($city, $datetime)[self::WEATHER_STATE_KEY]??"";
    }
    
    private function predict(string $city, \DateTime $datetime = null): array {
        if (!$datetime) {
            $datetime = new \DateTime();
        }

        if ($datetime >= new \DateTime(self::PREDICTION_PERIOD)) {
            throw new Exception('Time is out of range');
        }

        // Find the id of the city on metawheather
        $woeid = $this->metaweatherGateway->obtainWoeId($city);

        // Find the predictions for the city
        $predicitons = $this->metaweatherGateway->obtainWeather($woeid);

        // Get the prediction of the given day
        foreach ($predicitons as $prediction) {
            if ($prediction[self::DATE_KEY] == $datetime->format(self::DATE_FORMAT)) {
                return $prediction;
            }
        }
        
    }
}