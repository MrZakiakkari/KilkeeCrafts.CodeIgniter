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

		<?php foreach($product_info as $row){?>
		<tr>
			<td><?php echo $row->Id;?></td>
			<td><?php echo $row->OrderDate;?></td>
			<td><?php echo $row->RequiredDate;?></td>
			<td><?php echo $row->ShippedDate;?></td>
			<td><?php echo $row->Status;?></td>
			<td><?php echo $row->Comments;?></td>
			<td><?php echo $row->CustomerNumber;?></td>
			<td><?php echo anchor('Orders/vieworder/'.$row->Id,'View');?></td>
			<td><?php echo anchor('Orders/editorder/'.$row->Id,'Update');?></td>
			<td><?php echo anchor('Orders/deleteorder/'.$row->Id,
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