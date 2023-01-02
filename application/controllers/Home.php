<?php
date_default_timezone_set('America/Los_Angeles');

class Home extends CI_Controller{

	public function __construct()
	{
    parent::__construct();
		/*if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") {
			$url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			redirect($url);
			exit;
		}*/
	}


    public function index()
    {
		$this->load->view('welcome_message');
    }
}
