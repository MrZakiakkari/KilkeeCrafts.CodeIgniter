<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class ArtistRepository extends CI_Model
{
	private $table = "Artist";

	function __construct()
	{
		$this->load->database();
	}

	

	function getArtistById($code)
	{

		$this->db->select("Id, BusinessName, Address, Contact, Phone, Photo");
		$this->db->from('artist');
		$this->db->where('Id', $code);

		$query = $this->db->get();
		return $query->result()[0];
	}
	function deleteArtistById($ArtistId)
	{
		$this->db->where('Id', $ArtistId);
		return $this->db->delete($this->table);
	}
	function getArtistCount()
	{
		return $this->db->count_all('artist');
	}
	
	
	function getArtists()
	{
		$this->db->from('artist');
		$query = $this->db->get();
		return $query->result();
	}
	
}