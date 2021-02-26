<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

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
		if ($this->unauthorizedAdminSessionDetected()) {
			$this->handleUnauthorizedSession();
			return;
		} else {
			$pageSize = 20;
			$paginationConfig = array(
				'base_url' => site_url('admin/Orders/index/'),
				'total_rows' => $this->OrderRepository->getOrderCount(),
				'per_page' => $pageSize
			);
			$this->pagination->initialize($paginationConfig);
			$data['orders'] = $this->OrderRepository->getOrdersRange($pageSize, $this->uri->segment(3));
			$this->load->view('admin/orderListView', $data);
		}
	}

	public function editorder($Id)
	{
		if ($this->unauthorizedAdminSessionDetected()) {
			$this->handleUnauthorizedSession();
			return;
		} else {
			$data = array("order" => $this->OrderRepository->getOrdersById($Id));
			$this->load->view('admin/updateorderView', $data);
		}
	}

	public function vieworder($orderId)
	{
		if ($this->unauthorizedAdminSessionDetected()) {
			$this->handleUnauthorizedSession();
			return;
		}
		$order = $this->OrderRepository->getOrdersById($orderId);
		$vars = array('order' => $order);
		$this->load->view('orderView', $vars);
	}

	public function deleteorder($Id)
	{
		if ($this->unauthorizedAdminSessionDetected()) {
			$this->handleUnauthorizedSession();
			return;
		} else {
			$deletedRows = $this->OrderRepository->deleteOrdersById($Id);
			if ($deletedRows > 0)
				$data['message'] = "$deletedRows order has been deleted";
			else
				$data['message'] = "There was an error deleting the order with an ID of $Id";
			$this->load->view('displayMessageView', $data);
		}
	}

	public function updateorder($Id)
	{
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


		//check if the form has passed validation
		if (!$this->form_validation->run()) {
			//validation has failed, load the form again
			$this->load->view('admin/updateorderView', array("order" => $order));
			return;
		}


		$orderUpdated = $this->OrderRepository->updateOrder($order);
		//check if update is successful
		if ($orderUpdated) {
			redirect('admin/Orders/');
		} else {
			$data['message'] = "Uh oh ... problem on update";
			$data['order'] = $order;
			$this->load->view('admin/updateorderView', $data);
		}
	}
	//
	//	security
	//
	private function handleUnauthorizedSession()
	{
		$this->load->view("403.php");
	}
	private function unauthorizedAdminSessionDetected()
	{
		return $this->session->userdata("AdminId") == null;
	}
}
