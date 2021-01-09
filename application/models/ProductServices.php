<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ProductServices extends CI_Model {

	protected $table = "Product";

	function __construct() {
		//parent::__construct();
		$this->load->database();
	}

	function addProduct($product) {
		$this->db->insert($this->table, $product);
		return $this->db->affected_rows() == 1;
	}

	function deleteProductById($ProductId) {
		$this->db->where('Id', $ProductId);
		return $this->db->delete($this->table);
	}

	function updateProduct($product) {
		$this->db->where('Id',$product->Id);
		return $this->db->update($this->table, product);
	}

	function record_count() {
		return $this->db->count_all('product');
	}

	/* function get_all_product() {
	  $this->db->select("Id,FirstName,LastName,YearBorn,Image");
	  $this->db->from('product');
	  $query = $this->db->get();
	  return $query->result();
	  } */

	function get_all_product($limit, $offset) {
		$this->db->limit($limit, $offset);
		$this->db->select("Id,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,priceAlreadyDiscounted,prodPhoto");
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
	}



	/* WRongly named */

	function drilldown($Id) {
		$this->db->select("Id,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,prodPhoto,priceAlreadyDiscounted");
		$this->db->from('product');
		$this->db->where('Id', $Id);
		$query = $this->db->get();
		return $query->result();
	}

	function getProductByCode($code) {

		$this->db->select("Id,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,prodPhoto,priceAlreadyDiscounted");
		$this->db->from('product');
		$this->db->where('Id', $code);

		$query = $this->db->get();
		return $query->result()[0];
	}

}
