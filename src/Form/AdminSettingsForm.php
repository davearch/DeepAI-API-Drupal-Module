<?php  
/**  
 * @file  
 * Contains Drupal\welcome\Form\MessagesForm.  
 */  
namespace Drupal\deepai\Form;

use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class AdminSettingsForm extends ConfigFormBase
{

    /**  
     * {@inheritdoc}  
     **/
    protected function getEditableConfigNames()
    {
        return [
            'deepai.adminsettings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'deepai_admin_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('deepai.adminsettings');
        $form['deepai_api_key'] = [
            '#type' => 'textfield',
            '#title' => $this->t('DeepAI API Key'),
            '#description' => $this->t('Key to the DeepAI API'),
            '#maxlength' => 64,
            '#size' => 64,
            '#default_value' => $config->get('deepai_api_key'),
        ];
        $form['deepai_base_text'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Base Text'),
            '#description' => $this->t('Text to base generation off of'),
            '#default_value' => $config->get('deepai_base_text'),
        ];
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        parent::submitForm($form, $form_state);
        $this->config('deepai.adminsettings')
          ->set('deepai_api_key', $form_state->getValue('deepai_api_key'))
          ->set('deepai_base_text', $form_state->getValue('deepai_base_text'))
          ->save();
    }
}