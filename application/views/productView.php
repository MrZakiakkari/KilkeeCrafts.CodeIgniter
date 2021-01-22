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

echo '</br></br>Description : ';
echo form_input('Description', $product->Description, 'readonly');

echo '</br></br>Category : ';
echo form_input('Category', $product->Description, 'readonly');

echo '</br></br>Artist : ';
echo form_input('DescriptionArtist', $product->Artist, 'readonly');

echo '</br></br>Product in stock : ';
echo form_input('QtyInStock', $product->QtyInStock, 'readonly');

echo '</br></br>Cost : ';
echo form_input('BuyCost', $product->BuyCost, 'readonly');

echo '</br></br>Sale Price : ';
echo form_input('SalePrice', $product->SalePrice, 'readonly');

echo '</br></br>Discount : ';
echo form_input('priceAlreadyDiscounted', $product->priceAlreadyDiscounted, 'readonly');




echo '</br></br>';
echo '<img src=' . $img_base . 'full/' . $product->Photo . '>';

echo '</br></br>';
echo form_close();
