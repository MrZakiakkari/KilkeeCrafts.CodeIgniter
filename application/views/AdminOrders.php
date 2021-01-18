<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/products/";
	$jsbase = base_url()."assets/js/";
?>
<div class="orderContainer" > 
	<br>
	<div id="cart_header">
	<?php echo '<a class = "back_Btn" href="' . base_url("index.php/AccountController/controlPanel") . '"><span>Return to Control Panel</span></a>'; ?>
	</div>
	<br>
	<?php
		echo '<div id="search">';		
		echo form_open('ProductController/SearchOrders'); 
		echo form_input(array ('id' => 'search_box', 'name' => 'searchOrderInput', 'type' => 'text', 'placeholder' => '   Search..', 'required'=>'required') );
		echo form_submit(array('id' => 'search_btn', 'name' => 'searchButton', 'value' => 'Search'));
		//$this->input->post('search');
		echo form_close(); 
		echo '</div><br>';
	?>
	
		<table id= "Product">
			<th>Order Date</th>
			<th>Required Date</th>
			<th>Shipped Date</th>
			<th>Status<th>Comments</th>
			<th>Customer ID</th>
			<th></th>
			<th></th>
		
				
		
		<?php foreach($data as $order) { 	
		echo form_open('ProductController/adminOrders'); 	?>
	
		<?php	echo form_hidden('orderNumber', $order['orderNumber']); ?>
		
		<tr>
		<?php
		echo '<td>' . form_input(array('id' => 'orderInput','name' => 'orderDate', 'type' => 'text', 'value' => $order['orderDate'], 'required'=>'required')). '</td>';
		echo '<td>' . form_input(array('id' => 'orderInput','name' => 'requiredDate', 'type' => 'date', 'value' => $order['requiredDate'])). '</td>';
		echo '<td>' . form_input(array('id' => 'orderInput','name' => 'shippedDate', 'type' => 'date', 'value' => $order['shippedDate'])). '</td>';		
		//echo '<td>' . form_input(array('id' => 'orderInput','name' => 'status', 'type' => '', 'value' => $order['status'], 'required'=>'required')). '</td>';
		echo '<td>
		<select name="status">
			<option value="default">'.$order['status'].'</option>
			<option value="Cancelled">Cancelled</option>
			<option value="Disputed">Disputed</option>
			<option value="In Process">In Process</option>
			<option value="On Hold">On Hold</option>
			<option value="Resolved">Resolved</option>
			<option value="Shipped">Shipped</option>
		</select></td>';
		echo '<td> ' . form_input(array('id' => 'orderInput','name' => 'comments', 'type' => 'textarea', 'value' => $order['comments'])). '</td>';
		echo '<td>' . $order['customerNumber'] . '</td>';
?>

		<td><a class = "addCart"  onclick="window.location='<?php echo base_url('index.php/ProductController/OrderDetails/'.$order['orderNumber'] );?>' ;" >View</a></td> 
<?php		
		$url = 'index.php/ProductController/update_order?orderNumber=' . $order['orderNumber'] . '"';
		echo '<td>' . form_submit(array('id' => 'search_btn', 'value' => 'Update')) . '</td>'; 
		
		$url = 'index.php/ProductController/delete_order?orderNumber=' . $order['orderNumber'] . '"';
		echo '<td>'.form_submit(array('id' => 'search_btn', 'value' => 'Cancel')).'</td>'; 

		
		echo '</tr>';
	echo form_close(); 
}
?>
		</table>
</div>
<?php
	$this->load->view('footer'); 
?>

