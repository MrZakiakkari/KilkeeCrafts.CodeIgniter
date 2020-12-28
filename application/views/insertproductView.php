<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."/assets/images/products/";
?>

<?php echo form_open_multipart('ProductController/handleInsert');

	echo 'Enter Product Code :';
	echo form_input('prodCode', $prodCode);

	echo '</br></br>Enter Description :';
	echo form_input('prodDescription', $prodDescription);

	echo '</br></br>Enter Category :';
	echo form_input('prodCategory', $prodCategory);

	echo '</br></br>Enter Artist :';
	echo form_input('prodArtist', $prodArtist);
	
	echo '</br></br>Enter Product in stock :';
	echo form_input('prodQtyInStock', $prodQtyInStock);
	
	echo '</br></br>Enter Cost :';
	echo form_input('prodBuyCost', $prodBuyCost);
	
	echo '</br></br>Enter Sale Price :';
	echo form_input('prodSalePrice', $prodSalePrice);
	
	echo '</br></br>Enter Discount :';
	echo form_input('priceAlreadyDiscounted', $priceAlreadyDiscounted);
	
	echo '</br></br>Select File for Upload :'; 
	echo form_upload('userfile');
	
	echo '</br></br>';
	
	echo form_submit('submitInsert', "Submit!");

	echo form_close();
	echo validation_errors();
?>

<?php
	$this->load->view('footer'); 
?>
