<?php
/**
 * ErrorsController
 * Manage errors
 */
class ErrorsController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Oops!');
        parent::initialize();
    }
    public function show404Action()
    {
        $this->view->title = $this->config->application->name . ' :: 404 Not Found';
        $this->view->baseUrl = $this->config->application->baseUrl;
    }
    public function show401Action()
    {
        $this->view->title = $this->config->application->name . ' :: 401 Not Authorised';
        $this->view->baseUrl = $this->config->application->baseUrl;
    }
    public function show500Action()
    {
        $this->view->title = $this->config->application->name . ' :: 500 Internal Server Error';
        $this->view->baseUrl = $this->config->application->baseUrl;
    }
}