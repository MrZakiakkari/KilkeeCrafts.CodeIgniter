<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('header');
$this->load->helper('url');
$base = base_url() . index_page();
$img_base = base_url() . "/assets/images/products/";
?>

<?php
echo form_open();
echo '</br></br>';

echo 'Product Code : ';
echo form_input('Id', $artist->Id, 'readonly');

echo '</br></br>BusinessName : ';
echo form_input('BusinessName', $artist->BusinessName, 'readonly');

echo '</br></br>Address : ';
echo form_input('Address', $artist->Address, 'readonly');

echo '</br></br>Contact : ';
echo form_input('Contact', $artist->Contact, 'readonly');

echo '</br></br>Phone : ';
echo form_input('Phone', $artist->Phone, 'readonly');

echo '</br></br>';
echo '<img src=' . $img_base . 'full/' . $artist->Photo . '>';

echo '</br></br>';
echo form_close();
