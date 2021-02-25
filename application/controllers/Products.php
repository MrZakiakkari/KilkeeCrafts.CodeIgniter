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

	private  function uploadAndResizeFile()
	{ //set config options for thumbnail creation 
		$config['upload_path'] = './assets/images/products/full/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload())
			echo $this->upload->display_errors();
		else
			echo 'upload done<br>';

		$upload_data = $this->upload->data();
		$path = $upload_data['full_path'];

		$config['source_image'] = $path;
		$config['maintain_ratio'] = 'FALSE';
		$config['width'] = '180';
		$config['height'] = '200';

		$this->load->library('image_lib', $config);
		if (!$this->image_lib->resize())
			echo $this->image_lib->display_errors();
		else
			echo 'image resized<br>';
		$this->image_lib->clear();
		return $path;
	}
	private function createThumbnail($path)
	{ //set config options for thumbnail creation 
		$config['source_image'] = $path;
		$config['new_image'] = './assets/images/products/thumbs/';
		$config['maintain_ratio'] = 'FALSE';
		$config['width'] = '42';
		$config['height'] = '42';

		//load library to do the resizing and thumbnail creation 
		$this->image_lib->initialize($config);

		//call function resize in the image library to physiclly create the thumbnail 
		if (!$this->image_lib->resize())
			echo $this->image_lib->display_errors();
		else
			echo 'thumbnail created<br>';
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
