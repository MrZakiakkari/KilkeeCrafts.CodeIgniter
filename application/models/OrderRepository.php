<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class OrderRepository extends CI_Model
{
	private $table = "Order";

	function __construct()
	{
		$this->load->database();
	}

	function addOrder($orders)
	{
		$this->db->insert($this->table, $orders);
		return $this->db->affected_rows() == 1;
	}

	
	function getOrdersById($Id)
	{

		$this->db->select("Id, OrderDate, RequiredDate, ShippedDate, Status, Comments, CustomerNumber");
		$this->db->from('order');
		$this->db->where('Id', $Id);

		$query = $this->db->get();
		return $query->result()[0];
	}
	function getOrdersByCustomerNumber($customerNumber)
	{

		$this->db->select("Id, OrderDate, RequiredDate, ShippedDate, Status, Comments, CustomerNumber");
		$this->db->from('order');
		$this->db->where('CustomerNumber', $customerNumber);

		$query = $this->db->get();
		return $query->result();
	}
	function deleteOrdersById($OrderId)
	{
		$this->db->where('Id', $OrderId);
		return $this->db->delete($this->table);
	}
	function getOrderCount()
	{
		return $this->db->count_all('order');
	}
	public function getOrdersMatchingDescription($description)
	{
		$this->db->from($this->table);
		$this->db->like('CustomerNumber', $description, 'both');
		$query = $this->db->get();
		return $query->result();
	}

	function getOrdersByCustomerNumberRange($customerNumber, $limit, $offset)
	{
		$this->db->limit($limit, $offset);
		$this->db->from('order');
		$this->db->where('CustomerNumber', $customerNumber);
		$query = $this->db->get();
		return $query->result();
	}


	function getOrdersRange($limit, $offset)
	{
		$this->db->limit($limit, $offset);
		$this->db->from('order');
		$query = $this->db->get();
		return $query->result();
	}
	function getOrders()
	{
		$this->db->from('orders');
		$query = $this->db->get();
		return $query->result();
	}
	function updateOrder($orders)
	{
		$this->db->where("Id", $orders["Id"]);
		$this->db->update($this->table, $orders);
		return $this->db->affected_rows() == 1;
	}
}