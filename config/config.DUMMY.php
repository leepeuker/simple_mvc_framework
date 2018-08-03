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
     */
    'SMTP_DEBUG'        => 0,
    'SMTP_HOST'         => '',
    'SMTP_PORT'         => 25,
    'SMTP_AUTH'         => false,
    'EMAIL_WEBMASTER'   => 'webmaster@localhost.com',

    /**
     * Configuration for: Encryption Keys
     */
    'SECRET_KEY' => '',

    /**
     * Configuration for: Misc
     */
    'SHOW_ERRORS' => true
);