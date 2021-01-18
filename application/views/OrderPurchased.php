<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$this->load->helper('cookie');
	$this->load->helper('form');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/products/";
	
?>

<div class="container" > 
	<br><br>	
	<h1 class="main">Order Purchased</h1>

				<div class= "noSearch">
				 <p>Thank you for ur purchase<P> 
				</div>	
			
   <br><br><br>
</div>

<?php
	$this->load->view('footer'); 
?>