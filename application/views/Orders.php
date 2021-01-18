<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/products/";
	$jsbase = base_url()."assets/js/";
?>

<div class="container" > 
	<div class="ProductMain">
		<br>
		<h1 class="main">Orders</h1>
		<table id="Product">	
		<tr>
			<th onclick="sortTable(0)">Order ID</th>
			<th colspan = "10"onclick="sortTable(1)">Order Date</th>
			<th colspan = "10"onclick="sortTable(2)">Required Date</</th>
			<th colspan = "10"onclick="sortTable(3)">Shipped Date</th>
			<th colspan = "10"onclick="sortTable(4)">Status</th>
			<th colspan = "10"onclick="sortTable(5)">Comments </th>
			<th colspan = "10">Option </th>
			<th colspan = "10"></th>
		</tr>
		
		<?php foreach($data as $order) { echo form_open('ProductController/orders'); ?>
		<tr onclick="window.location='<?php echo base_url('index.php/ProductController/OrderDetails/'.$order['orderNumber'] );?>' ;">
		<tr>
			<?php// echo form_hidden('orderNumber', $order['orderNumber']); ?>
			<td ><?php echo $order['orderNumber'] ;?></td>
			<td colspan = "10"><?php echo $order['orderDate'];?></td>
			<td colspan = "10"><?php echo $order['requiredDate'];?></td>
			<td colspan = "10"><?php echo $order['shippedDate'];?></td>
			<td colspan = "10"><?php echo $order['status'];?></td>
			<td colspan = "10"><?php echo $order['comments'];?></td>
			<td colspan = "10"> 
				<?php
					if( ($order['status'] != "Shipped") && ($order['status'] != "default") )
					{
						$url = "index.php/ProductController/cancel_order?orderNumber= ". $order['orderNumber']; 
						echo ' <a class = "addCart" href=" '.base_url($url).' "> Cancel</a> '; 
					}
				?> 
			</td>
			<td colspan = "10"> <?php $url = "index.php/ProductController/OrderDetails/".$order['orderNumber']; echo ' <a class = "addCart" href=" '.base_url($url).' "> View</a> '; ?> </td>
			</tr>   	
		<?php echo form_close(); }?> 

	</table>
	<br><br><br><br><br><br><br>	
	</div>
</div>

<?php
	$this->load->view('footer'); 
?>

