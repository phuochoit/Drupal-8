<?php

namespace Drupal\custom_admin\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Simple page controller for drupal.
 */
class Page extends ControllerBase{

    public function description() {
        $output = array();

        $output['hello_world'] = array(
            '#markup' => $this->t('Hello World!'),
        );
        return $output;
    }

}
