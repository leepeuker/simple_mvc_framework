<?php

namespace Core;

/**
 * Base view
 *
 * PHP version 7.0
 */
class View
{
    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        echo static::getTemplate($template, $args);
    }

    /**
     * Get the contents of a view template using Twig
     *
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     * @return string Rendered template
     */
    public static function getTemplate($template, $args = [])
    {
        static $twig = null;

        $user = \Utilities\Auth::getUser();
        
        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addGlobal('url', $_SERVER['REQUEST_URI']);
            $twig->addGlobal('domain', 'https://'. $_SERVER['SERVER_NAME']);
            $twig->addGlobal('current_user', $user);
            $twig->addGlobal('flash_messages', \Utilities\Flash::getMessages());
        }

        return $twig->render($template, $args);
    }
}
