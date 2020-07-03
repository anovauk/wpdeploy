<?php

use Phalcon\Mvc\Controller;

class IndexController extends ControllerBase {
    
    public function initialize() {
        $this->tag->setTitle('Application');
        parent::initialize();
    }

    public function indexAction() {
    	$this->view->name = $this->config->application->name;
    }
}

?>