<?php

$this->load->helper('url');
$base = base_url() . index_page();

if ($this->session->userdata('CustomerId') != null) {
	redirect($base . "/Kilkeekrafts");
} ?>

<?php $this->load->view('header'); ?>
<div class="container">
	<div class="main">
		<div class="row">
			<div class="col-md-6">
				<div class="panel-body-login">
					<?php
					echo '<div id="login_form">';
					echo form_open('UserController/login_user');
					echo '<span id="login_heading">Login as a User</span><br>';
					echo form_input(array('class' => 'form_field', 'name' => 'email', 'type' => 'email', 'placeholder' => 'Email', 'required' => 'required')) . '<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'password', 'type' => 'password', 'placeholder' => '*********', 'required' => 'required')) . '<br>';


					echo form_submit(array('id' => 'login_btn', 'value' => 'Login')) . '<br>';
					echo form_close();

					echo '<span id="login_failed">' . $this->session->flashdata('login_failed') . '</span>';
					echo '</div>';
					?>
				</div>
			</div>
	
<?php $this->load->view('footer'); ?>