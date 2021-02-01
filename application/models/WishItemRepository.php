<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class WishItemRepository extends CI_Model
{
	private $table = "wishitem";

	function __construct()
	{
		$this->load->database();
	}

	function addWishItem($wishItemValuesArray)
	{
		$this->db->insert($this->table, $wishItemValuesArray);
		return $this->db->affected_rows() == 1;
	}

	function getWishItemsByCustomerId($CustomerId)
	{

		$this->db->select("CustomerId, ProductId");
		$this->db->from('wishitem');
		$this->db->where('CustomerId', $CustomerId);

		$query = $this->db->get();
		return $query->result();
	}
	function deleteWishItemByKey($CustomerId, $ProductId)
	{
		$this->db->where('CustomerId', $CustomerId);//todo fix to add productid
		return $this->db->delete($this->table);
	}
	function getWishItemCount()
	{
		return $this->db->count_all('wishitem');
	}
	
	
	function getWishItems()
	{
		$this->db->from('wishitem');
		$query = $this->db->get();
		return $query->result();
	}
	
}