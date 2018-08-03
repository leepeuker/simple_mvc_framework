<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer autoload
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Set base file paths
 */
define('BASE_DIR', str_replace('\\', '/', dirname(__DIR__)) . '/');
define('APP_DIR',  BASE_DIR . '/app/');
define('PUBLIC_DIR',  BASE_DIR . '/app/');

/**
 * Error and Exception handling
 */
if (Core\Config::get('SHOW_ERRORS') === true) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
} else {
    error_reporting(E_ALL); 
    set_error_handler('Core\Error::errorHandler');
    set_exception_handler('Core\Error::exceptionHandler');
}

/**
 * Start the session
 */
Core\Session::start();


/** 
 * Get the router
 */
$router = new Core\Router();

// Add routes
$router->add('/{controller}/{action}');
$router->add('/{controller}/{id:\d+}/{action}');

$router->add('/', ['controller' => 'Home', 'action' => 'index']);
$router->add('/login', ['controller' => 'Login', 'action' => 'show']);
$router->add('/logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('/registration', ['controller' => 'Registration', 'action' => 'show']);

/** 
 * Dispatch the request
 */
$router->dispatch(new Core\Request());