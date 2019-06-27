<?php

namespace Drupal\sendmail\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * class for configuration of email
 */
class MyMail extends ConfigFormBase{
    /**
    * {@inheritdoc}
    */
    protected function getEditableConfigNames() {  
        return [  
          'sendemail.settings',  
        ];  
      }
    
    /**
    * {@inheritdoc}
    */  
    public function getFormId() {  
        return 'sendemail';  
     }

     /**
    * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state){
        $config = $this->config('sendemail.settings');

        $form['email'] = [  
            '#type' => 'email',  
            '#title' => $this->t('email : '), 
            '#default_value' => $config->get('weather.email'),
            '#required' => TRUE  
          ];
        return parent::buildForm($form, $form_state);
    }

    /**
    * {@inheritdoc}
    */
    public function submitForm(array &$form, FormStateInterface $form_state){
        $values = $form_state->getValues();
        $this->config('sendemail.settings')
          ->set('', $values['email'])
          ->save();
        return parent::submitForm($form, $form_state);
    }
}