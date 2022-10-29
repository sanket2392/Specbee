<?php  
/**  
 * @file  
 * Contains Drupal\specbee\Form\CustomForm.  
 */  
namespace Drupal\specbee\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  
use \Drupal\user\Entity\User;
  
class CustomForm extends ConfigFormBase {  
    /**  
     * {@inheritdoc}  
     */  
    protected function getEditableConfigNames() {  
        return [  
            'specbee.adminsettings',  
        ];  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function getFormId() {  
        return 'specbee_form';  
    }

    /**  
     * {@inheritdoc}  
     */  
    public function buildForm(array $form, FormStateInterface $form_state) {  
        $config = $this->config('specbee.adminsettings');  
        $form['country'] = [  
            '#type' => 'textfield',  
            '#title' => $this->t('Country'),
            '#required' => TRUE,
            '#default_value' => $config->get('country'),  
        ];  
        $form['city'] = [  
            '#type' => 'textfield',  
            '#title' => $this->t('City'),
            '#required' => TRUE,
            '#default_value' => $config->get('city'),
        ];
        $form['timezone'] = [  
            '#type' => 'select',  
            '#title' => $this->t('Timezone'),
            '#required' => TRUE,
            '#options' => array(
                'ac' => 'America/Chicago',
                'an' => 'America/New_York',
                'at' => 'Asia/Tokyo',
                'ad' => 'Asia/Dubai',
                'ak' => 'Asia/Kolkata',
                'ea' => 'Europe/Amsterdam',
                'eo' => 'Europe/Oslo',
                'el' => 'Europe/London',
            ),
            '#default_value' => $config->get('timezone'),
        ];
        return parent::buildForm($form, $form_state);  
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function submitForm(array &$form, FormStateInterface $form_state) {  
        parent::submitForm($form, $form_state);  

        $key = $form_state->getValue('timezone');
        $val = $form['timezone']['#options'][$key];

        $this->config('specbee.adminsettings')  
            ->set('country', $form_state->getValue('country'))
            ->set('city', $form_state->getValue('city'))  
            ->set('timezone', $form_state->getValue('timezone'))  
            ->save();  

        $user = User::load(\Drupal::currentUser()->id());
        $user->set('timezone',$val);
        $user->save();
        drupal_flush_all_caches();
    }

}
