<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."/assets/images/products/";
?>
<br>
<h1 class="main"> Update Author </h1>

<?php
	foreach ($edit_data as $row) {
		
		echo form_open_multipart('ProductController/editproduct/'.$row->prodCode);
		echo '</br></br>';
		
		echo 'Product Code : ';
		echo form_input('prodCode', $row->prodCode, 'readonly');
		
		echo '</br></br>Description : ';
		echo form_input('prodDescription', $row->prodDescription);

		echo '</br></br>Category : ';
		echo form_input('prodCategory', $row->prodCategory);

		echo '</br></br>Artist : ';
		echo form_input('prodArtist', $row->prodArtist);
		
		echo '</br></br>Product in stock : ';
		echo form_input('prodQtyInStock', $row->prodQtyInStock);
		
		echo '</br></br>Cost : ';
		echo form_input('prodBuyCost', $row->prodBuyCost);
		
		echo '</br></br>Sale Price : ';
		echo form_input('prodSalePrice', $row->prodSalePrice);
		
		echo '</br></br>Discount : ';
		echo form_input('priceAlreadyDiscounted', $row->priceAlreadyDiscounted);

		echo '</br></br>Select File for Upload :';
		echo form_upload('userfile');

		echo '</br></br>';
		echo form_submit('submitUpdate', "Submit!");
		echo form_close();
		echo validation_errors();
	}
?>
<?php
	$this->load->view('footer'); 
?>
