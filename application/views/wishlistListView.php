<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/products/";
?>
<div class="list">
	<br><br>
	<h1 class="main">List of wishlists</h1>
	<br><br>
	<table>
		<tr>
			<th align="left" width="100">CustomerId</th>
			<th align="left" width="100">ProductId</th>
		
		</tr>

		<?php foreach($wishlists as $wishlist){?>
		<tr>
			<td><?php echo $wishlist->CustomerId;?></td>
			<td><?php echo $wishlist->ProductId;?></td>
	
			<td><?php echo anchor('Wishlist/viewwishlist/'.$wishlist->CustomerId,'View');?></td>
			<td><?php echo anchor('Wishlist/editwishlist/'.$wishlist->CustomerId,'Update');?></td>
			<td><?php echo anchor('Wishlist/deletewishlist/'.$wishlist->CustomerId,
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