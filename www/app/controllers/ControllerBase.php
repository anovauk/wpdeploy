<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle($this->config->application->name.' :: ');
        $this->view->baseUrl = $this->config->application->baseUrl;
    }
}