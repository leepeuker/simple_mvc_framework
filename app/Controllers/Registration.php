<?php

namespace Controllers;

use \Core\View;
use \Models\User;
use \Utilities\Auth;
use \Utilities\Flash;

/**
 * Registration controller
 *
 * PHP version 7.0
 */
class Registration extends \Core\Controller
{
    /**
     * Before filter - called before any action method.
     *
     * @return void
     */
    protected function before() 
    {
        $this->requireNoLogin();
    }
    
    /**
     * Show the registration index page
     *
     * @return void
     */
    public function showAction()
    {
        View::renderTemplate('/auth/registration.html');
    }
    
    /**
     * Register a new user
     *
     * @return void
     */
    public function storeAction()
    {
        if ($this->request->data('password') === $this->request->data('passwordRepeat')) {

            $user = new User($this->request->data());
            
            if ($user->save()) {

                Flash::addMessage('Registration successfull.', Flash::SUCCESS);
                $this->redirect('/login');
            }

        } else {
            Flash::addMessage('The passwords are not matching.', Flash::ERROR);
        }
        
        $this->redirect('/registration');
    }
}