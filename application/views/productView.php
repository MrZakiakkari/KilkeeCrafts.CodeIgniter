<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."/assets/images/products/";
?>

<?php
	foreach ($view_data as $row) {
		echo form_open();
		echo '</br></br>';
		
		echo 'Product Code : ';
		echo form_input('prodCode', $row->prodCode, 'readonly');
		
		echo '</br></br>Description : ';
		echo form_input('prodDescription', $row->prodDescription, 'readonly');

		echo '</br></br>Category : ';
		echo form_input('prodCategory', $row->prodCategory, 'readonly');
		
		echo '</br></br>Artist : ';
		echo form_input('prodArtist', $row->prodArtist, 'readonly');

		echo '</br></br>Product in stock : ';
		echo form_input('prodQtyInStock', $row->prodQtyInStock, 'readonly');
		
		echo '</br></br>Cost : ';
		echo form_input('prodBuyCost', $row->prodBuyCost, 'readonly');
		
		echo '</br></br>Sale Price : ';
		echo form_input('prodSalePrice', $row->prodSalePrice, 'readonly');
		
		echo '</br></br>Discount : ';
		echo form_input('priceAlreadyDiscounted', $row->priceAlreadyDiscounted, 'readonly');
		
		
		

		echo '</br></br>';
		echo '<img src='.$img_base.'full/'.$row->Image.'>';
		
		echo '</br></br>';
		echo form_close();
	}