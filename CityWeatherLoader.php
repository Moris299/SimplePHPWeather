<?php

//CODE BY Maurycy Kaczmarek. 
//You can check if everything works by using the test function at the bottom of the page.
//Version: 2.0 (The previous versions did not work with PHP 8+)
//API KEY from openweathermap.org here:
$PHP_weather_apikey = 'YOUR_API_KEY';

// Definicja klucza API dla OpenWeatherMap
define("weather_apikey", "$PHP_weather_apikey");

// Definicja jednostek: 'metric' (kilometry, Celsjusz...) lub 'imperial' (mile, Fahrenheit...)
define("weather_unit", 'metric');

/**
 * Klasa do pobierania i wyświetlania danych pogodowych dla wybranego miasta
 * Wykorzystuje API OpenWeatherMap - kompatybilna z PHP 8+
 */
class CityWeatherLoader {

    private string $url;           // URL do API OpenWeatherMap
    private string $cityName;      // Nazwa miasta
    private SimpleXMLElement $xmlData; // Dane XML z API
    private array $translation;    // Tablica z tłumaczeniami

    /**
     * Konstruktor klasy - inicjalizuje połączenie z API i pobiera dane pogodowe
     * @param string $cityName Nazwa miasta dla którego pobieramy pogodę
     * @throws Exception Gdy nie można pobrać danych z API
     */
    public function __construct(string $cityName) {
        $this->cityName = $cityName;

// Sprawdź czy klucz API jest ustawiony
        if (empty(weather_apikey) || weather_apikey === 'TUTAJ_WKLEJ_SWOJ_KLUCZ_API') {
            throw new Exception("Klucz API nie został ustawiony! Wklej swój klucz z openweathermap.org");
        }

// Budowanie URL do API z odpowiednimi parametrami
        $this->url = 'https://api.openweathermap.org/data/2.5/weather?appid=' . weather_apikey . '&units=' . weather_unit . '&mode=xml&q=' . urlencode($this->cityName);

// Pobieranie danych XML z API pogodowego z obsługą błędów
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'method' => 'GET',
                'header' => 'User-Agent: Mozilla/5.0',
                'ignore_errors' => true
            ]
        ]);

        $xmlContent = file_get_contents($this->url, false, $context);

        if ($xmlContent === false) {
            $error = error_get_last();
            throw new Exception("Nie można połączyć się z API: " . ($error['message'] ?? 'Nieznany błąd'));
        }

// Sprawdź czy odpowiedź zawiera błąd API
        if (strpos($xmlContent, '<message>') !== false || strpos($xmlContent, 'Invalid API key') !== false) {
            throw new Exception("Błąd API - sprawdź klucz API lub nazwę miasta: " . $this->cityName);
        }

        try {
            $this->xmlData = new SimpleXMLElement($xmlContent);
        } catch (Exception $e) {
            throw new Exception("Błąd parsowania danych XML: " . $e->getMessage());
        }

// *** SŁOWNIK TŁUMACZEŃ *** :
// Tablica tłumaczeń opisów pogody z angielskiego na polski
        $this->translation = array(
// Zachmurzenie
            'clear sky' => 'bezchmurne niebo',
            'few clouds' => 'niewielkie zachmurzenie',
            'scattered clouds' => 'rozproszone chmury',
            'broken clouds' => 'zachmurzenie umiarkowane',
            'overcast clouds' => 'całkowite zachmurzenie',
            // Opady deszczu
            'light rain' => 'lekki deszcz',
            'moderate rain' => 'umiarkowany deszcz',
            'heavy intensity rain' => 'intensywny deszcz',
            'very heavy rain' => 'bardzo intensywny deszcz',
            'extreme rain' => 'ekstremalny deszcz',
            'freezing rain' => 'marznący deszcz',
            'shower rain' => 'przelotny deszcz',
            'light intensity shower rain' => 'lekka przelotna mżawka',
            'heavy intensity shower rain' => 'intensywny przelotny deszcz',
            'ragged shower rain' => 'nieregularne przelotne opady',
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

    /**
     * Pobiera temperaturę (kompatybilne z PHP 8)
     * @param bool $displayUnit Czy dodać jednostkę temperatury do wyniku
     * @return string Temperatura (z jednostką jeśli $displayUnit = true)
     */
    public function getTemperature(bool $displayUnit = false): string {
// Konwersja SimpleXMLElement na float przed zaokrągleniem (PHP 8 wymagana)
        $temperatureValue = (float) $this->xmlData->temperature['value'];
        $returnString = (string) round($temperatureValue);

// Dodanie jednostki temperatury jeśli wymagane
        if ($displayUnit) {
            if (weather_unit == 'imperial') {
                $returnString .= '°F';
            } elseif (weather_unit == 'metric') {
                $returnString .= '°C';
            }
        }
        return $returnString;
    }

    /**
     * Pobiera wilgotność powietrza (kompatybilne z PHP 8)
     * @param bool $displayUnit Czy dodać znak % do wyniku
     * @return string Wilgotność (z % jeśli $displayUnit = true)
     */
    public function getHumidity(bool $displayUnit = false): string {
// Konwersja SimpleXMLElement na string (PHP 8)
        $returnString = (string) $this->xmlData->humidity['value'];

// Dodanie znaku % jeśli wymagane
        if ($displayUnit) {
            $returnString .= '%';
        }

        return $returnString;
    }

    /**
     * Pobiera ciśnienie atmosferyczne (kompatybilne z PHP 8)
     * @param bool $displayUnit Czy dodać jednostkę hPa do wyniku
     * @return string Ciśnienie (z hPa jeśli $displayUnit = true)
     */
    public function getPressure(bool $displayUnit = false): string {
// Konwersja SimpleXMLElement na string (PHP 8)
        $returnString = (string) $this->xmlData->pressure['value'];

// Dodanie jednostki ciśnienia jeśli wymagane
        if ($displayUnit) {
            $returnString .= ' hPa';
        }

        return $returnString;
    }

    /**
     * Pobiera prędkość wiatru (kompatybilne z PHP 8)
     * @param bool $displayUnit Czy dodać jednostkę prędkości do wyniku
     * @return string Prędkość wiatru (z jednostką jeśli $displayUnit = true)
     */
    public function getWindSpeed(bool $displayUnit = false): string {
// Konwersja SimpleXMLElement na float (PHP 8)
        $windSpeed = (float) $this->xmlData->wind->speed['value'];

// Konwersja z m/s na km/h dla jednostek metrycznych
        if (weather_unit == 'metric') {
            $returnString = (string) round($windSpeed * 3.6, 1);
        } else {
            $returnString = (string) $windSpeed;
        }

// Dodanie jednostki prędkości jeśli wymagane
        if ($displayUnit) {
            if (weather_unit == 'metric') {
                $returnString .= ' km/h';
            } elseif (weather_unit == 'imperial') {
                $returnString .= ' mph';
            }
        }

        return $returnString;
    }

    /**
     * Pobiera kierunek wiatru (opcjonalnie)
     * @return string Kierunek wiatru w stopniach
     */
    public function getWindDirection(): string {
        return isset($this->xmlData->wind->direction['value']) ? (string) $this->xmlData->wind->direction['value'] . '°' : 'brak danych';
    }

    /**
     * Pobiera pełny opis pogody z ikoną (opcjonalnie) - kompatybilne z PHP 8
     * @param bool $displayIcon Czy wyświetlić ikonę pogody
     * @return string Pełny opis pogody dla miasta
     */
    public function getWeather(bool $displayIcon = false): string {
        $returnString = '';

// Dodanie ikony pogody jeśli wymagane
        if ($displayIcon) {
            $iconCode = (string) $this->xmlData->weather['icon'];
            $returnString = '<img style="float: left; height: 20px; margin-right: 5px;" src="https://openweathermap.org/img/w/' . $iconCode . '.png" alt="Ikona pogody" />';
        }

// Dodanie nazwy miasta
        $returnString .= $this->cityName . ': ';

// Dodanie temperatury z jednostką
        $returnString .= $this->getTemperature(true) . ', ';

// Pobranie opisu pogody w języku angielskim (konwersja dla PHP 8)
        $weatherInEnglish = (string) $this->xmlData->weather['value'];

// Tłumaczenie na język polski jeśli dostępne
        if (empty($this->translation[$weatherInEnglish])) {
// Jeśli brak tłumaczenia, używamy angielskiego opisu
            $returnString .= $weatherInEnglish;
        } else {
// Używamy polskiego tłumaczenia
            $returnString .= $this->translation[$weatherInEnglish];
        }

        return $returnString;
    }

    /**
     * Pobiera szczegółowe informacje pogodowe
     * @return array Tablica ze wszystkimi danymi pogodowymi
     */
    public function getDetailedWeather(): array {
        return [
            'city' => $this->cityName,
            'temperature' => $this->getTemperature(true),
            'humidity' => $this->getHumidity(true),
            'pressure' => $this->getPressure(true),
            'wind_speed' => $this->getWindSpeed(true),
            'wind_direction' => $this->getWindDirection(),
            'description' => (string) $this->xmlData->weather['value'],
            'descriptionTranslated' => $this->translation[(string) $this->xmlData->weather['value']] ?? (string) $this->xmlData->weather['value']
        ];
    }
}

// *** TEST FUNCTION - COMMENT OUT BEFORE PRODUCTION DEPLOYMENT ***
// Example call to check weather for Warsaw]\
/*
echo 'Weather for London';
$weather = new CityWeatherLoader('London');
echo "Temperature: " . $weather->getTemperature(true) . '<br>';
echo "Humidity: " . $weather->getHumidity(true) . '<br>';
echo "Pressure: " . $weather->getPressure(true) . '<br>';
echo "Wind: " . $weather->getWindSpeed(true) . " at " . $weather->getWindDirection() . '<br><hr>';
echo "Description: " . $weather->getWeather(true) . '<br>';

// Get all data as array
$allData = $weather->getDetailedWeather();
print_r($allData);
 */
?>
