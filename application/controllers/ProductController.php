<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ProductController extends CI_Controller
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

	//hello
	/* public function listproducts() 
	  {	$data['product_info']=$this->ProductServices->get_all_products();
	  $this->load->view('productListView',$data);
	  } */
	public function listproducts()
	{ //config options for pagination
		$paginationConfig = array(
			'base_url' => site_url('ProductController/listproducts/'),
			'total_rows' => $this->ProductServices->record_count(),
			'per_page' => 2
		);
		$this->pagination->initialize($paginationConfig);
		$data['product_info'] = $this->ProductServices->get_all_product(2, $this->uri->segment(3));
		$this->load->view('productListView', $data);
	}

	public function editproduct($productId)
	{
		$data = array("product" => $this->ProductServices->getProductByCode($productId));
		$this->load->view('updateproductView', $data);
	}

	public function viewproduct($productId)
	{
		$data = array('product' => $this->ProductServices->getProductByCode($productId));
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
		$this->form_validation->set_rules('prodDescription', 'Description', 'required');
		$this->form_validation->set_rules('prodCategory', 'Category', 'required');
		$this->form_validation->set_rules('prodArtist', 'Artist', 'required');
		$this->form_validation->set_rules('prodQtyInStock', 'Product in stock', 'required');
		$this->form_validation->set_rules('prodBuyCost', 'Cost', 'required');
		$this->form_validation->set_rules('prodSalePrice', 'Sale Price', 'required');
		$this->form_validation->set_rules('priceAlreadyDiscounted', 'Discount', 'required');

		$product = array(
			"Id" => $this->input->post('Id'),
			"prodDescription" => $this->input->post('prodDescription'),
			"prodCategory" => $this->input->post('prodCategory'),
			"prodArtist" => $this->input->post('prodArtist'),
			"prodQtyInStock" => $this->input->post('prodQtyInStock'),
			"prodBuyCost" => $this->input->post('prodBuyCost'),
			"prodSalePrice" => $this->input->post('prodSalePrice'),
			"priceAlreadyDiscounted" => $this->input->post('priceAlreadyDiscounted'),
			"prodPhoto" => $_FILES['userfile']['name']
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
			redirect('ProductController/listproducts');
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

	public function handleInsert()
	{
		//if the user has submitted the form
		if ($this->input->post('submitInsert')) {

			$pathToFile = $this->uploadAndResizeFile();
			$this->createThumbnail($pathToFile);

			//set validation rules
			$this->form_validation->set_rules('Id', 'Product Code', 'required');
			$this->form_validation->set_rules('prodDescription', 'Description', 'required');
			$this->form_validation->set_rules('prodCategory', 'Category', 'required');
			$this->form_validation->set_rules('prodArtist', 'Artist', 'required');
			$this->form_validation->set_rules('prodQtyInStock', 'Product in stock', 'required');
			$this->form_validation->set_rules('prodBuyCost', 'Cost', 'required');
			$this->form_validation->set_rules('prodSalePrice', 'Sale Price', 'required');
			$this->form_validation->set_rules('priceAlreadyDiscounted', 'Discount', 'required');

			//get values from post
			$product['Id'] = $this->input->post('Id');
			$product['prodDescription'] = $this->input->post('prodDescription');
			$product['prodCategory'] = $this->input->post('prodCategory');
			$product['prodArtist'] = $this->input->post('prodArtist');
			$product['prodQtyInStock'] = $this->input->post('prodQtyInStock');
			$product['prodBuyCost'] = $this->input->post('prodBuyCost');
			$product['prodSalePrice'] = $this->input->post('prodSalePrice');
			$product['priceAlreadyDiscounted'] = $this->input->post('priceAlreadyDiscounted');
			$product['prodPhoto'] = $_FILES['userfile']['name'];

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
		$product['prodDescription'] = "";
		$product['prodCategory'] = "";
		$product['prodArtist'] = "";
		$product['prodQtyInStock'] = "";
		$product['prodBuyCost'] = "";
		$product['prodSalePrice'] = "";
		$product['priceAlreadyDiscounted'] = "";

		//load the form
		$this->load->view('insertproductView', $product);
	}
}
