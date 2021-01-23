<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Artists extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ArtistRepository');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}

	public function index()
	{
		//load the index page
		$this->load->view('index');
}

	}