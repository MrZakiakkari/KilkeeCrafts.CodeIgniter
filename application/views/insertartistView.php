<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."/assets/images/products/";
?>

<?php echo form_open_multipart('Arists/handleInsert');

	echo 'Enter Product Code :';
	echo form_input('Id', $Id);

	echo '</br></br>Enter BusinessName :';
	echo form_input('BusinessName', $BusinessName);

	echo '</br></br>Enter Address :';
	echo form_input('Address', $Address);

	echo '</br></br>Enter Contact :';
	echo form_input('Contact', $Contact);
	
	echo '</br></br>Enter Phone :';
	echo form_input('Phone', $Phone);
	
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
