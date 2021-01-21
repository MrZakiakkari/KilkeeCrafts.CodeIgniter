<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ProductServices extends CI_Model
{

	protected $table = "Product";

	function __construct()
	{
		//parent::__construct();
		$this->load->database();
	}

	function addProduct($product)
	{
		$this->db->insert($this->table, $product);
		return $this->db->affected_rows() == 1;
	}
function get_all_customers($limit,$offset) 
	{	
		$this->db->limit($limit,$offset);
		//My Stored Procedure
		$query = $this->db->query("CALL GetAllUsers()");
		return $query->result();
	}
	
	function record_count_c()
	{
		return $this->db->count_all('customers');
	}
	
	public function drilldown($products)
	{	
		$this->db->select("Id,Description,Category,Artist,QtyInStock,BuyCost,SalePrice,priceAlreadyDiscounted,Photo"); 
		$this->db->from('products');
		$this->db->where('produceCode',$products);
		$query = $this->db->get();
		return $query->result();
    }
	function deleteProductById($ProductId)
	{
		$this->db->where('Id', $ProductId);
		return $this->db->delete($this->table);
	}
public function SearchAllProducts($search)
	{
		
		$this->db->select("Id,Description,Category,Artist,QtyInStock,BuyCost,SalePrice,priceAlreadyDiscounted,Photo");
		$this->db->from('products');
		//$this->db->where('description') 
		$this->db->like('description',$search, 'both');
		//$this->db->or('productLine',$search, 'both');
		//$this->db->or('supplier',$search, 'both');
		//$this->db->where('description',$search);
		//$this->db->where('productLine',$search);
		//$this->db->where('supplier',$search);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function Search($search)
	{
		//$this->db->query("SELECT * FROM products WHERE description LIKE '%$search%' where productLine LIKE '%$search%' where `upplier LIKE '%$search%'");
		//$this->db->query("SELECT * FROM products WHERE description LIKE '%$search%' ");
		//$this->db->query(" SELECT produceCode,description,productLine,supplier,quantityInStock,bulkBuyPrice,bulkSalePrice,Photo FROM products WHERE description LIKE '%$search%' ");
		$query = $this->db->get();
		return $query->result();
	}
	
	
	function updateProduct($product)
	{
		$this->db->where("Id", $product["Id"]);
		$this->db->update($this->table, $product);
		return $this->db->affected_rows() == 1;
	}

	function record_count()
	{
		return $this->db->count_all('product');
	}

	/* function get_all_product() {
	  $this->db->select("Id,FirstName,LastName,YearBorn,Image");
	  $this->db->from('product');
	  $query = $this->db->get();
	  return $query->result();
	  } */

	function get_all_product($limit, $offset)
	{
		$this->db->limit($limit, $offset);
		$this->db->select("Id,Description,Category,Artist,QtyInStock,BuyCost,SalePrice,priceAlreadyDiscounted,Photo");
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
	}



	function getProductByCode($code)
	{

		$this->db->select("Id,Description,Category,Artist,QtyInStock,BuyCost,SalePrice,Photo,priceAlreadyDiscounted");
		$this->db->from('product');
		$this->db->where('Id', $code);

		$query = $this->db->get();
		return $query->result()[0];
	}



    
}
?>
