<?php $this->load->view('header'); ?>
<?php
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
		
		</tr>

		<?php foreach($orders as $order){?>
		<tr>
			<td><?php echo $order->Id;?></td>
			<td><?php echo $order->OrderDate;?></td>
			<td><?php echo $order->RequiredDate;?></td>
			<td><?php echo $order->ShippedDate;?></td>
			<td><?php echo $order->Status;?></td>
			<td><?php echo anchor('Orders/vieworder/'.$order->Id,'View');?></td>
		</tr>     
		<?php }?>  
   </table>
   <?php echo $this->pagination->create_links();?>
   <br><br>
</div>
<?php
	$this->load->view('footer'); 
?>