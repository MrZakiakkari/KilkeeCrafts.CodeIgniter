<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('header');
$this->load->helper('url');
$base = base_url() . index_page();
$img_base = base_url() . "assets/images/products/";
?>
<div class="list">
	<br><br>
	<h1 class="main">Wishlist</h1>
	<br><br>
	<table>
		<tr>
			<th align="left" width="100">CustomerId</th>
			<th align="left" width="100">ProductId</th>
			<td>&nbsp;</td>
		</tr>

		<?php foreach ($wishItems as $wishlist) { ?>
			<tr>
				<td><?php echo $wishlist->CustomerId; ?></td>
				<td><?php echo $wishlist->ProductId; ?></td>
				<td><?php echo anchor(
						'Wishlist/deletewishitem/' . $wishlist->CustomerId,
						'Delete',
						'onclick="return checkDelete()"'
					); ?>
                    <td><?php echo anchor('Products/viewproduct/' . $wishlist->ProductId, 'View', 'class="btn btn-primary"'); ?></td>
                    <td><?php echo anchor('Wishlist/addProductToCart/' . $wishlist->ProductId, 'Add to Cart', 'class="btn btn-success"'); ?></td></td>
			</tr>
		<?php } ?>
	</table>
	<?php echo $this->pagination->create_links(); ?>
	<br><br>
</div>
<?php $this->load->view('footer'); ?>