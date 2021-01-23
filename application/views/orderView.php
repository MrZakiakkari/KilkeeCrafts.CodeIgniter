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
echo form_input('Id', $order->Id, 'readonly');

echo '</br></br>OrderDate : ';
echo form_input('OrderDate', $order->OrderDate, 'readonly');

echo '</br></br>RequiredDate : ';
echo form_input('RequiredDate', $order->RequiredDate, 'readonly');

echo '</br></br>ShippedDate : ';
echo form_input('ShippedDate', $order->ShippedDate, 'readonly');

echo '</br></br>Status : ';
echo form_input('Status', $order->Status, 'readonly');
echo '</br></br>Comments : ';
echo form_input('Comments', $order->Comments, 'readonly');
echo '</br></br>CustomerNumber : ';
echo form_input('CustomerNumber', $order->CustomerNumber, 'readonly');

echo '</br></br>';


echo '</br></br>';
echo form_close();
