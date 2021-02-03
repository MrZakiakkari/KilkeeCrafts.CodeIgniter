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
		$this->db->from($this->table);
		$this->db->where('CustomerId', $CustomerId);

		$query = $this->db->get();
		return $query->result();
	}
	function deleteWishItemByKey($CustomerId, $ProductId)
	{
		$this->db->where('CustomerId', $CustomerId); //todo check
		$this->db->where('ProductId', $ProductId);
		return $this->db->delete($this->table);
	}
	function getWishItemCount()
	{
		return $this->db->count_all('wishitem');
	}
	function getWishItemByKey($CustomerId, $ProductId)
	{
		$this->db->from($this->table);
		$this->db->where('CustomerId', $CustomerId);
		$this->db->where('ProductId', $ProductId);

		$query = $this->db->get();
		return $query->num_rows() == 0 ? null : $query->result()[0];
	}

	function getWishItems()
	{
		$this->db->from('wishitem');
		$query = $this->db->get();
		return $query->result();
	}
}
