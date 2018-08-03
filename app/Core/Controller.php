<?php

namespace Core;

use \Utilities\Auth;
use \Utilities\Flash;
use \Utilities\Log;

/**
 * Base controller
 *
 * PHP version 7.0
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var Request
     */
    protected $request = null;

    /**
     * Parameters from the datatable request
     * @var array
     */
    protected $datatablesReq = [];

    /**
     * Class constructor
     * 
     * @param Request $request Request object
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Used to execute before and after methods on action method. 
     * Action methods need to be named with an "Action" suffix.
     *
     * @param string $name Method name
     * @param array  $args Arguments passed to the method
     * 
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {

            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this), 404);
        }
    }

    /**
     * Before filter - called before any action method.
     *
     * @return void
     */
    protected function before() {}

    /**
     * After filter - called after any action method.
     *
     * @return void
     */
    protected function after() {}

    /**
     * Redirect to a different page
     *
     * @param string $url The relative URL
     * 
     * @return void
     */
    public function redirect($url)
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
        exit;
    }

    /**
     * Require the user to be logged in before giving access to the requested page.
     *
     * @return void
     */
    public function requireLogin()
    {
        if (!$this->user = Auth::getUser()) {

            Auth::rememberRequestedPage();
            Flash::addMessage('Please login to access that page.', Flash::ERROR);

            $this->redirect('/');
        }
    }

    /**
     * Require the user not to be logged in before giving access to the requested page.
     *
     * @return void
     */
    public function requireNoLogin()
    {
        if (Auth::getUser()) {

            $this->redirect('/');
        }
    }

    /**
     * Get mime type
     * 
     * @param string $file File location 
     * 
     * @return string Mime type of file
     */
    protected function convertDatatablesRequest() 
    {
        $this->datatablesReq['orderColNumber'] = $_POST['order'][0]['column'];

        $this->datatablesReq['orderColDirection'] = $_POST['order'][0]['dir'];

        $this->datatablesReq['orderColName'] = $_POST['columns'][$this->datatablesReq['orderColNumber']]['data'];

        $this->datatablesReq['search'] = $_POST['search']['value'];

        $this->datatablesReq['length'] = $_POST['length'];
        
        $this->datatablesReq['start'] = $_POST['start'];

        $this->datatablesReq['draw'] = $_POST['draw'];
    }
}
