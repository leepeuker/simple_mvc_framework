<?php

namespace Utilities;

use \Utilities\Auth;

/**
 * Flash messages for one-time display using the session
 * for storage between requests.
 *
 * PHP version 7.0
 */
class Flash
{

    /**
     * Success message type
     * @var string
     */
    const SUCCESS = 'success';

    /**
     * Information message type
     * @var string
     */
    const INFO = 'info';

    /**
     * Warning message type
     * @var string
     */
    const WARNING = 'warning';

    /**
     * Error message type
     * @var string
     */
    const ERROR = 'danger';

    /**
     * Add a message
     *
     * @param string $message The message content
     * @param string $type The optional message type, defaults to SUCCESS
     * @param string $name The optional message name, defaults null
     * 
     * @return void
     */
    public static function addMessage($message, $type = 'success', $name = null)
    {
        if (!isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }

        $_SESSION['flash_notifications'][] = [
            'body' => $message,
            'name' => $name,
            'type' => $type
        ];
    }

    /**
     * Get all the messages
     * 
     * @param boolean $unset If false don't unset the messages 
     *
     * @return mixed An array with all the messages or null if none set
     */
    public static function getMessages($unset = true)
    {
        if (isset($_SESSION['flash_notifications'])) {
            
            $messages = $_SESSION['flash_notifications'];

            if ($unset) {
                unset($_SESSION['flash_notifications']);
            }

            return $messages;
        }
    }
    
    /**
     * Unset all flash messages
     *
     * @return void
     */
    public static function unsetMessages()
    {
        unset($_SESSION['flash_notifications']);
    }

    /**
     * Check if an error message is set
     *
     * @return boolean True if an error message is set, false otherwise
     */
    public static function isErrorMsg()
    {
        if (isset($_SESSION['flash_notifications'])) {

            foreach ($_SESSION['flash_notifications'] as $message) {

                if (in_array(self::ERROR, $message)) {

                    return true;
                }
            }
        }

        return false;
    }
}
