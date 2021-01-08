<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ProductRepository extends CI_Model {

	protected $table = "Product";

	function __construct() {
		//parent::__construct();
		$this->load->database();
	}

	function addProduct($product) {
		$this->db->insert($this->table, $product);
		return $this->db->affected_rows() == 1;
	}

	function deleteProductById($productId) {
		$this->db->where('Id', $productId);
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
	  $this->db->select("prodCode,FirstName,LastName,YearBorn,Image");
	  $this->db->from('product');
	  $query = $this->db->get();
	  return $query->result();
	  } */

	function get_all_product($limit, $offset) {
		$this->db->limit($limit, $offset);
		$this->db->select("prodCode,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,priceAlreadyDiscounted,prodPhoto");
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
	}



	/* WRongly named */

	function drilldown($prodCode) {
		$this->db->select("prodCode,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,prodPhoto,priceAlreadyDiscounted");
		$this->db->from('product');
		$this->db->where('prodCode', $prodCode);
		$query = $this->db->get();
		return $query->result();
	}

	function getProductByCode($code) {

		$this->db->select("prodCode,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,prodPhoto,priceAlreadyDiscounted");
		$this->db->from('product');
		$this->db->where('prodCode', $code);

		$query = $this->db->get();
		return $query->result()[0];
	}

}
