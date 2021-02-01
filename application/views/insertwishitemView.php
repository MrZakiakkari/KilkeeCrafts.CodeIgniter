<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."/assets/images/products/";
?>

<?php echo form_open_multipart('WishItems/handleInsert');

	echo 'Enter CustomerId :';
	echo form_input('CustomerId', $CustomerId);

	echo '</br></br>Enter ProductId :';
	echo form_input('ProductId', $ProductId);


	
	echo '</br></br>';
	
	echo form_submit('submitInsert', "Submit!");

	echo form_close();
	echo validation_errors();
?>

<?php
	$this->load->view('footer'); 
?>
