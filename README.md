# PHPsimpleWeather  
The simplest way to get current weather in PHP    
Weather data from OpenWeatherMap.org API.     
Script writen in OOP PHP.     

## About this script

Do you want to display temperature on your site? Or maybe any other weather info, like wind speed, pressure, humidity etc?   
This script has been created to make it as simpy as is it posibble.   
This script using OpenWeatherMap.org API. If script is making LESS than 60 calls per minute it's totatally FREE. On small sites you   propablly never exceed this limit.     

### Prerequisites and installing

You have to:    
     
1. Create free account on [openweathermap.org](https://home.openweathermap.org/users/sign_up)      
2. Get free api key [here](https://home.openweathermap.org/api_keys)      
3. Copy key, open WeatherCityLoader.php and put your key at 5 line of code: 
( define("weather_apikey", "$PHP_weather_apikey");) 
![copy this](https://i.imgur.com/c3GcWbJ.png)       
   
4. Upload all files to your hosting, into public_html folder.  
   
### How to use? Exapmles and explanation.
   
If you have already uploaded all files to your hosting you can now use this script.    
In file where you want to get weather, for example index.php at beginning of your code add:    
   
   
```   
<?php   
require_once('CityWeatherLoader.php');   
?>   
```
   
Now in whole page (below require line) you can call any Weather functions (list below).    
  
Example - overall weather info in Paris:   
```   
<?php   
$paris = new CityWeatherLoader('Paris');   
echo 'Current weather in ' . $paris->get_weather();   
?>   
```  
    
will output:   
```
Current weather in Paris: 2°C, few clouds   
```
   
Example - Get temperature 
```   
<?php   
$london = new CityWeatherLoader('London');   
echo $london->get_temperature();  
?>   
```   
   
will output:  
```  
1   
```   

## All funtions   

get_temperature() - return current temperature in celcius or fahreinheit   
get_humidity() - return current humidity in %    
get_pressure() - return current pressure in hPa     
get_wind_speed() - return current wind speed in kph or mph     
get_weather() - return icon (optional), cityname, temperature, and weather condition.       


All functions can return unit name after INT value. You have to only add parameter 'true' when calling function:      
```
$berlin = new CityWeatherLoader('Berlin');   
echo $berlin->get_temperature();  
//^ it will return "2"  
echo $berlin->get_temperature(true);  
//^ but it will return "2°C"  
```
```
$NY = new CityWeatherLoader('New York');  
echo $NY->get_pressure();  
//^ it will return "1011"  
echo $NY->get_pressure(true);  
//^ but it will return "1011hPa"  
```   

## Version  
   
Current version: 0.2.1  
TODO:  
-more functions  
-better icons images    
   
## Authors   
   
* **Maurycy Kaczmarek**    
    
## License   
    
Totally free to use and edit. Just remember about OpenWeatherMap max 60 calls to API per minute.  
