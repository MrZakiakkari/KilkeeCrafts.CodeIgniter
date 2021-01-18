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
	function record_count_Order()
	{
		return $this->db->count_all('orders');
	}
	public function drilldown($products)
	{	
		$this->db->select("Id,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,priceAlreadyDiscounted,prodPhoto"); 
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
		
		$this->db->select("Id,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,priceAlreadyDiscounted,prodPhoto");
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
	
	public function SearchAllOrders($search)
	{
		$this->db->select("orderNumber,orderDate,requiredDate,shippedDate,status,comments,customerNumber");
        $this->db->from('orders');
		$this->db->like('customerNumber',$search, 'both');
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
	
	public function addToWishlist($customerNumber, $produceCode)
    {
        $data = array(
            'customerNumber' => $customerNumber,
            'produceCode' => $produceCode
        );

        $this->db->insert('wishlist', $data);
    }
	
	public function removeFromWishlist($customerNumber, $produceCode)
    {
        $this->db->where('customerNumber', $customerNumber);
        $this->db->where('produceCode', $produceCode);
        $this->db->delete('wishlist');    
    }
	
	public function emptyWishlist($customerNumber)
    {
        $this->db->where('customerNumber', $customerNumber);        
        $this->db->delete('wishlist');    
    }
	
	public function get_products_wishlist($customerNumber) 
    {
        $this->db->select('produceCode');
        $this->db->from('wishlist');
        $this->db->where('customerNumber', $customerNumber);
        $query = $this->db->get();

        return $query->result_array();
    }
	
	public function getProductWishlist($customerNumber) 
    {
        $this->db->select('produceCode');
        $this->db->from('wishlist');
        $this->db->where('customerNumber', $customerNumber);
        $query = $this->db->get();

        return $query->result_array();
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
		$this->db->select("Id,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,priceAlreadyDiscounted,prodPhoto");
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
	}



	function getProductByCode($code)
	{

		$this->db->select("Id,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,prodPhoto,priceAlreadyDiscounted");
		$this->db->from('product');
		$this->db->where('Id', $code);

		$query = $this->db->get();
		return $query->result()[0];
	}

 public function get_orders()
    {
        $this->db->select('*');
        $this->db->from('orders');

        $query = $this->db->get();

        return $query->result_array();
    }
	
	public function create_order($data)
    {
        if($this->db->insert('orders', $data))
            return true;

        else
            return false;
    }
	public function create_order_details($data)
    {
        $this->db->insert('orderdetails', $data);
    }
	
	public function get_orders_by_customer($customerNumber)
    {
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where('customerNumber', $customerNumber);

        $query = $this->db->get();

        return $query->result_array();
    }
	
	public function if_order_exists($orderNumber)
    {
        $this->db->select('orderNumber');  
        $this->db->from('orders');        
        $this->db->where('orderNumber', $orderNumber);
        $query = $this->db->get();

        if(count($query->result_array()) > 0) 
            return true;

        else
            return false;
    }

    public function delete_order($orderNumber)
    {
        $this->db->where('orderNumber', $orderNumber);
        $this->db->delete('orders');    
    }

    public function delete_order_details($orderNumber)
    {
        $this->db->where('orderNumber', $orderNumber);
        $this->db->delete('orderdetails'); 
    }

    public function get_order_details($orderNumber)
    {
        $this->db->select('orderNumber,productCode,quantityOrdered,priceEach');
        $this->db->from('orderdetails'); 
        $this->db->where('orderNumber', $orderNumber);

        $query = $this->db->get();

        return $query->result_array();
    }
	
	public function get_all_order_details()
    {
        $this->db->select('orderNumber,productCode,quantityOrdered,priceEach');
        $this->db->from('orderdetails'); 

        $query = $this->db->get();

        return $query->result_array();
    }

     public function update_order_details($orderNumber, $productCode, $quantity_ordered)
    {
          $data = array(
            'quantity_ordered' => $quantity_ordered
        );

        $this->db->where('orderNumber', $orderNumber);
        $this->db->where('productCode', $productCode);
        $this->db->update('orderdetails', $data);
    }

     public function update_order($orderNumber, $data)
    {
        $this->db->where('orderNumber', $orderNumber);
        $this->db->update('orders', $data);
    }
}
?>
