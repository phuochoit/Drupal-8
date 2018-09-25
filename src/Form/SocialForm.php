<?php
namespace Drupal\custom_admin\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SocialForm extends ConfigFormBase {
	/**
	 * get config data use by class
	 */
	protected function getEditableConfigNames() {
		return ('custom_admin.social');
	}

	/**
	 * get form id
	 */
	public function getFormId() {
		return 'custom_admin_social_form';
	}

	/**
	 * custom form field
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		// $config = $this->config('custom_admin.social');
		
		$form['social_facebook_link'] = array(
			'#type' => 'textfield', 
			'#title' => t('Facebook'), 
			'#size' => 60, 
			'#maxlength' => 255, 
			'#required' => TRUE,
			'#default_value' => \Drupal::config('custom_admin.social')->get('facebook_link') 
			
		);
		$form['social_google_link'] = array(
			'#type' => 'textfield', 
			'#title' => t('Google'), 
			'#size' => 60, 
			'#maxlength' => 255, 
			'#required' => TRUE,
			'#default_value' => \Drupal::config('custom_admin.social')->get('google_link')
			
		);

		$form['actions'] = [
			'#type' => 'actions',
		];

		// Add a submit button that handles the submission of the form.
		$form['actions']['submit'] = [
			'#type' => 'submit',
			'#value' => $this->t('Submit'),
		];

		return parent::buildForm($form, $form_state);
	}

  
	/**
	 * validate form
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		$facebook = $form_state->getValue('social_facebook_link');
		$google = $form_state->getValue('social_google_link');
		if(empty($facebook) || empty($google)){
			$form_state->setErrorByName('social_facebook_link', $this->t('Link Facebook and Google not empty!'));
		}
		parent::validateForm($form, $form_state);

	}
	/**
	 * from submit
	 */		
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->configFactory->getEditable('custom_admin.social')
		->set('facebook_link', $form_state->getValue('social_facebook_link'))
		->set('google_link', $form_state->getValue('social_google_link'))
		->save();
    	parent::submitForm($form, $form_state);
	}

}