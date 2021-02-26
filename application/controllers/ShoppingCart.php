<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ShoppingCart extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('cart');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('OrderRepository');
		$this->load->model('ProductServices');
	}
	public function index()
	{
		$this->load->view('ShoppingCartView');
	}
	public function CheckOut()
	{
		$orderValuesArray = array(
			"CustomerNumber" => $this->session->userdata("CustomerId"),
			"OrderDate" =>  date('Y-m-d'),
		);

		$orderId = $this->OrderRepository->addOrder($orderValuesArray);
		foreach ($this->cart->contents() as $cartItem)
		{
			$orderItemValuesArray = array(
				"OrderNumber" => $orderId,
				"ProductCode" => $cartItem["id"],
				"QuantityOrdered" => $cartItem["qty"],
				"Price" => $cartItem["price"],
			);
			$this->OrderRepository->addOrderItem($orderItemValuesArray);
		}

		$this->cart->destroy();

		redirect("Orders/viewOrder/". $orderId);
	}
	public function handleAddToCart($productId)
	{
		$cartItem = $this->getCartItemFromProductId($productId);
		$this->cart->insert($cartItem);
		$this->load->view('ShoppingCartView');
	}
	private function getCartItemFromProductId($productId)
	{
		$product  = $this->ProductServices->getProductById($productId);
		return $this->createCartItem($product->Id, 1, $product->SalePrice, $product->Description);
	}
	private function createCartItem($id, $quantity, $price, $name, $options = NULL)
	{
		return array(
			'id'      => $id,
			'qty'     => $quantity,
			'price'   => $price,
			'name'    => $name,
			'options' => $options
		);
	}
}
