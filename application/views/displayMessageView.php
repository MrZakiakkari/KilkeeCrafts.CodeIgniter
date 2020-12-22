<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/";
?>
</br></br></br>
<?php echo $message?>
</br>
<button onclick='goBack()'>Go Back</button>
<?php
	$this->load->view('footer'); 
?>
