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
		//load the index page
		$this->load->view('index');
	}

	public function listproducts()
	{ //config options for pagination
		$paginationConfig = array(
			'base_url' => site_url('Products/listproducts/'),
			'total_rows' => $this->ProductServices->getProductCount(),
			'per_page' => 2
		);
		$this->pagination->initialize($paginationConfig);
		$data['products'] = $this->ProductServices->getProductRange(2, $this->uri->segment(3));
		$this->load->view('productListView', $data);
	}
	public function search()
	{
		$criteria = $_GET['search'];
		$data['product_info'] = $this->ProductServices->search($criteria);
		$this->load->view('index', $data);
	}
	public function editproduct($productId)
	{
		$data = array("product" => $this->ProductServices->getProductById($productId));
		$this->load->view('updateproductView', $data);
	}

	public function viewproduct($productId)
	{
		$data = array('product' => $this->ProductServices->getProductById($productId));
		$this->load->view('productView', $data);
	}

	public function deleteproduct($productId)
	{
		$deletedRows = $this->ProductServices->deleteProductById($productId);
		if ($deletedRows > 0)
			$data['message'] = "$deletedRows product has been deleted";
		else
			$data['message'] = "There was an error deleting the product with an ID of $productId";
		$this->load->view('displayMessageView', $data);
	}
	public function updateproduct($productId)
	{
		$pathToFile = $this->uploadAndResizeFile();
		$this->createThumbnail($pathToFile);

		//set validation rules
		$this->form_validation->set_rules('Id', 'Product Code', 'required');
		$this->form_validation->set_rules('Description', 'Description', 'required');
		$this->form_validation->set_rules('Category', 'Category', 'required');
		$this->form_validation->set_rules('Artist', 'Artist', 'required');
		$this->form_validation->set_rules('QtyInStock', 'Product in stock', 'required');
		$this->form_validation->set_rules('BuyCost', 'Cost', 'required');
		$this->form_validation->set_rules('SalePrice', 'Sale Price', 'required');
		$this->form_validation->set_rules('priceAlreadyDiscounted', 'Discount', 'required');

		$product = array(
			"Id" => $this->input->post('Id'),
			"Description" => $this->input->post('Description'),
			"Category" => $this->input->post('Category'),
			"Artist" => $this->input->post('Artist'),
			"QtyInStock" => $this->input->post('QtyInStock'),
			"BuyCost" => $this->input->post('BuyCost'),
			"SalePrice" => $this->input->post('SalePrice'),
			"priceAlreadyDiscounted" => $this->input->post('priceAlreadyDiscounted'),
			"Photo" => $_FILES['userfile']['name']
		);

		var_dump($product);


		//check if the form has passed validation
		if (!$this->form_validation->run()) {
			//validation has failed, load the form again
			$this->load->view('updateproductView', array("product" => $product));
			return;
		}


		$productUpdated = $this->ProductServices->updateProduct($product);
		//check if update is successful
		if ($productUpdated) {
			redirect('Products/listproducts');
		} else {
			$data['message'] = "Uh oh ... problem on update";
			$data['product'] = $product;
			$this->load->view('updateproductView', $data);
		}
	}
	function uploadAndResizeFile()
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
	function createThumbnail($path)
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
	public function handleSessionSecurity()
	{
		redirect("user/unauthorized");

	}
	public function unauthorizedSessionDetected()
	{
		return $this->session->userdata('AdminId') == null;
	
	}
	public function handleInsert()
	{
		if($this->unauthorizedSessionDetected())
		{
			return $this->handleSessionSecurity();
		}

		//if the user has submitted the form
		if ($this->input->post('submitInsert')) {

			$pathToFile = $this->uploadAndResizeFile();
			$this->createThumbnail($pathToFile);

			//set validation rules
			$this->form_validation->set_rules('Id', 'Product Code', 'required');
			$this->form_validation->set_rules('Description', 'Description', 'required');
			$this->form_validation->set_rules('Category', 'Category', 'required');
			$this->form_validation->set_rules('Artist', 'Artist', 'required');
			$this->form_validation->set_rules('QtyInStock', 'Product in stock', 'required');
			$this->form_validation->set_rules('BuyCost', 'Cost', 'required');
			$this->form_validation->set_rules('SalePrice', 'Sale Price', 'required');
			$this->form_validation->set_rules('priceAlreadyDiscounted', 'Discount', 'required');

			//get values from post
			$product['Id'] = $this->input->post('Id');
			$product['Description'] = $this->input->post('Description');
			$product['Category'] = $this->input->post('Category');
			$product['Artist'] = $this->input->post('Artist');
			$product['QtyInStock'] = $this->input->post('QtyInStock');
			$product['BuyCost'] = $this->input->post('BuyCost');
			$product['SalePrice'] = $this->input->post('SalePrice');
			$product['priceAlreadyDiscounted'] = $this->input->post('priceAlreadyDiscounted');
			$product['Photo'] = $_FILES['userfile']['name'];

			//check if the form has passed validation
			if (!$this->form_validation->run()) {
				//validation has failed, load the form again – keeping all the data in place
				//and pass the appropriate validation error messages via the 
				//form_validation library
				$this->load->view('insertproductView', $product);
				return;
			}

			//check if insert is successful
			if ($this->ProductServices->addProduct($product)) {
				$data['message'] = "The insert has been successful";
			} else {
				$data['message'] = "Uh oh ... problem on insert";
			}

			//load the view to display the message
			$this->load->view('displayMessageView', $data);
			return;
		}

		//the user has not submitted the form
		//initialize the form fields
		$product['Id'] = "";
		$product['Description'] = "";
		$product['Category'] = "";
		$product['Artist'] = "";
		$product['QtyInStock'] = "";
		$product['BuyCost'] = "";
		$product['SalePrice'] = "";
		$product['priceAlreadyDiscounted'] = "";

		//load the form
		$this->load->view('insertproductView', $product);
	}

}
