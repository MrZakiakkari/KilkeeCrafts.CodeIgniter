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
			<div class="cartHeading">Checkout</div>	
			<?php
				foreach ($this->cart->contents() as $item)
				{
					echo '<div class="cart_item">';
					echo '<h5> '.$item['name'] .' </h5> ';
					$url = "index.php/ProductController/removeFromCart?rowid=" . $item['rowid'] . '"';
					echo '<div class="removeCart"><a id="xWishlist" title="Remove from Cart" href=" '.base_url($url).' " >x</a> </div>';
			
					echo '<div class="cart_image">' . $item['photo'] . '</div>';
			
					echo form_open('ProductController/cart_quantity'); 
					echo form_hidden('rowid', $item['rowid']);
					echo 'Quantity: ' . form_input(array('class' => 'quantity	', 'name' => 'quantity', 'type' => 'text', 'value' => $item['qty']));
					echo form_submit(array('class' => 'quantitybtn', 'value' => 'Update '));
					echo form_close(); 

					echo '<div class="cart_price">' . '€' . $item['price'] * $item['qty'] . '</div>';
					echo '<p><p>';
					echo '<br><br>';
			
					echo '</div>';
				}

				if($this->cart->contents())
				{
					echo form_open('ProductController/cartOrder'); 
					echo form_submit(array('id' => 'cart_order_btn', 'value' => 'Order'));
					echo form_close(); 
					echo '<br><br>';
				}

				else
				{
					echo '<div id="empty_cart_msg">Cart is empty</div>';
					echo '<img class = "wislistIcon" src=" '.$img_base .'full/emptyCart.png">';
					echo '<br><br><br><br><br><br><br><br><br><br><br><br>';
		
				}
				?>
				</div>
				</div>	 <!--end of Middle -->
				
				<div class="col-md-3" >
					<div class = "cartInfo">
						<br>
						<h5>Total of Cart : €<?php echo $this->cart->total(); ?></h5>
						<h5>Total of Items :<?php echo $this->cart->total_items(); ?></h5>
						<?php 
						$url = "index.php/ProductController/emptyCart";
						echo ' <a id = "emptyCart" href=" '.base_url($url).' ">Empty Cart</a> ';
						?>
					</div>
				</div>

					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			
		</div> <!--end of Row container-->
	</div> <!--end of Cart container-->
</div> <!--end of Main container-->

<?php
	$this->load->view('footer'); 
?>