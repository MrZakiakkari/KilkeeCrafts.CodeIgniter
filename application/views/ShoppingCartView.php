<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('url');
$base = base_url() . index_page();
$img_base = base_url() . "assets/images/products/";
$jsbase = base_url() . "assets/js/";
?>

<?php $this->load->view('header'); ?>

<?php echo form_open($base . '/shoppingcart/update/'); ?>

<table cellpadding="6" cellspacing="1" style="width:100%;" >

	<tr>
		<th>QTY</th>
		<th>Item Description</th>
		<th style="text-align:right">Item Price</th>
		<th style="text-align:right">Sub-Total</th>
	</tr>

	<?php $i = 1; ?>

	<?php foreach ($this->cart->contents() as $cartItem) : ?>

		<?php echo form_hidden($i . '[rowid]', $cartItem['rowid']); ?>

		<tr>
			<td><?php echo form_input(array('name' => $i . '[qty]', 'value' => $cartItem['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
			<td>
				<?php echo $cartItem['name']; ?>

				<?php if ($this->cart->has_options($cartItem['rowid']) == TRUE) : ?>

					<p>
						<?php foreach ($this->cart->product_options($cartItem['rowid']) as $option_name => $option_value) : ?>

							<strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

						<?php endforeach; ?>
					</p>

				<?php endif; ?>

			</td>
			<td style="text-align:right"><?php echo $this->cart->format_number($cartItem['price']); ?></td>
			<td style="text-align:right">$<?php echo $this->cart->format_number($cartItem['subtotal']); ?></td>
		</tr>

		<?php $i++; ?>

	<?php endforeach; ?>

	<tr>
		<td colspan="2"> </td>
		<td class="right"><strong>Total</strong></td>
		<td class="right">$<?php echo $this->cart->format_number($this->cart->total()); ?></td>
	</tr>

</table>

<p><?php echo form_submit('', 'Update your Cart'); ?></p>
<?php echo form_close(); ?>

<?php echo form_open($base . '/shoppingcart/checkout/'); ?>
<p><?php echo form_submit('', 'Checkout'); ?></p>
<?php echo form_close(); ?>

<?php $this->load->view('footer'); ?>