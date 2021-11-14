<?php

namespace Tests\Codium\CleanCode;

use Codium\CleanCode\ForecastFetcher;
use Codium\CleanCode\MetaweatherGateway;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase {
    // https://www.metaweather.com/api/location/766273/
    /** @test */
    public function find_the_weather_of_today()
    {
        $forecast = new ForecastFetcher(new MetaweatherGateway());
        $city = "Madrid";

        $prediction = $forecast->getWeather($city);

        echo "Today: $prediction\n";
        $this->assertTrue(true, 'I don\'t know how to test it');
    }

    /** @test */
    public function find_the_weather_of_any_day()
    {
        $forecast = new ForecastFetcher(new MetaweatherGateway());
        $city = "Madrid";

        $prediction = $forecast->getWeather($city, new \DateTime('+2 days'));

        echo "Day after tomorrow: $prediction\n";
        $this->assertTrue(true, 'I don\'t know how to test it');
    }

    /** @test */
    public function find_the_wind_of_any_day()
    {
        $forecast = new ForecastFetcher(new MetaweatherGateway());
        $city = "Madrid";

        $prediction = $forecast->getWind($city, null, true);

        echo "Wind: $prediction\n";
        $this->assertTrue(true, 'I don\'t know how to test it');
    }

    /** @test */
    public function change_the_city_to_woeid()
    {
        $metaweatherGateway = new MetaweatherGateway();
        $city = "Madrid";

        $this->assertEquals("766273", $metaweatherGateway->obtainWoeId($city));
    }

    /** @test */
    public function there_is_no_prediction_for_more_than_5_days()
    {
        $forecast = new ForecastFetcher(new MetaweatherGateway());
        $city = "Madrid";

        try {
            $prediction = $forecast->getWeather($city, new \DateTime('+6 days'));
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertTrue(true);
        }

    }
}