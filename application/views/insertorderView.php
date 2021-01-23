<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."/assets/images/products/";
?>

<?php echo form_open_multipart('Orders/handleInsert');

	echo 'Enter Product Code :';
	echo form_input('Id', $Id);

	echo '</br></br>Enter OrderDate :';
	echo form_input('OrderDate', $OrderDate);

	echo '</br></br>Enter RequiredDate :';
	echo form_input('RequiredDate', $RequiredDate);

	echo '</br></br>Enter ShippedDate :';
	echo form_input('ShippedDate', $ShippedDate);
	
	echo '</br></br>Enter Status :';
	echo form_input('Status', $Status);
		echo '</br></br>Enter Comments :';
	echo form_input('Comments', $Comments);
		echo '</br></br>Enter CustomerNumber :';
	echo form_input('CustomerNumber', $CustomerNumber);
	
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
