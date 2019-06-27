<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Form\FormStateInterface;
/**
 * Provides a 'weather form' block.
 *
 * @Block(
 *   id = "weather_block",
 *   admin_label = @Translation("Weather Block"),
 *   category = @Translation("shows wheather information of city")
 * )
 */

class WeatherBlock extends BlockBase {
    public function blockForm($form, FormStateInterface $form_state) {
        $form['city'] = [  
            '#type' => 'textfield',  
            '#title' => $this->t('city : '),   
        ];
        $form['description'] = [  
            '#type' => 'textfield',  
            '#title' => $this->t('description : '),   
        ];
        $form['image'] = [
            '#type' => 'managed_file',
            '#title' => 'image',
            '#upload_location' => 'public://upload/mayur',
        ];
        return $form;
    }
    public function blockSubmit($form, FormStateInterface $form_state) {
        
        $c = $form_state->getValues();
        $this->setConfigurationValue('city',$c['city']);
        $this->setConfigurationValue('description',$c['description']);
        $this->setConfigurationValue('image',$c['image']);
        
        
      }
    public function build() {
        $configs=$this->getConfiguration();
        
        //gets app id
        $config = \Drupal::config('weather.settings');
        $appids= $config->get('appid');
      
        //call service and gets information related weather
        $service = \Drupal::service('weather.myservice');
        $ress = $service->get_wheather_data($configs['city']);
        //this only for debugging purpose
        //call this service when needed rounded off data
        $resscheck = $service->get_wheather_data_rounded_off($configs['city']);
        $re = Json::decode($ress);
        
        $image=$configs['image'];
        $image_uri = \Drupal\file\Entity\File::load($image[0]);
        $image_uri->setPermanent();
        $image_uri->save();
        
        return array(
            '#theme' => 'weather_block',
            '#temp_min' => $this->t((string) $re['main']['temp_min']),
            '#temp_max' => $this->t((string) $re['main']['temp_max']),
            '#pressure' => $this->t((string) $re['main']['pressure']),
            '#humidity' => $this->t((string) $re['main']['humidity']),
            '#wind' => $this->t((string) $re['wind']['speed']),
            '#city' => $configs['city'],
            '#description' => $configs['description'],
            '#image' => $image_uri->getFileUri(),
          );
    }  
      
}
