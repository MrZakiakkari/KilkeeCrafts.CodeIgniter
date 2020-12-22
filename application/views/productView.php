<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/";
?>

<?php
	foreach ($view_data as $row) {
		echo form_open();
		echo '</br></br>';
		
		echo 'Author ID : ';
		echo form_input('authorID', $row->AuthorID, 'readonly');
		
		echo '</br></br>First Name : ';
		echo form_input('firstName', $row->FirstName, 'readonly');

		echo '</br></br>Last Name : ';
		echo form_input('lastName', $row->LastName, 'readonly');

		echo '</br></br>Year Born : ';
		echo form_input('yearBorn', $row->YearBorn, 'readonly');

		echo '</br></br>';
		echo '<img src='.$img_base.'full/'.$row->Image.'>';
		
		echo '</br></br>';
		echo form_close();
	}