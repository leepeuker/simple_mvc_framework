<?php

 /**
  * This file contains configuration for the application.
  * It will be used by /Core/Config.php
  *
  * PHP version 7.0
  */

return array(

    /**
     * Configuration for: Database Connection
     * 
     * Define database constants to establish a connection.
     * DB_SOCKET and DB_CHARSET are optional.
     */
    'DB_HOST'       => '',
    'DB_NAME'       => '',
    'DB_USER'       => '',
    'DB_PASSWORD'   => '',
    'DB_PORT'       => '',
    'DB_SOCKET'     => '',
    'DB_CHARSET'    => '',

    /**
     * Configuration for: Email server credentials
     * 
     * SMTP_USERNAME and SMTP_PASSWORD not required if SMTP_AUTH is set to false.
     * SMTP_SECURE can be left empty or set to 'tls' or 'ssl'.
     */
    'SMTP_DEBUG'        => 0,
    'SMTP_HOST'         => '',
    'SMTP_PORT'         => 25,
    'SMTP_AUTH'         => false,
    'SMTP_USERNAME'     => '',
    'SMTP_PASSWORD'     => '',
    'SMTP_SECURE'       => '',
    'EMAIL_WEBMASTER'   => 'webmaster@localhost.com',

    /**
     * Configuration for: Encryption Keys
     * 
     * Used for token generation.
     */
    'SECRET_KEY' => '',

    /**
     * Configuration for: Misc
     * 
     * - True will use filp/whoops to render and display erros in browser.
     * - False will show custom error pages and log errors to logs/.
     */
    'SHOW_ERRORS' => true
);