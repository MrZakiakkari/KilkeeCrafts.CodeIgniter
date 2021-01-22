<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kilkeekrafts extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('ProductServices');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('session'); 
		$this->load->helper('cookie');

	}

	public function index()
	{	
		$this->load->view('header');  
			//If user is logged in aready
            if($this->session->userdata('email') )
			{
				//the user is already logged in -> display the index page with secret content
				redirect('ProductController');
            }
            if(isset($_COOKIE['Cookie_Email']))
			{
                 redirect('Product');
             }
              
            
			else
			{
				//user isn't logged in -> display login form
				$this->load->view('index');
            } 
            
	
		
	}

}