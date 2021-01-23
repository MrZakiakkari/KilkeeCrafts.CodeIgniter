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
echo form_input('Id', $product->Id, 'readonly');

echo '</br></br>BusinessName : ';
echo form_input('BusinessName', $product->BusinessName, 'readonly');

echo '</br></br>Address : ';
echo form_input('Address', $product->Address, 'readonly');

echo '</br></br>Contact : ';
echo form_input('Contact', $product->Contact, 'readonly');

echo '</br></br>Phone : ';
echo form_input('Phone', $product->Phone, 'readonly');

echo '</br></br>';
echo '<img src=' . $img_base . 'full/' . $product->Photo . '>';

echo '</br></br>';
echo form_close();
