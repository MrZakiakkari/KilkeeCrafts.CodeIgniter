<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/products/";
	$jsbase = base_url()."assets/js/";
?>

<div class="main">

	<div class="cart1">
		<br>
		
		
		<div class="row">			
			<div class="col-md-9" >
			<div class="cart">
			<div class="cartHeading">Orders</div>	
			
			<?php

			$total_price = 0;

			foreach ($this->cart->contents() as $item)
			{
				echo '<div>';
				echo $item['name'] . "</br>";
				echo '<div class="order_image">' . $item['photo'] . '</div><br>';
				echo form_open('ProductController/order_quantity'); 
				echo form_hidden('rowid', $item['rowid']);
				echo 'Quantity: ' . form_input(array('id' => 'quantity', 'name' => 'quantity', 'type' => 'text', 'value' => $item['qty']));
				echo form_submit(array('class' => 'Order_btn', 'value' => 'Update'));
				echo form_close(); 

				echo '<br><div class="cart_price">' . '€' . $item['price'] * $item['qty'] . '</div></br>';
				$total_price += $item['price'] * $item['qty'];

				$url = "index.php/ProductController/remove_from_order?rowid=" . $item['rowid'] . '"';
				echo '<div id="xWishlist"><a title="Remove from Order" href="' . base_url($url) . '>x</a></div>';
				echo '</div>';
				echo '<hr>';
			}

			echo '<span id="total_price">Total Price: €' . $total_price . '</div>';

			echo form_open('ProductController/checkout'); 
			echo form_submit(array('class' => 'Order_btn', 'value' => 'Pay'));
			echo form_close(); 
			echo '<br><br>';
?>	
				
				
				
			</div> <!--end of Middle -->
			<br><br><br><br>
			
		</div> <!--end of Row container-->
	</div> <!--end of Cart container-->
</div> <!--end of Main container-->



<?php
	//var_dump($this->cart);

	$this->load->view('footer'); 
?>