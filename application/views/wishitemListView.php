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

		<?php foreach ($wishItems as $wishitem) { ?>
			<tr>
				<td><?php echo $wishitem->CustomerId; ?></td>
				<td><?php echo $wishitem->ProductId; ?></td>
				<td><?php echo anchor(
						'WishItems/deletewishitem/' . $wishitem->CustomerId.'/'. $wishitem->ProductId,
						'Delete',
						'onclick="return checkDelete()"'
					); ?>
                    <td><?php echo anchor('Products/viewproduct/' . $wishitem->ProductId, 'View', 'class="btn btn-primary"'); ?></td>
                    <td><?php echo anchor('WishItems/addProductToCart/' . $wishitem->ProductId, 'Add to Cart', 'class="btn btn-success"'); ?></td></td>
			</tr>
		<?php } ?>
	</table>
	<?php echo $this->pagination->create_links(); ?>
	<br><br>
</div>
<?php $this->load->view('footer'); ?>