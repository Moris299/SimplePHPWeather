<?php
//CODE BY Maurycy Kaczmarek
$PHP_weather_apikey = trim(file_get_contents('weather_api_key.txt'));

define("weather_apikey", "$PHP_weather_apikey");
//!!!YOU CAN CHANGE UNITS HERE!!!
//define which units you want use: 'metric' (kilometers, celcius...) or 'imperial' (miles, fahrenheit...) 
define("weather_unit", 'metric');

class city {
	private $url;
	private $city_name;
	private $xml_data;
    private $weather_in_english;
    private $translation;

	public function __construct($city_name) {
		$this->city_name = $city_name;
		$this->url  = 'http://api.openweathermap.org/data/2.5/weather?appid=' . weather_apikey . '&units=' . weather_unit . '&mode=xml&q=' . $this->city_name;
        
		//get xml with weather data
		$this->xml_data = new SimpleXMLElement(file_get_contents($this->url));
        
        //if you want to add translation you can do it here (delete /* and */), example translation below is in Polish
        /*
        $this->translation = array(
            'clear sky' => 'bezchmurnie',
			'scattered clouds' => 'pochmurnie', 
			'broken clouds' => 'pochmurnie', 
			'light rain' => 'lekki deszcz', 
			'few clouds' => 'niewielkie zachmurzenie', 
			'rain' => 'opady deszczu',
			'light snow' => 'niewielki opad śniegu',
			'overcast clouds' => 'pochmurnie',
			'light shower snow' => 'niewielki opad śniegu', 
            'mist' => 'mgła',
            'thunderstorm' => 'burza'
        );
        */
	}
	
    public function get_temperature($disp = FALSE) {
        $return_string = round($this->xml_data->temperature['value']);
        
        if($disp) {
            if(weather_unit == 'imperial') {
          		$return_string .= '°F';
            } elseif(weather_unit == 'metric') {
          		$return_string .= '°C';
            }
        }
        return $return_string;
    }
    
    public function get_humidity($disp = FALSE) {
        $return_string = $this->xml_data->humidity['value'];
        
        if($disp) {
            $return_string .= '%';
        }
        
        return $return_string;
    }
    
    public function get_pressure($disp = FALSE) {
        $return_string = $this->xml_data->pressure['value'];
        
        if($disp) {
            $return_string .= 'hPa';
        }
        
        return $return_string;
    }
    
    public function get_wind_speed($disp = FALSE) {
        $wind_speed = $this->xml_data->wind->speed['value'];
        if(weather_unit == 'metric') {
            $return_string = $wind_speed * 3.6;
        } else {
            $return_string = $wind_speed;
        }
        
        if($disp) {
            if(weather_unit == 'metric') { 
                $return_string .= 'kph';
            } elseif(weather_unit == 'imperial') {
                $return_string .= 'mph';
            }
         }
         
         return $return_string;
    }
    
	public function get_weather($disp = FALSE) {
        if($disp) {
            $return_string = '<img style="float: left; height: 20px;" src="weather_img/' . $this->xml_data->weather['icon'] . '.png" />';
        }
		//return city name
		$return_string .= $this->city_name . ': ';

		$return_string .= $this->get_temperature(TRUE) . ', ';
         
		//get overall weather info in english
		$weather_in_english = (string)$this->xml_data->weather['value'];
		//translate into polish
			
		if(empty($this->translation["$weather_in_english"])) {
			$return_string .= $weather_in_english;
			//echo 'empty';
		} else {
			$return_string .= $this->translation["$weather_in_english"]; 
			//echo 'not empty';
		}
		return $return_string;
	}
}

