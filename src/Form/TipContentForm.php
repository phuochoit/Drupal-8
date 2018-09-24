<?php
/**
 * save config data
 * Protected thường được dùng khi bạn biết chắc là có lớp khác sẽ kế thừa lớp này và những phương thức, thuộc tính đó chỉ được dùng trong lớp kế thừa nó.
 * Public là cấp độ thoáng nhất, nó có thể gọi ở mọi nơi từ trong nội bộ của lớp đến lớp kế thừa nó, thậm chí cả bên ngoài lớp cũng gọi được.
 * Thông thường để an toàn dữ liệu các thuộc tính đều ở dạng private, nhưng điều này rất phiền vì ta phải tạo thêm các hàm SET và GET nên các lập trình viên cũng ít khi sử dụng private. Tuy nhiên có những trường hợp sau ta bắt buộc phải dùng ở dạng private để an toàn cho đối tượng.
 */

namespace Drupal\custom_admin\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class TipContentForm extends ConfigFormBase {
    /**
	 * get config data use by class
	 */
	protected function getEditableConfigNames() {
		return ('custom_admin.tip_content');
    }
    
    /**
	 * get form id
	 */
	public function getFormId() {
		return 'custom_admin_tip_content_form';
    }
    /**
     * buildForm
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $num_tips = $form_state->get('num_tips');
        if ($num_tips === NULL) {
            $name_field = $form_state->set('num_tips', 1);
            $num_tips = 1;
        }
        $form['#tree'] = TRUE;
        $form['tips_fieldset'] = [
            '#type' => 'fieldset',
            '#title' => $this->t('People coming to picnic'),
            '#prefix' => '<div id="names-fieldset-wrapper">',
            '#suffix' => '</div>',
        ];
        for ($i = 0; $i < $num_tips; $i++) {
            $form['tips_fieldset']['name'][$i] = [
                '#type' => 'textfield',
                '#title' => $this->t('Name'),
            ];
        }
        $form['tips_fieldset']['actions'] = [
            '#type' => 'actions',
        ];
        $form['tips_fieldset']['actions']['add_name'] = [
            '#type' => 'submit',
            '#value' => $this->t('Add one more'),
            '#submit' => ['::addOne'],
            '#ajax' => [
                'callback' => '::addmoreCallback',
                'wrapper' => 'names-fieldset-wrapper',
            ],
        ]; 
        // If there is more than one name, add the remove button.
        if ($num_tips > 1) {
            $form['tips_fieldset']['actions']['remove_name'] = [
                '#type' => 'submit',
                '#value' => $this->t('Remove one'),
                '#submit' => ['::removeCallback'],
                '#ajax' => [
                    'callback' => '::addmoreCallback',
                    'wrapper' => 'names-fieldset-wrapper',
                ],
            ];
        }
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        ]; 
        return parent::buildForm($form, $form_state);
    }
    /**
     * Callback for both ajax-enabled buttons.
     *
     * Selects and returns the fieldset with the names in it.
     */
    public function addmoreCallback(array &$form, FormStateInterface $form_state) {
        return $form['tips_fieldset'];
    }
    
     /**
     * Submit handler for the "add-one-more" button.
     *
     * Increments the max counter and causes a rebuild.
     */
    public function addOne(array &$form, FormStateInterface $form_state) {
        $name_field = $form_state->get('num_tips');
        $add_button = $name_field + 1;
        $form_state->set('num_tips', $add_button);
        $form_state->setRebuild();
    }
     /**
     * Submit handler for the "remove one" button.
     *
     * Decrements the max counter and causes a form rebuild.
     */
    public function removeCallback(array &$form, FormStateInterface $form_state) {
        $name_field = $form_state->get('num_tips');
        if ($name_field > 1) {
            $remove_button = $name_field - 1;
            $form_state->set('num_tips', $remove_button);
        }
        $form_state->setRebuild();
    }
    /**
	 * validate form
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
        // watting
        // parent::validateForm($form, $form_state);
    }

    /**
	 * from submit
	 */		
	public function submitForm(array &$form, FormStateInterface $form_state) {
        // watting
    }
}