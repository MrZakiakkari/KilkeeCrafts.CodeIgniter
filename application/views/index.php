<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/";
?>
    <div class="main">
		<br><br><br><br>
		<h1>KilKeekrafts</h1>
		<p>Welcome to Kilkeekrafts where you can find a masterpiece art for collection</a>
		<br><br><br><br>
	</div>
	  <div class="col-md-4" >
								
								<div class="panel ">
								<br>
                                    <div class="panel-body">
                                    <?php
										echo '<div id="search">';		
										echo form_open('ProductController/SearchProducts'); 
										echo form_input(array('id' => 'search_box', 'name' => 'searchInput', 'type' => 'text', 'placeholder' => '   Search..', 'required'=>'required'));
										echo form_submit(array('id' => 'search_btn', 'name' => 'searchButton', 'value' => 'Search'));
										//$this->input->post('search');
										echo form_close(); 
										echo '</div><br>';
									?>
									</div>
								</div>
<?php
	$this->load->view('footer'); 
?>