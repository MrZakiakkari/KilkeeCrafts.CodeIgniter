<?php

$this->load->helper('url');
$base = base_url() . index_page();

if ($this->session->userdata('AdminId') != null) {
	redirect($base . "/KilkeekraftsController");
} ?>

<?php $this->load->view('header'); ?>
<div class="container">
	<div class="main">
		<div class="row">
			<div class="col-md-6">
				<div class="panel-body-login">
					<?php
					echo '<div id="login_form">';
					echo form_open('Admin/login_admin');
					echo '<span id="login_heading">Admin Login only!</span><br>';
					echo form_input(array('class' => 'form_field', 'name' => 'AdminName', 'type' => 'text', 'placeholder' => 'Email', 'required' => 'required')) . '<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'Password', 'type' => 'password', 'placeholder' => '*********', 'required' => 'required')) . '<br>';


					echo form_submit(array('id' => 'login_btn', 'value' => 'Login')) . '<br>';
					echo form_close();

					echo '<span id="login_failed">' . $this->session->flashdata('login_failed') . '</span>';
					echo '</div>';
					?>
				</div>
<?php $this->load->view('footer'); ?>