<?php

namespace Controllers;

use \Core\View;
use \Models\Dummy;

/**
 * Home controller
 * 
 * PHP version 7.0
 */
class Home extends \Core\Controller
{
    /**
     * Display a html page
     *
     * Request via http://127.0.0.1/
     * Request via http://127.0.0.1/home/index
     * 
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('index.html');
    }
    
    /**
     * Example: Redirect to another page
     * 
     * Request via http://127.0.0.1/home/redirect-to-index
     *
     * @return void
     */
    public function redirectToIndexAction()
    {
        $this->redirect('/');
    }
    
    /**
     * Example: Get a dynamic parameter (here id) from the url
     * 
     * Request via http://127.0.0.1/home/42/get-id-parameter
     *
     * @return void
     */
    public function getIdParameterAction()
    {
        echo $this->request->params['id'];
    }
    
    /**
     * Example: Get data from a model and parse it to a view
     * 
     * !!! This method is only for demonstration and will not work if requested.
     *
     * @return void
     */
    public function dummyAction()
    {
        $data = Dummy::getAll();
        
        View::renderTemplate('page.html', [
            'data' => $data
        ]);
    }
}
