<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."/assets/images/products/";
?>

<?php echo form_open_multipart('admin/Products/handleInsert');

	echo 'Enter Product Code :';
	echo form_input('Id', $Id);

	echo '</br></br>Enter Description :';
	echo form_input('Description', $Description);

	echo '</br></br>Enter Category :';
	echo form_input('Category', $Category);

	echo '</br></br>Enter Artist :';
	echo form_input('Artist', $Artist);
	
	echo '</br></br>Enter Product in stock :';
	echo form_input('QtyInStock', $QtyInStock);
	
	echo '</br></br>Enter Cost :';
	echo form_input('BuyCost', $BuyCost);
	
	echo '</br></br>Enter Sale Price :';
	echo form_input('SalePrice', $SalePrice);
	
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
