<?php

//CODE BY Maurycy Kaczmarek
//API KEY from openweathermap.org here:
$PHP_weather_apikey = API_KEY_HERE;

define("weather_apikey", "$PHP_weather_apikey");
//Define which units you want to use: 'Metric' (kilometres, Celsius...) or 'Imperial' (miles, Fahrenheit...).
define("weather_unit", 'metric');

class CityWeatherLoader {

    private $url;
    private $cityName;
    private $xmlData;
    private $weatherInEnglish;
    private $translation;

    public function __construct($cityName) {
        $this->city_name = $cityName;
        $this->url = 'http://api.openweathermap.org/data/2.5/weather?appid=' . weather_apikey . '&units=' . weather_unit . '&mode=xml&q=' . $this->city_name;

        //get xml with weather data
        $this->xml_data = new SimpleXMLElement(file_get_contents($this->url));

        // *** TRANSLATIONS *** :
        //If you would like to add a translation, you can do so here by removing the comment marks (/* and */) – an example translation in Polish is provided below.
	/*
        $this->translation = array(
            'clear sky' => 'bezchmurne niebo',
            'few clouds' => 'niewielkie zachmurzenie',
            'scattered clouds' => 'rozproszone chmury',
            'broken clouds' => 'zachmurzenie umiarkowane',
            'overcast clouds' => 'całkowite zachmurzenie',
            // Opady deszczu
            'light rain' => 'przelotny deszcz',
            'moderate rain' => 'umiarkowany deszcz',
            'heavy intensity rain' => 'intensywny deszcz',
            'very heavy rain' => 'bardzo intensywny deszcz',
            'extreme rain' => 'ekstremalny deszcz',
            'freezing rain' => 'marznący deszcz',
            'shower rain' => 'przelotny deszcz',
            'light intensity shower rain' => 'lekka przelotna mżawka',
            'heavy intensity shower rain' => 'intensywny przelotny deszcz',
            'ragged shower rain' => 'nieregularne przelotne opady deszczu',
            // Opady śniegu
            'light snow' => 'lekki śnieg',
            'snow' => 'śnieg',
            'heavy snow' => 'obfite opady śniegu',
            'light shower snow' => 'przelotne opady śniegu',
            'shower snow' => 'przelotny śnieg',
            'sleet' => 'deszcz ze śniegiem',
            'light shower sleet' => 'przelotny deszcz ze śniegiem',
            'shower sleet' => 'deszcz ze śniegiem',
            // Burze
            'thunderstorm' => 'burza',
            'thunderstorm with light rain' => 'burza z lekkim deszczem',
            'thunderstorm with rain' => 'burza z deszczem',
            'thunderstorm with heavy rain' => 'burza z ulewą',
            'thunderstorm with light drizzle' => 'burza z lekką mżawką',
            'thunderstorm with drizzle' => 'burza z mżawką',
            'thunderstorm with heavy drizzle' => 'burza z intensywną mżawką',
            'ragged thunderstorm' => 'nieregularna burza',
            // Mżawka
            'drizzle' => 'mżawka',
            'light intensity drizzle' => 'lekka mżawka',
            'heavy intensity drizzle' => 'intensywna mżawka',
            'light intensity drizzle rain' => 'lekka deszczowa mżawka',
            'drizzle rain' => 'deszczowa mżawka',
            'heavy intensity drizzle rain' => 'intensywna deszczowa mżawka',
            'shower drizzle' => 'przelotna mżawka',
            // Zamglenia i inne zjawiska
            'mist' => 'mgła',
            'fog' => 'gęsta mgła',
            'haze' => 'zamglenie',
            'smoke' => 'dym',
            'sand/dust whirls' => 'wiry piasku/kurzu',
            'dust' => 'pył',
            'sand' => 'piasek',
            'ash' => 'popiół wulkaniczny',
            'squalls' => 'szkwały',
            'tornado' => 'tornado',
            // Ekstremalne warunki
            'tropical storm' => 'burza tropikalna',
            'hurricane' => 'huragan',
            'cold' => 'silny mróz',
            'hot' => 'upał',
            'windy' => 'wietrznie',
            'hail' => 'grad'
        );
    }
    */
	
    public function get_temperature($disp = false) {
        $return_string = round($this->xml_data->temperature['value']);

        if ($disp) {
            if (weather_unit == 'imperial') {
                $return_string .= '°F';
            } elseif (weather_unit == 'metric') {
                $return_string .= '°C';
            }
        }
        return $return_string;
    }

    public function get_humidity($disp = false) {
        $return_string = $this->xml_data->humidity['value'];

        if ($disp) {
            $return_string .= '%';
        }

        return $return_string;
    }

    public function get_pressure($disp = false) {
        $return_string = $this->xml_data->pressure['value'];

        if ($disp) {
            $return_string .= 'hPa';
        }

        return $return_string;
    }

    public function get_wind_speed($disp = false) {
        $wind_speed = $this->xml_data->wind->speed['value'];
        if (weather_unit == 'metric') {
            $return_string = $wind_speed * 3.6;
        } else {
            $return_string = $wind_speed;
        }

        if ($disp) {
            if (weather_unit == 'metric') {
                $return_string .= 'kph';
            } elseif (weather_unit == 'imperial') {
                $return_string .= 'mph';
            }
        }

        return $return_string;
    }

    public function get_weather($disp = false) {
        if ($disp) {
            $return_string = '<img style="float: left; height: 20px;" src="weather_img/' . $this->xml_data->weather['icon'] . '.png" />';
        }
        //return city name
        $return_string .= $this->city_name . ': ';

        $return_string .= $this->get_temperature(TRUE) . ', ';

        //get overall weather info in english
        $weatherInEnglish = (string) $this->xml_data->weather['value'];
        //translate into polish

        if (empty($this->translation["$weatherInEnglish"])) {
            $return_string .= $weatherInEnglish;
            //echo 'empty';
        } else {
            $return_string .= $this->translation["$weatherInEnglish"];
            //echo 'not empty';
        }
        return $return_string;
    }
}
