<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Orders extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('OrderRepository');
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

	public function listorders()
	{ //config options for pagination

		if ($this->unauthorizedSessionDetected()) {
			$this->handleUnauthorizedSession();
			return;
		} else if ($this->sessionIsCustomer()) {
			$vars['order'] = $this->OrderRepository->getOrdersByCustomerNumber($this->getSessionCustomerId());
			$this->load->view('orderListView', $vars);
		} else {
			$paginationConfig = array(
				'base_url' => site_url('Orders/listorders/'),
				'total_rows' => $this->OrderRepository->getOrderCount(),
				'per_page' => 2
			);
			$this->pagination->initialize($paginationConfig);
			$data['order'] = $this->OrderRepository->getOrdersRange(2, $this->uri->segment(3));
			$this->load->view('orderListView', $data);
		}
	}

	public function editorder($Id)
	{
		$data = array("order" => $this->OrderRepository->getOrdersById($Id));
		$this->load->view('updateorderView', $data);
	}

	public function vieworder($orderId)
	{
		$order = $this->OrderRepository->getOrdersById($orderId);
		if ($this->unauthorizedSessionDetected()) {
			$this->handleUnauthorizedSession();
			return;
		} else if ($this->sessionIsCustomer() && $order->CustomerNumber != $this->getSessionCustomerId()) {
			$this->handleUnauthorizedSession();
			return;
		}
		$vars = array('order' => $this->OrderRepository->getOrdersById($orderId));
		$this->load->view('orderView', $vars);
	}

	public function deleteorder($Id)
	{
		$deletedRows = $this->OrderRepository->deleteOrdersById($Id);
		if ($deletedRows > 0)
			$data['message'] = "$deletedRows order has been deleted";
		else
			$data['message'] = "There was an error deleting the order with an ID of $Id";
		$this->load->view('displayMessageView', $data);
	}

	public function updateorder($Id)
	{
		$pathToFile = $this->uploadAndResizeFile();
		$this->createThumbnail($pathToFile);

		//set validation rules
		$this->form_validation->set_rules('Id', 'Id', 'required');
		$this->form_validation->set_rules('OrderDate', 'OrderDate', 'required');
		$this->form_validation->set_rules('RequiredDate', 'RequiredDate', 'required');
		$this->form_validation->set_rules('ShippedDate', 'ShippedDate', 'required');
		$this->form_validation->set_rules('Status', 'Status', 'required');
		$this->form_validation->set_rules('Comments', 'Comments', 'required');
		$this->form_validation->set_rules('CustomerNumber', 'CustomerNumber', 'required');



		$order = array(
			"Id" => $this->input->post('Id'),
			"OrderDate" => $this->input->post('OrderDate'),
			"RequiredDate" => $this->input->post('RequiredDate'),
			"ShippedDate" => $this->input->post('ShippedDate'),
			"Status" => $this->input->post('Status'),
			"Comments" => $this->input->post('Comments'),
			"CustomerNumber" => $this->input->post('CustomerNumber')
		);

		var_dump($order);


		//check if the form has passed validation
		if (!$this->form_validation->run()) {
			//validation has failed, load the form again
			$this->load->view('updateorderView', array("order" => $order));
			return;
		}


		$orderUpdated = $this->OrderRepository->updateOrders($order);
		//check if update is successful
		if ($orderUpdated) {
			redirect('Orders/listorders');
		} else {
			$data['message'] = "Uh oh ... problem on update";
			$data['order'] = $order;
			$this->load->view('updateorderView', $data);
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
			$this->form_validation->set_rules('Id', 'Orders Code', 'required');
			$this->form_validation->set_rules('OrderDate', 'OrderDate', 'required');
			$this->form_validation->set_rules('RequiredDate', 'RequiredDate', 'required');
			$this->form_validation->set_rules('ShippedDate', 'ShippedDate', 'required');
			$this->form_validation->set_rules('Status', 'Status', 'required');
			$this->form_validation->set_rules('Comments', 'Comments', 'required');
			$this->form_validation->set_rules('CustomerNumber', 'CustomerNumber', 'required');


			//get values from post
			$order['Id'] = $this->input->post('Id');
			$order['OrderDate'] = $this->input->post('OrderDate');
			$order['RequiredDate'] = $this->input->post('RequiredDate');
			$order['ShippedDate'] = $this->input->post('ShippedDate');
			$order['Status'] = $this->input->post('Status');
			$order['Status'] = $this->input->post('Comments');
			$order['Status'] = $this->input->post('CustomerNumber');


			//check if the form has passed validation
			if (!$this->form_validation->run()) {
				//validation has failed, load the form again – keeping all the data in place
				//and pass the appropriate validation error messages via the 
				//form_validation library
				$this->load->view('insertorderView', $order);
				return;
			}

			//check if insert is successful
			if ($this->OrderRepository->addOrders($order)) {
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
		$order['Id'] = "";
		$order['OrderDate'] = "";
		$order['RequiredDate'] = "";
		$order['ShippedDate'] = "";
		$order['Status'] = "";
		$order['Comments'] = "";
		$order['CustomerNumber'] = "";



		//load the form
		$this->load->view('insertorderView', $order);
	}
	private function handleUnauthorizedSession()
	{
		$this->load->view("403.php");
	}
	private function unauthorizedSessionDetected()
	{
		return $this->unauthorizedAdminSessionDetected() && $this->unauthorizedCustomerSessionDetected();
	}

	private function unauthorizedAdminSessionDetected()
	{
		return $this->session->userdata("AdminId") == null;
	}
	private function unauthorizedCustomerSessionDetected()
	{
		return $this->session->userdata("CustomerId") == null;
	}
	private function getSessionCustomerId()
	{
		return $this->session->userdata("CustomerId");
	}
	private function sessionIsCustomer()
	{
		return $this->session->userdata("CustomerId") !== null;
	}
}
