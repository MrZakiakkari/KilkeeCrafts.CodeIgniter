<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/";
?>
<br>
<h1 class="main"> Update Author </h1>

<?php
	foreach ($edit_data as $row) {
		echo form_open_multipart('AuthorController/updateAuthor/'.$row->AuthorID);
		echo '</br></br>';
		
		echo 'Author ID : ';
		echo form_input('authorID', $row->AuthorID, 'readonly');
		
		echo '</br></br>First Name : ';
		echo form_input('firstName', $row->FirstName);

		echo '</br></br>Last Name : ';
		echo form_input('lastName', $row->LastName);

		echo '</br></br>Year Born : ';
		echo form_input('yearBorn', $row->YearBorn);

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
