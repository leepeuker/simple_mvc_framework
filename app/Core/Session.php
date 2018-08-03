<?php

namespace Core;

/**
 * Handles session management
 *
 * PHP version 7.0
 */
class Session{

    /**
     * Constructor
     */
    private function __construct() {}

    /**
     * Starts the session
     * 
     * @return void
     */
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {

            // Specifies the name of the session which is used as cookie name.
            ini_set('session.name', 'id');
            // Allows access to session ID cookie only when protocol is HTTPS.
            // ini_set('session.cookie_secure', true); 
            // Disallows access to session cookie by JavaScript.
            ini_set('session.cookie_httponly', true);
            // Specifies the lifetime of the cookie in seconds which is sent to the browser
            ini_set('session.cookie_lifetime', 0);
            // Forces sessions to only use cookie to store the session ID on the client side.
            ini_set('session.use_only_cookies', true); 
            // Prevents session module to use uninitialized session ID.
            ini_set('session.use_strict_mode', true); 
            // Makes sure HTTP contents are not cached for authenticated session.
            ini_set('session.cache_limiter', 'nocache'); 
            // Gives a path to an external resource, which will be used as an additional entropy source in the session id creation process.
            ini_set('session.entropy_file', '/dev/urandom'); 
            // Specifies the number of bytes which will be read from the session.entropy_file.
            ini_set('session.entropy_length', '256'); 
            // Specifies the hash algorithm used to generate the session IDs.
            ini_set('session.hash_function', 'sha256'); 
            // Specifies the number of seconds after which data will be seen as 'garbage' and potentially cleaned up..
            ini_set('session.gc_maxlifetime', 3600); 

            session_start();

            self::sessionTimout();
        }
    }

    /**
     * Timeout an too long unused session
     * 
     * @return void
     */
    public static function sessionTimout() 
    {
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {

            self::destroy();
        }

        $_SESSION['last_activity'] = time();
    }

    /**
     * Destroys the session
     * 
     * @return void
     */
    public static function destroy()
    {
        if (session_status() == PHP_SESSION_NONE) {
            
            $_SESSION = [];

            if (ini_get('session.use_cookies')) {

                $params = session_get_cookie_params();

                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }
        }

        if(session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    /**
     * Generate user specific session
     * 
     * @param User $user
     * @return void
     */
    public static function setUser($user)
    {
        if ($user) {

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user->id;

            return TRUE;
        }

        return FALSE;
    }
    
    /**
     * Get active user id
     *
     * @return int|null
     */
    public static function getUserId()
    {
        return empty($_SESSION['user_id']) ? null : (int)$_SESSION['user_id'];
    }

    /**
     * Get active user type
     *
     * @return string|null
     */
    public static function getUserType()
    {
        return empty($_SESSION['user_type']) ? null : $_SESSION['user_type'];
    }
}