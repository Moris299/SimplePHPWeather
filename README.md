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

## Usage Examples

### Basic data fetching

```php
// Create an object for Warsaw
$weather = new CityWeatherLoader('Warsaw');

// Fetch basic data
echo "Temperature: " . $weather->getTemperature(true);
echo "Humidity: " . $weather->getHumidity(true);
echo "Pressure: " . $weather->getPressure(true);
echo "Wind: " . $weather->getWindSpeed(true);
```

### Full weather description with icon

```php
$weather = new CityWeatherLoader('Kraków');
echo $weather->getWeather(true); // With weather icon
```

### All data as an array

```php
$weather = new CityWeatherLoader('London');
$allData = $weather->getDetailedWeather();
print_r($allData);
```

## Available Methods

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

The class automatically translates weather descriptions from English to Polish, supporting over 40 different weather conditions.

## Error Handling

The class automatically handles:

- Invalid API keys
- Internet connection issues
- Invalid city names
- XML parsing errors

## License

Project available under the MIT license.
