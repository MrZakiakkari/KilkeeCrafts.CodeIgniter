<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ShoppingCart extends CI_Controller
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

		$this->load->library('cart');
		$this->load->view('ShoppingCartView');
	}
	public function CheckOut()
	{ {
			$this->load->library('cart');

			$orderValuesArray = array(
				"CustomerNumber" => $this->session->userdata("CustomerId"),
				"date" => now()
			);

			$order = $this->OrderRepository->addOrder($orderValuesArray);
			foreach ($this->cart->contents() as $cartItem) {
				$orderItemValuesArray = array(
					"OrderNumber" => $order->OrderId,
					"ProductID" => $cartItem->ProductId,
					"Date" => now()
				);
				$this->OrderRepository->addOrderItem($orderItemValuesArray);
			}

			$this->cart->clear(); //Something like this
		}
	}
	public function handleAddToCart($productId)
	{
		$this->load->library('cart');
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
