<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('header');
$this->load->helper('url');
$base = base_url() . index_page();
$img_base = base_url() . "/assets/images/products/";
?>
<br>
<h1 class="main">Update Order</h1>
<?php
echo form_open_multipart('admin/orders/updateorder/' . $order->Id);
echo '</br></br>';

echo 'Product Code : ';
echo form_input('Id', $order->Id, 'readonly');

echo '</br></br>OrderDate : ';
echo form_input('OrderDate', $order->OrderDate);

echo '</br></br>RequiredDate : ';
echo form_input('RequiredDate', $order->RequiredDate);

echo '</br></br>ShippedDate : ';
echo form_input('ShippedDate', $order->ShippedDate);

echo '</br></br>Status : ';
echo form_input('Status', $order->Status);
echo '</br></br>Comments : ';
echo form_input('Comments', $order->Comments);
echo '</br></br>CustomerNumber : ';
echo form_input('CustomerNumber', $order->CustomerNumber);





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
