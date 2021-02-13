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
	<div class="panel">
		<p>Uunauthorized Access</p>
		<?php
		if (isset($unauthorizedPath)) {
			echo "<p>" . $unauthorizedPath . "</p>";
		}
		?>
		<p><a href="">Click here to try and login as an admin.</a></p>
	</div>
</div>
<?php $this->load->view('footer'); ?>