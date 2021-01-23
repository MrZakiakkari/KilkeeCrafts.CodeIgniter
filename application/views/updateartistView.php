<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('header');
$this->load->helper('url');
$base = base_url() . index_page();
$img_base = base_url() . "/assets/images/products/";
?>
<br>
<h1 class="main">Update Artist</h1>
<?php
echo form_open_multipart('Artists/updateartist/' . $artist->Id);
echo '</br></br>';

echo 'Product Code : ';
echo form_input('Id', $artist->Id, 'readonly');

echo '</br></br>BusinessName : ';
echo form_input('BusinessName', $artist->BusinessName);

echo '</br></br>Address : ';
echo form_input('Address', $artist->Address);

echo '</br></br>Contact : ';
echo form_input('Contact', $artist->Contact);

echo '</br></br>Phone : ';
echo form_input('Phone', $artist->Phone);





echo '</br></br>Select File for Upload :';
echo form_upload('userfile');

echo '</br></br>';
echo form_submit('submitUpdate', "Submit!");
echo form_close();
echo validation_errors();
?>
<?php
$this->load->view('footer');
?>