<?php

namespace Controllers;

use \Core\View;
use \Utilities\Auth;
use \Utilities\Flash;

/**
 * Login controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{
    /**
     * Show login page
     *
     * @return void
     */
    public function showAction() 
    {
        $this->requireNoLogin();

        View::renderTemplate('auth/login.html');
    }
    
    /**
     * Log in a user
     *
     * @return void
     */
    public function createAction()
    {
        $this->requireNoLogin();
        
        if (Auth::login($this->request->data('email'), $this->request->data('password'))) {
            
            if ($this->request->data('rememberMe')) {
            
                $user = Auth::getUser();

                if ($user->rememberLogin()) {
                    
                    setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, '/');
                }
            }

            $this->redirect(Auth::getReturnToPage());
        }

        $this->redirect('/login');
    }

    /**
     * Log out user
     *
     * @return void
     */
    public function destroyAction()
    {
        $this->requireLogin();

        Auth::logout();

        $this->redirect('/');
    }
}