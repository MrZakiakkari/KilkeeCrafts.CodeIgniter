<?php
$this->load->helper('url');
$base = base_url() . index_page();
$img_base = base_url() . "assets/images/";
?>
<?php $this->load->view('header'); ?>
<div class="main">
	<h1>KilKeekrafts</h1>
	<p>Welcome to Kilkeekrafts where you can find a masterpiece art for collection</p>
</div>
<div class="col-md-4">

	<div class="panel ">
		<br>
		<div class="panel-body">
			<form action="<?php echo base_url()?>index.php/controlpanel/Products/search">
		<input id="search" name="search" placeholder="Search">
		<button type="submit">Search</button>
	</form>
		</div>
	</div>
	<?php $this->load->view('footer'); ?>