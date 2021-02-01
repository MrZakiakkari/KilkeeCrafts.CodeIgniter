<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class WishlistRepository extends CI_Model
{
	private $table = "Artist";

	function __construct()
	{
		$this->load->database();
	}

	

	function getWishlistByCustomerId($CustomerId)
	{

		$this->db->select("CustomerId, ProductId");
		$this->db->from('wishlist');
		$this->db->where('CustomerId', $CustomerId);

		$query = $this->db->get();
		return $query->result()[0];
	}
	function deleteWishlistByCustomerId($CustomerId)
	{
		$this->db->where('CustomerId', $CustomerId);
		return $this->db->delete($this->table);
	}
	function getWishlistCount()
	{
		return $this->db->count_all('wishlist');
	}
	
	
	function getWishlists()
	{
		$this->db->from('wishlist');
		$query = $this->db->get();
		return $query->result();
	}
	
}