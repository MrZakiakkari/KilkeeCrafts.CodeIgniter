<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/products/";
	$jsbase = base_url()."assets/js/";
?>


<?php
	$this->load->view('footer'); 
?>