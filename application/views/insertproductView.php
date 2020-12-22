<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/";
?>

<?php echo form_open_multipart('AuthorController/handleInsert');

	echo 'Enter Author ID :';
	echo form_input('authorID', $authorID);

	echo '</br></br>Enter First Name :';
	echo form_input('firstName', $firstName);

	echo '</br></br>Enter Last Name :';
	echo form_input('lastName', $lastName);

	echo '</br></br>Enter Year Born :';
	echo form_input('yearBorn', $yearBorn);
	
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
