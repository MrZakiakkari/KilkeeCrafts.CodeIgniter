<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class WishItems extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('WishItemRepository');
		$this->load->model('ProductServices');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}

	public function handleUnauthorizedAccess()
	{
		redirect("user/login");
	}
	public function unauthorizedSessionDetected()
	{
		return $this->session->userdata('CustomerId') == null;
	}
	public function add($productId)
	{
		if ($this->unauthorizedSessionDetected()) {
			return $this->handleUnauthorizedAccess();
		}


		$customerId = $this->session->userdata("CustomerId");

		$wishitem = $this->WishItemRepository->getWishItemByKey($customerId, $productId);

		if ($wishitem != null) {
			//TODO Alert Already exists
			redirect('WishItems/');
		}

		$wishItemValuesArray = array(
			"CustomerId" => $customerId,
			"ProductId" => $productId,
		);


		$wishitemIsAdded = $this->WishItemRepository->addWishItem($wishItemValuesArray);

		if ($wishitemIsAdded) {
			redirect('WishItems/');
		} else {
			//TODO : Check and refactor
			$data['message'] = "Uh oh ... problem on update";
			$this->load->view('updatewishitemView', $data);
		}
	}
	public function index()
	{
		$paginationConfig = array(
			'base_url' => site_url('WishItems/index/'),
			'total_rows' => $this->WishItemRepository->getWishItemCount(),
			'per_page' => 2
		);
		$customerId = $this->session->userdata("CustomerId");
		$this->pagination->initialize($paginationConfig);
		//(2, $this->uri->segment(3));

		$vars = array(
			'wishItems' => $this->WishItemRepository->getWishItemsByCustomerId($customerId)
		);
		$this->load->view('wishitemListView', $vars);
	}

	public function editwishitem($CustomerId)
	{
		$data = array("wishitem" => $this->WishItemRepository->getWishlistByCustomerId($CustomerId));
		$this->load->view('updatewishitemView', $data);
	}

	public function viewwishitem($CustomerId)
	{
		$data = array('wishitem' => $this->WishItemRepository->getWishlistByCustomerId($CustomerId));
		$this->load->view('wishitemView', $data);
	}

	public function deletewishitem($CustomerId, $ProductId)
	{
		$deletedRows = $this->WishItemRepository->deleteWishItemByKey($CustomerId, $ProductId);
		if ($deletedRows > 0)
			$data['message'] = "$deletedRows wishitem has been deleted";
		else
			$data['message'] = "There was an error deleting the wishitem with an ID of $CustomerId";
		$this->load->view('displayMessageView', $data);
	}
	public function addProductToCart($productId)
    {
        $this->load->library('cart');
        $cartItem = $this->getCartItemFromProductId($productId);
        $this->cart->insert($cartItem);
		$this->load->view("ShoppingCartView", "Cart", "Cart");
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
