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
			<th align="left" width="100">prodCode</th>
			<th align="left" width="100">prodDescription</th>
			<th align="left" width="100">prodCategory</th>
			<th align="left" width="100">prodArtist</th>
			<th align="left" width="100">prodQtyInStock</th>
			<th align="left" width="100">prodBuyCost</th>
			<th align="left" width="100">prodSalePrice</th>
			<th align="left" width="100">priceAlreadyDiscounted</th>
			<th align="left" width="100">prodPhoto</th>
		</tr>

		<?php foreach($product_info as $row){?>
		<tr>
			<td><?php echo $row->prodCode;?></td>
			<td><?php echo $row->prodDescription;?></td>
			<td><?php echo $row->prodCategory;?></td>
			<td><?php echo $row->prodArtist;?></td>
			<td><?php echo $row->prodQtyInStock;?></td>
			<td><?php echo $row->prodBuyCost;?></td>
			<td><?php echo $row->prodSalePrice;?></td>
			<td><?php echo $row->priceAlreadyDiscounted;?></td>
			<td><img src="<?php echo $img_base.'thumbs/'.$row->prodPhoto;?>"></td>
			<td><?php echo anchor('ProductController/viewAdmin/'.$row->prodCode,'View');?></td>
			<td><?php echo anchor('ProductController/editAdmin/'.$row->prodCode,'Update');?></td>
			<td><?php echo anchor('ProductController/deleteAdmin/'.$row->prodCode,
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