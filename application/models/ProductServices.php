<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class ProductServices extends CI_Model
{
	private $table = "Product";

	function __construct()
	{
		$this->load->database();
	}

	function addProduct($product)
	{
		$this->db->insert($this->table, $product);
		return $this->db->affected_rows() == 1;
	}

	function getProductById($code)
	{

		$this->db->select("Id,Description,Category,Artist,QtyInStock,BuyCost,SalePrice,Photo,priceAlreadyDiscounted");
		$this->db->from('product');
		$this->db->where('Id', $code);

		$query = $this->db->get();
		return $query->result()[0];
	}
	function deleteProductById($ProductId)
	{
		$this->db->where('Id', $ProductId);
		return $this->db->delete($this->table);
	}
	function getProductCount()
	{
		return $this->db->count_all('product');
	}
	public function getProductsMatchingDescription($description)
	{
		$this->db->from($this->table);
		$this->db->like('description', $description, 'both');
		$query = $this->db->get();
		return $query->result();
	}
	function getProductRange($limit, $offset)
	{
		$this->db->limit($limit, $offset);
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
	}
	function getProducts()
	{
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
	}
	function updateProduct($product)
	{
		$this->db->where("Id", $product["Id"]);
		$this->db->update($this->table, $product);
		return $this->db->affected_rows() == 1;
	}
}
