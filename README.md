# PHPsimpleWeather  
The simplest way to get current the weather in PHP    
Weather data from OpenWeatherMap.org API.     
Script writen in OOP PHP.     

## About this script

Do you want to display temperature on your site? Or maybe any other weather info, like wind speed, pressure, humidity etc?   
This script has been created to make it as simpy as is it posibble.   
This script using OpenWeatherMap.org API. Its totally free if script making no more than 60 calls per minute - on small sites you   propablly never exceed the limit.     

### Prerequisites and installing

You have to:    
     
1. Create free account on [openweathermap.org](https://home.openweathermap.org/users/sign_up)      
2. Get free api key [here](https://home.openweathermap.org/api_keys)      
3. Copy key, open weather_api_key.txt file and paste key, save file      
![copy this](https://i.imgur.com/c3GcWbJ.png)       
   
4. Upload all files to your hosting, into public_html folder.  
   
### How to use? Exapmles and explanation.
   
If you have already uploaded all files to your hosting you can now use this script.    
In file where you want to get weather, for example index.php enter at beginning of your code add:    
   
   
```   
<?php   
require_once('weather_script.php');   
?>   
```
   
Now in whole page (below require line) you can call any Weather functions (list below).    
  
Example, for overall weather info in Paris:   
```   
<?php   
$paris = new city('Paris');   
echo 'Current weather in ' . $paris->get_weather();   
?>   
```  
    
will output:   
```
Current weather in Paris: 2°C, few clouds   
```
   
Get temperature example (it will return INT value)   
```   
<?php   
$london = new city('London');   
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

All functions can return unit name after INT value. You have to only add parameter 'TRUE' when calling function:      
```
$berlin = new city('Berlin');   
echo $berlin->get_temperature();  
//^ it will return "2"  
echo $berlin->get_temperature(TRUE);  
//^ but it will return "2°C"  
```
```
$NY = new city('New York');  
echo $NY->get_pressure();  
//^ it will return "1011"  
echo $NY->get_pressure(TRUE);  
//^ but it will return "1011hPa"  
```   

## Version  
   
Current script version: 0.1   
TODO:  
-more functions  
-better icons images    
   
## Authors   
   
* **Maurycy Kaczmarek**    
    
## License   
    
Totally free to use and edit. Just remember about OpenWeatherMap max 60 calls to API per minute.  
