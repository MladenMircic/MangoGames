<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url'];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		$this->session = \Config\Services::session();
	}

    public function showView($page, $data = []) {
	    $rawData = $this->showAdditionalData();
	    foreach($rawData as $key => $value)
            $data[$key] = $value;
        $data['middlePart'] = view("pages/$page", $data);
        echo view("patterns/default_page_pattern", $data);
    }

    protected function showAdditionalData() {
	    return [];
    }

	public function echoView($page, $additionalData = null)
    {
        if ($additionalData != null)
            $data = $this->{$additionalData}();
        if(isset($data))
	        echo view("pages/$page", $data);
        else echo view("pages/$page");
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url("Login?wantToExit=true"));
    }
}
