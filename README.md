Oczywiście! Oto poprawiona wersja pliku README.md z odpowiednim formatowaniem Markdown do publikacji na GitHubie:

---

# SimplePHPWeather

Prosta klasa PHP do pobierania danych pogodowych z API OpenWeatherMap. Automatycznie tłumaczy opisy pogody z angielskiego na polski.

## Opis

Klasa `CityWeatherLoader` pozwala na łatwe pobieranie aktualnych danych pogodowych dla dowolnego miasta na świecie. Wykorzystuje API OpenWeatherMap i jest kompatybilna z PHP 8+.

## Wymagania

- PHP 8.0 lub nowszy  
- Darmowy klucz API z [OpenWeatherMap.org](https://openweathermap.org/)  
- Włączone rozszerzenie `simplexml` w PHP  

## Instalacja

1. Pobierz plik `weather.php`.
2. Zarejestruj się na [OpenWeatherMap.org](https://openweathermap.org/) i uzyskaj darmowy klucz API.
3. Wklej swój klucz API w zmiennej `$PHP_weather_apikey`.

## Przykłady użycia

### Podstawowe pobieranie danych

```php
// Utwórz obiekt dla Warszawy
$weather = new CityWeatherLoader('Warsaw');

// Pobierz podstawowe dane
echo "Temperatura: " . $weather->getTemperature(true);
echo "Wilgotność: " . $weather->getHumidity(true);
echo "Ciśnienie: " . $weather->getPressure(true);
echo "Wiatr: " . $weather->getWindSpeed(true);
```

### Pełny opis pogody z ikoną

```php
$weather = new CityWeatherLoader('Kraków');
echo $weather->getWeather(true); // Z ikoną pogody
```

### Wszystkie dane jako tablica

```php
$weather = new CityWeatherLoader('London');
$allData = $weather->getDetailedWeather();
print_r($allData);
```

## Dostępne funkcje

| Funkcja                   | Opis                     | Parametr                |
|---------------------------|--------------------------|-------------------------|
| `getTemperature($unit)`   | Pobiera temperaturę      | `$unit` - czy dodać °C/°F |
| `getHumidity($unit)`      | Pobiera wilgotność       | `$unit` - czy dodać %     |
| `getPressure($unit)`      | Pobiera ciśnienie        | `$unit` - czy dodać hPa   |
| `getWindSpeed($unit)`     | Pobiera prędkość wiatru  | `$unit` - czy dodać km/h  |
| `getWindDirection()`      | Pobiera kierunek wiatru  | -                         |
| `getWeather($icon)`       | Pełny opis pogody        | `$icon` - czy dodać ikonę |
| `getDetailedWeather()`    | Wszystkie dane jako tablica | -                      |

## Obsługiwane jednostki

Klasa automatycznie używa systemu metrycznego (°C, km/h, hPa). Można zmienić na imperialny (°F, mph) w konfiguracji.

## Tłumaczenia

Klasa automatycznie tłumaczy opisy pogody z angielskiego na polski, obsługując ponad 40 różnych warunków pogodowych.

## Obsługa błędów

Klasa automatycznie obsługuje:

- Błędne klucze API
- Problemy z połączeniem internetowym
- Nieprawidłowe nazwy miast
- Błędy parsowania danych XML

## Licencja

Projekt dostępny na licencji MIT.

---

Jeśli chcesz dodać sekcję kontaktową, przykładowy nagłówek:

## Kontakt

W przypadku pytań lub sugestii, proszę pisać na [Twój e-mail lub GitHub Issues].

---

Daj znać, jeśli chcesz dodać lub zmienić coś jeszcze!

---
Odpowiedź od Perplexity: pplx.ai/share
