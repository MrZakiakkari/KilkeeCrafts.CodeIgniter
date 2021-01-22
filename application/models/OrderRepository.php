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

	function getOrderById($code)
	{

		$this->db->select("OrderNumber, OrderDate, RequiredDate, ShippedDate, Status, Comments, CustomerNumber");
		$this->db->from('orders');
		$this->db->where('OrderNumber', $code);

		$query = $this->db->get();
		return $query->result()[0];
	}
	function deleteOrderById($OrderId)
	{
		$this->db->where('OrderNumber', $OrderId);
		return $this->db->delete($this->table);
	}
	function getOrderCount()
	{
		return $this->db->count_all('orders');
	}
	public function getOrdersMatchingDescription($description)
	{
		$this->db->from($this->table);
		$this->db->like('OrderNumber', $description, 'both');
		$query = $this->db->get();
		return $query->result();
	}
	function getOrderRange($limit, $offset)
	{
		$this->db->limit($limit, $offset);
		$this->db->from('orders');
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
		$this->db->where("OrderNumber", $orders["OrderNumber"]);
		$this->db->update($this->table, $orders);
		return $this->db->affected_rows() == 1;
	}
}