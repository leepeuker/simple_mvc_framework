<?php

namespace Controllers;

use \Utilities\Auth;
use \Utilities\Flash;

/**
 * Logout controller
 *
 * PHP version 7.0
 */
class Logout extends \Core\Controller
{
    /**
     * Log out a user
     *
     * @return void
     */
    public function destroyAction()
    {
        Auth::logout();
        $this->redirect('/logout/show-logout-message');
    }

    /**
     * Show "logged out" flash message and redirect to landingpage. 
     *
     * @return void
     */
    public function showLogoutMessageAction()
    {
        Flash::addMessage('Logout successful.', Flash::SUCCESS);

        $this->redirect('/');
    }

    /**
     * Show "logged out" flash message and redirect to landingpage. 
     *
     * @return void
     */
    public function showDeleteMessageAction()
    {
        Flash::addMessage('Your account will be deleted in the next few days by the webmaster.', Flash::INFO);

        $this->redirect('/');
    }
}
