<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/products/";
?>
<div class="list">
	<br><br>
	<h1 class="main">List of products</h1>
	<br><br>
	<table>
		<tr>
			<th align="left" width="100">Id</th>
			<th align="left" width="100">Description</th>
			<th align="left" width="100">Category</th>
			<th align="left" width="100">Artist</th>
			<th align="left" width="100">QtyInStock</th>
			<th align="left" width="100">BuyCost</th>
			<th align="left" width="100">SalePrice</th>
			<th align="left" width="100">priceAlreadyDiscounted</th>
			<th align="left" width="100">Photo</th>
		</tr>

		<?php foreach($product_info as $row){?>
		<tr>
			<td><?php echo $row->Id;?></td>
			<td><?php echo $row->Description;?></td>
			<td><?php echo $row->Category;?></td>
			<td><?php echo $row->Artist;?></td>
			<td><?php echo $row->QtyInStock;?></td>
			<td><?php echo $row->BuyCost;?></td>
			<td><?php echo $row->SalePrice;?></td>
			<td><?php echo $row->priceAlreadyDiscounted;?></td>
			<td><img src="<?php echo $img_base.'thumbs/'.$row->Photo;?>"></td>
			<td><?php echo anchor('Product/viewproduct/'.$row->Id,'View');?></td>
			<td><?php echo anchor('Product/editproduct/'.$row->Id,'Update');?></td>
			<td><?php echo anchor('Product/deleteproduct/'.$row->Id,
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