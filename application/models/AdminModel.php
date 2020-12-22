<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class AdminModel extends CI_Model {

		function __construct() {
        	parent::__construct();
			$this->load->database();
    	}
	
		function insertAdminModel($product) {
			$this->db->insert('product',$product);
			if ($this->db->affected_rows() ==1) 
				return true;
			else 
				return false;
		}
		
		function record_count(){
			return $this->db->count_all('product');
		}
		
		/*function get_all_product() {
			$this->db->select("prodCode,FirstName,LastName,YearBorn,Image"); 
			$this->db->from('product');
			$query = $this->db->get();
			return $query->result();
		}*/
		function get_all_product($limit, $offset) {
			$this->db->limit($limit,$offset);
			$this->db->select("prodCode,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,priceAlreadyDiscounted,prodPhoto"); 
			$this->db->from('product');
			$query = $this->db->get();
			return $query->result();
		}
		
		function deleteAdminModel($id) {
			$this->db->where('prodCode', $id);
			return $this->db->delete('product');
		}
		
		function updateAdminModel($product,$id) {
			$this->db->where('prodCode', $id);
			return $this->db->update('product',$product);
		}
		
		function drilldown($product) {
			$this->db->select("prodCode,prodDescription,prodCategory,prodArtist,prodQtyInStock,prodBuyCost,prodSalePrice,prodPhoto,priceAlreadyDiscounted");
			$this->db->from('product');
			$this->db->where('prodCode',$product);
			$query = $this->db->get();
			return $query->result();
		}
}
?>
