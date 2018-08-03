<?php

namespace Utilities;

use \Core\Session;
use \Models\User;
use \Models\Employee;
use \Models\RememberedLogin;

/**
 * Provides authentication and authorization services
 *
 * PHP version 7.0
 */
class Auth
{
    /**
     * Login a user
     *
     * @param string $email 
     * @param string $password 
     * 
     * @return boolean True if user was logged in succesfully, false otherwise
     */
    public static function login($email, $password)
    {
        if (!empty($email) && !empty($password)) {

            if ($user = User::findByEmail($email)) {
                
                if (password_verify($password, $user->password_hash)) {
                    
                    return Session::setUser($user);
                }
            }
            
            Flash::addMessage('Your credentials are not correct.', Flash::ERROR);
            
        } else {

            Flash::addMessage('Please enter your email and password.', Flash::ERROR);
        }

        return false;
    }

    /**
     * Logout the user
     *
     * @return void
     */
    public static function logout()
    {
        Session::destroy();
        static::forgetLogin();
    }

    /**
     * Remember the originally-requested page in the session
     *
     * @return void
     */
    public static function rememberRequestedPage()
    {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    }

    /**
     * Get the originally requested page to return to after requiring login, or default to the homepage
     *
     * @return void
     */
    public static function getReturnToPage()
    {
        return $_SESSION['return_to'] ?? '/';
    }

    /**
     * Get the current logged-in user, from the session or the remember-me cookie
     *
     * @return mixed The user model or null if not logged in
     */
    public static function getUser()
    {
        if ($id = Session::getUserId()) {
            
            return User::findByID($id);

        } else {

            return static::loginFromRememberCookie();
        }
    }

    /**
     * Login the user from a remembered login cookie
     *
     * @return mixed The user model if login cookie found; null otherwise
     */
    protected static function loginFromRememberCookie()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $remembered_login = RememberedLogin::findByToken($cookie);

            if ($remembered_login && !$remembered_login->hasExpired()) {

                $user = $remembered_login->getUser();
                static::login($user, false);

                return $user;
            }
        }
    }

    /**
     * Forget the remembered login, if present
     *
     * @return void
     */
    protected static function forgetLogin()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {
            $remembered_login = RememberedLogin::findByToken($cookie);

            if ($remembered_login) {
                $remembered_login->delete();
            }

            setcookie('remember_me', '', time() - 3600);
        }
    }
}
