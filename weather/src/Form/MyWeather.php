<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * class for configuration of appid
 */
class MyWeather extends ConfigFormBase{
    /**
    * {@inheritdoc}
    */
    protected function getEditableConfigNames() {  
        return [  
          'weather.settings',  
        ];  
      }
    
    /**
    * {@inheritdoc}
    */  
    public function getFormId() {  
        return 'weather';  
     }

     /**
    * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state){
        $config = $this->config('weather.settings');

        $form['appid'] = [  
            '#type' => 'textfield',  
            '#title' => $this->t('App Id : '), 
            '#default_value' => $config->get('weather.appid'),
            '#required' => TRUE  
          ];
        return parent::buildForm($form, $form_state);
    }

    /**
    * {@inheritdoc}
    */
    public function submitForm(array &$form, FormStateInterface $form_state){
        $values = $form_state->getValues();
        $this->config('weather.settings')
          ->set('appid', $values['appid'])
          ->save();
        return parent::submitForm($form, $form_state);
    }
}