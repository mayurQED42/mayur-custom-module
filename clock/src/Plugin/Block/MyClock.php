<?php

namespace Drupal\clock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Form\FormStateInterface;
use \GuzzleHttp\Client;
/**
 * Provides a 'clock form' block.
 *
 * @Block(
 *   id = "clock_block",
 *   admin_label = @Translation("clock Block"),
 *   category = @Translation("shows time information of timezone")
 * )
 */

class MyClock extends BlockBase {
    public function blockForm($form, FormStateInterface $form_state) {
        $form['timezone'] = [  
            '#type' => 'textfield',  
            '#title' => $this->t('timezone : '),   
        ];
        return $form;
    }
    public function blockSubmit($form, FormStateInterface $form_state) {
        
        $c = $form_state->getValues();
        $this->setConfigurationValue('timezone',$c['timezone']); 
      }
    public function build() {
        $configs=$this->getConfiguration();
        
        $timezone = $configs['timezone'];
        $client = new Client();
        $response = $client->request('GET', 'http://worldclockapi.com/api/json/'.$timezone.'/now');
        $res = Json::decode($response->getBody());
        $form['time'] = [  
            '#type' => 'textfield',  
            '#title' => $this->t($timezone.' zone'),  
            '#value' => $this->t($res['currentDateTime']),
        ];
        return $form;
    }  
      
}