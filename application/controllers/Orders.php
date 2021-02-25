<?php
if (!defined('BASEPATH')) 	exit('No direct script access allowed');

class Orders extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('OrderRepository');
	}
	public function index()
	{
		if ($this->unauthorizedCustomerSessionDetected()) {
			$this->handleUnauthorizedSession();
			return;
		} else if ($this->sessionIsCustomer()) {
			$customerOrdersCount = sizeof($this->OrderRepository->getOrdersByCustomerNumber($this->getSessionCustomerId()));
			$pageSize = 10;

			$data['orders'] = $this->OrderRepository->getOrdersByCustomerNumberRange($this->getSessionCustomerId(), $pageSize, $this->uri->segment(3));

			$paginationConfig = array(
				'base_url' => site_url('Orders/index/'),
				'total_rows' => $customerOrdersCount,
				'per_page' => $pageSize
			);
			$this->pagination->initialize($paginationConfig);
			$this->load->view('orderListView', $data);
		}
	}
	public function vieworder($orderId)
	{
		$order = $this->OrderRepository->getOrdersById($orderId);
		if ($this->sessionIsCustomer() && $order->CustomerNumber != $this->getSessionCustomerId()) {
			$this->handleUnauthorizedSession();
			return;
		}
		$vars = array('order' => $order);
		$this->load->view('orderView', $vars);
	}
	//
	//	security methods
	//
	private function handleUnauthorizedSession()
	{
		$this->load->view("403.php");
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
