# SimplePHPWeather

A simple PHP class for fetching and displaying weather data using OpenWeatherMap API.

## Features

- Fetch current weather data for any city worldwide
- Support for both metric and imperial units
- Weather description translation from English to Polish
- Compatible with PHP 8+
- Comprehensive error handling
- XML-based data retrieval
- Multiple data points: temperature, humidity, pressure, wind speed/direction

## Requirements

- PHP 8.0 or higher
- SimpleXML extension (usually included with PHP)
- Internet connection
- OpenWeatherMap API key (free registration at [openweathermap.org](https://openweathermap.org/api))

## Installation

1. Download or clone the repository
2. Include the class file in your project
3. Get your free API key from [OpenWeatherMap](https://openweathermap.org/api)

## Configuration

1. Replace the API key in the code:
```php
$PHP_weather_apikey = 'YOUR_API_KEY_HERE';
```

2. Set your preferred units:
```php
define("weather_unit", 'metric'); // or 'imperial'
```

## Usage

### Basic Example

```php
getWeather(true);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

### Available Methods

#### `getTemperature(bool $displayUnit = false): string`
Returns current temperature, optionally with unit (°C or °F).

#### `getHumidity(bool $displayUnit = false): string`
Returns humidity percentage, optionally with % symbol.

#### `getPressure(bool $displayUnit = false): string`
Returns atmospheric pressure, optionally with hPa unit.

#### `getWindSpeed(bool $displayUnit = false): string`
Returns wind speed, optionally with unit (km/h or mph).

#### `getWindDirection(): string`
Returns wind direction in degrees.

#### `getWeather(bool $displayIcon = false): string`
Returns complete weather description with optional weather icon.

#### `getDetailedWeather(): array`
Returns all weather data as an associative array.

### Complete Example

```php
Weather for London";
    echo "Temperature: " . $weather->getTemperature(true) . "";
    echo "Humidity: " . $weather->getHumidity(true) . "";
    echo "Pressure: " . $weather->getPressure(true) . "";
    echo "Wind: " . $weather->getWindSpeed(true) . " at " . $weather->getWindDirection() . "";
    echo "Description: " . $weather->getWeather(true) . "";
    
    // Get all data as array
    $allData = $weather->getDetailedWeather();
    print_r($allData);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

## Units

- **Metric**: Celsius (°C), kilometers per hour (km/h), hectopascals (hPa)
- **Imperial**: Fahrenheit (°F), miles per hour (mph), hectopascals (hPa)

## Weather Translations

The class includes comprehensive Polish translations for weather descriptions:
- Clear sky conditions
- Cloud coverage variations
- Rain intensities (light, moderate, heavy, extreme)
- Snow conditions
- Thunderstorms
- Drizzle variations
- Fog and atmospheric phenomena
- Extreme weather conditions

## Error Handling

The class handles various error conditions:
- Missing or invalid API key
- Network connectivity issues
- Invalid city names
- API rate limiting
- XML parsing errors

## Troubleshooting

If you encounter errors, check:
1. **API Key**: Ensure your OpenWeatherMap API key is valid and active
2. **Internet Connection**: Verify you have a working internet connection
3. **City Name**: Check that the city name is spelled correctly
4. **PHP Version**: Ensure you're running PHP 8.0 or higher
5. **Extensions**: Verify SimpleXML extension is enabled

## API Rate Limits

Free OpenWeatherMap accounts have the following limits:
- 1,000 API calls per day
- 60 calls per minute

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open source. Please check the license file for details.

## Support

For issues related to:
- **Code bugs**: Open an issue on GitHub
- **API problems**: Check [OpenWeatherMap documentation](https://openweathermap.org/api)
- **General questions**: Create a discussion on GitHub

## Credits

- Weather data provided by [OpenWeatherMap](https://openweathermap.org/)
- Code by xyz

---

**Note**: Remember to remove or comment out the test function before deploying to production.

---
Odpowiedź od Perplexity: pplx.ai/share
