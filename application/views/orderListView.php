<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/products/";
?>
<div class="list">
	<br><br>
	<h1 class="main">List of orders</h1>
	<br><br>
	<table>
		<tr>
			<th align="left" width="100">Id</th>
			<th align="left" width="100">OrderDate</th>
			<th align="left" width="100">RequiredDate</th>
			<th align="left" width="100">ShippedDate</th>
			<th align="left" width="100">Status</th>
			<th align="left" width="100">Comments</th>
			<th align="left" width="100">CustomerNumber</th>
		
		</tr>

		<?php foreach($order as $order){?>
		<tr>
			<td><?php echo $order->Id;?></td>
			<td><?php echo $order->OrderDate;?></td>
			<td><?php echo $order->RequiredDate;?></td>
			<td><?php echo $order->ShippedDate;?></td>
			<td><?php echo $order->Status;?></td>
			<td><?php echo $order->Comments;?></td>
			<td><?php echo $order->CustomerNumber;?></td>
			<td><?php echo anchor('Orders/vieworder/'.$order->Id,'View');?></td>
			<td><?php echo anchor('Orders/editorder/'.$order->Id,'Update');?></td>
			<td><?php echo anchor('Orders/deleteorder/'.$order->Id,
				'Delete', 'onclick="return checkDelete()"');?></td>
		</tr>     
		<?php }?>  
   </table>
   <?php echo $this->pagination->create_links();?>
   <br><br>
</div>
<?php
	$this->load->view('footer'); 
?>