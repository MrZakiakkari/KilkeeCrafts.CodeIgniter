<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('header');
$this->load->helper('url');
$base = base_url() . index_page();
$img_base = base_url() . "/assets/images/products/";
?>
<br>
<h1 class="main">Update Wishlist</h1>
<?php
echo form_open_multipart('WishItems/updatewishitem/' . $artist->CustomerId);
echo '</br></br>';

echo 'Customer Id : ';
echo form_input('CustomerId', $artist->CustomerId, 'readonly');

echo '</br></br>ProductId : ';
echo form_input('ProductId', $artist->ProductId);







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