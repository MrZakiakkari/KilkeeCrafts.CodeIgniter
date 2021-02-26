<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Products extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ProductServices');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	public function index()
	{
		$this->load->view('index');
	}
	public function listproducts()
	{
		if ($this->unauthorizedCustomerSessionDetected()) {
			return $this->handleUnauthorizedSession();
		}
		$paginationConfig = array(
			'base_url' => site_url('Products/listproducts/'),
			'total_rows' => $this->ProductServices->getProductCount(),
			'per_page' => 2
		);
		$this->pagination->initialize($paginationConfig);
		$vars = array(
			'products' => $this->ProductServices->getProductRange(2, $this->uri->segment(3))
		);
		$this->load->view('productListView', $vars);
	}
	public function search()
	{
		$criteria = $_GET['search'];
		$vars = array(
			'products' => $this->ProductServices->search($criteria)
		);
		$this->load->view('productListView', $vars);
	}

	public function viewproduct($productId)
	{
		$data = array('product' => $this->ProductServices->getProductById($productId));
		$this->load->view('productView', $data);
	}
	//
	//security functions
	//
	private function handleUnauthorizedSession()
	{
		$this->load->view("403.php");
	}
	private function unauthorizedCustomerSessionDetected()
	{
		return $this->session->userdata("CustomerId") == null;
	}
}
