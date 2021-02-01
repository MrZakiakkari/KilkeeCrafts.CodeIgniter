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
echo form_input('Id', $wishlist->CustomerId, 'readonly');

echo '</br></br>ProductId : ';
echo form_input('ProductId', $wishlist->ProductId, 'readonly');



echo '</br></br>';
echo form_close();
