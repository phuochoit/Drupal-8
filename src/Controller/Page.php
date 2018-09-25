<?php

namespace Drupal\custom_admin\Controller;


/**
 * Simple page controller for drupal.
 */
class Page{

    public function description() {
        $output = array();

        $output['hello_world'] = array(
            '#markup' => $this->t('Hello World!'),
        );
        return $output;
    }

}
