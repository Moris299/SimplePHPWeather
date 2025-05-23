# SimplePHPWeather

A simple PHP class for fetching weather data from the OpenWeatherMap API. Automatically translates weather descriptions from English to Polish.

## Description

The `CityWeatherLoader` class allows you to easily fetch current weather data for any city in the world. It uses the OpenWeatherMap API and is compatible with PHP 8+.

## Requirements

- PHP 8.0 or newer  
- A free API key from [OpenWeatherMap.org](https://openweathermap.org/)  
- The `simplexml` PHP extension enabled  

## Installation

1. Download the `weather.php` file.
2. Register at [OpenWeatherMap.org](https://openweathermap.org/) and obtain a free API key.
3. Paste your API key into the `$PHP_weather_apikey` variable.

## Usage

1. Create an object for the city you need the weather for:
```php
// Create an object for Warsaw
$weather = new CityWeatherLoader('Warsaw');
```
2. Retrieving specific data and format:
```php
echo $weather->getTemperature(true);
//It will return a value together with a symbol, example 13°C
```

```php
echo $weather->getTemperature(false);
//Will return just temperature value, without °C or °F, example: 13
```

3. Metric values to imperial values

Change:
```php
define("weather_unit", 'metric');
```
to:
```php
define("weather_unit", 'imperial');
```

## Usage Examples

### Full example

```php
// Create an object for Warsaw
$weather = new CityWeatherLoader('Warsaw');

// Fetch basic data
echo "Temperature: " . $weather->getTemperature(true) . '<br>';
echo "Humidity: " . $weather->getHumidity(true) . '<br>';
echo "Pressure: " . $weather->getPressure(true) . '<br>';
echo "Wind: " . $weather->getWindSpeed(true);
```

Output:

> Temperature: 13°C   
> Humidity: 53%   
> Pressure: 1014 hPa   
> Wind: 5.5 km/h

### Full weather description with icon

```php
$weather = new CityWeatherLoader('Kraków');
echo $weather->getWeather(true); // With weather icon
```
Output:

> ![image](https://github.com/user-attachments/assets/2f240457-eb93-4c34-be71-2a870d5f5829)

### All data as an array

```php
$weather = new CityWeatherLoader('London');
$allData = $weather->getDetailedWeather();
print_r($allData);
```

Output:

> Array ( [city] => London [temperature] => 16°C [humidity] => 53% [pressure] => 1017 hPa [wind_speed] => 20.4 km/h [wind_direction] => 210° [description] => overcast clouds [descriptionTranslated] => całkowite zachmurzenie ) 

## Available Methods

$unit = true; //if you need 13°C as output   
or    
$unit = false; //if you need 13 as output   

| Method                      | Description                | Parameter                         |
|-----------------------------|----------------------------|------------------------------------|
| `getTemperature($unit)`     | Gets temperature           | `$unit` - add °C/°F                |
| `getHumidity($unit)`        | Gets humidity              | `$unit` - add %                    |
| `getPressure($unit)`        | Gets pressure              | `$unit` - add hPa                  |
| `getWindSpeed($unit)`       | Gets wind speed            | `$unit` - add km/h                 |
| `getWindDirection()`        | Gets wind direction        | -                                  |
| `getWeather($icon)`         | Full weather description   | `$icon` - add icon                 |
| `getDetailedWeather()`      | All data as an array       | -                                  |

## Supported Units

The class uses the metric system by default (°C, km/h, hPa). You can switch to imperial units (°F, mph) in the configuration.

## Translations

The class automatically translates weather descriptions from English to Polish, supporting over 40 different weather conditions. You can easily change the translation to another language. 

## Error Handling

The class automatically handles:

- Invalid API keys
- Internet connection issues
- Invalid city names
- XML parsing errors

## License

Project available under the MIT license.
