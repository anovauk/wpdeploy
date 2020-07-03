<?php
/**
 * SessionController
 *
 * Allows to authenticate users
 */
class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Sign In');
        parent::initialize();
    }
    public function indexAction()
    {
        $this->view->title = $this->config->application->name . ' :: Area Report';
        $this->view->baseUrl = $this->config->application->baseUrl;
    }
    /**
     * Register an authenticated user into session data
     *
     * @param Users $user
     */
    private function _registerSession(Users $user)
    {
        $this->session->set('auth', [
            'id' => $user->id,
            'name' => $user->name
        ]);
    }
    /**
     * This action authenticate and logs an user into the application
     *
     */
    public function startAction()
    {
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $user = Users::findFirst([
                "(email = :email: OR username = :email:) AND active = 'Y'",
                'bind' => ['email' => $email]
            ]);

            if ($user) {
                if (password_verify($password, $user->getPassword())) {
                    // Password matches
                    $this->_registerSession($user);
                    $this->response->redirect('home');
                    $this->view->disable();
                } else {
                    // Password incorrect
                    $this->flash->error('Wrong email/password');
                }
            } else {
                $this->flash->error('Wrong email/password');
            }   
        }
        return $this->dispatcher->forward(
            [
                "controller" => "index",
                "action"     => "index",
            ]
        );
    }
    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction()
    {
        // Remove session info
        $this->session->destroy();
        // Redirect to the main login page
        $this->response->redirect('');
        // Disable view rendering
        $this->view->disable();
    }
}