<?php

namespace  Drupal\weather;
use Drupal\Component\Serialization\Json;

use \GuzzleHttp\Client;

/**
 * service provides weather data
 * @parameter 'city' is city name
 * city name like pune, mumbai, kolkata, etc.
 */
class WeatherService{
    function get_wheather_data($city)
    {
        $config = \Drupal::config('weather.settings');
        $appid= $config->get('appid');
        $client = new Client();
        $response = $client->request('GET', 'https://samples.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$appid);
        $res = Json::decode($response->getBody());
        $temp_min = ceil($res['main']['temp_min']);
        $temp_max = ceil($res['main']['temp_max']);
        $pressure = ceil($res['main']['pressure']);
        $humidity = ceil($res['main']['humidity']);
        $speed = ceil($res['wind']['speed']);
        \Drupal::logger('my_module')->notice("temp min:".$temp_min." temp max:".$temp_max." pressure:".$pressure." humidity:".$humidity." speed:".$speed);
        return $response->getBody();
    }
    // service for rounded off data
    // returning array of temp_min,temp_max,pressure,humidity,speed
    function get_wheather_data_rounded_off($city)
    {
        $config = \Drupal::config('weather.settings');
        $appid= $config->get('appid');
        $client = new Client();
        $response = $client->request('GET', 'https://samples.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$appid);
        $res = Json::decode($response->getBody());
        $temp_min = ceil($res['main']['temp_min']);
        $temp_max = ceil($res['main']['temp_max']);
        $pressure = ceil($res['main']['pressure']);
        $humidity = ceil($res['main']['humidity']);
        $speed = ceil($res['wind']['speed']);
        //this only for debugging purpose if whether it is rounded off or not
        \Drupal::logger('my_module')->notice("temp min:".$temp_min." temp max:".$temp_max." pressure:".$pressure." humidity:".$humidity." speed:".$speed);
        return array(
            '#temp_min' => $temp_min,
            '#temp_max' => $temp_max,
            '#pressure' => $pressure,
            '#humidity' => $humidity,
            '#wind' => $speed,
        );
    }
}