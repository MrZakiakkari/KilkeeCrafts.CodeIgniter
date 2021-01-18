<?php
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."/assets/images/";
?>
<div class="container" > 

	<div class="main">
		<!-- <input type="button" value="Go back!" onclick="history.back()"> -->
		<div class="row">
			<div class="col-md-6" >
				<div class = "panel-body-login">
				<?php
				echo '<div id="login_form">';		
				echo form_open('UserController/login_user'); 
				echo '<span id="login_heading">Login as a User</span><br>';
				echo form_input(array('class' => 'form_field', 'name' => 'email', 'type' => 'email', 'placeholder' => 'Email', 'required'=>'required')).'<br>';	
				echo form_input(array('class' => 'form_field', 'name' => 'password', 'type' => 'password', 'placeholder' => '*********', 'required'=>'required')).'<br>';	
				echo '<input type="checkbox" name="RememberMe" value="1">Remember Me';

				echo form_submit(array('id' => 'login_btn', 'value' => 'Login')).'<br>';
				echo form_close(); 	
				
				echo '<span id="login_failed">' . $this->session->flashdata('login_failed') . '</span>';			               		 
				echo '</div><br><br>';
				
				echo '<div id="login_form">';		
				echo form_open('UserController/login_admin'); 
				echo '<span id="login_heading">Login as an Admin</span><br>';
				echo form_input(array('class' => 'form_field', 'name' => 'username', 'type' => 'text', 'placeholder' => 'Username', 'required'=>'required')).'<br>';	
				echo form_input(array('class' => 'form_field', 'name' => 'password', 'type' => 'password', 'placeholder' => '*********', 'required'=>'required')).'<br><br>';	
				echo form_submit(array('id' => 'login_btn', 'value' => 'Login'));
				echo form_close();
				
				echo '<span id="login_failed">' . $this->session->flashdata('login_failed') . '</span>';				
				echo '</div>';			
				
				?>
				</div>
			</div>
		
			<div class="col-md-6" >
				<div class = "panel-body-login">
				<?php
					if($this->session->userdata('id'))
					{
						redirect(KilkeekraftsController);	
					}

					echo '<div id="create_account_form">';
					echo form_open('UserController/createAccount'); 	
					echo '<span id="create_account_heading">Create Account</span><br>';
					echo form_input(array('class' => 'form_field', 'name' => 'email', 'type' => 'email', 'placeholder' => 'Email', 'required'=>'required||min_length[10] '   )).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'password', 'type' => 'password', 'placeholder' => 'Password', 'required'=>'required||min_length[8]')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'customerName', 'type' => 'text', 'placeholder' => 'Customer Name', 'required'=>'required')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'contactFirstName', 'type' => 'text', 'placeholder' => 'First Name', 'required'=>'required')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'contactLastName', 'type' => 'text', 'placeholder' => 'Last Name', 'required'=>'required')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'phone', 'type' => 'text', 'placeholder' => 'Contact Number', 'required'=>'required||min_length[10]')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'addressLine1', 'type' => 'text', 'placeholder' => 'Address 1', 'required'=>'required')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'addressLine2', 'type' => 'text', 'placeholder' => 'Address 2')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'city', 'type' => 'text', 'placeholder' => 'City', 'required'=>'required')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'postalCode', 'type' => 'text', 'placeholder' => 'Postal Code')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'country', 'type' => 'text', 'placeholder' => 'Country', 'required'=>'required')).'<br><br>';	
					echo form_submit(array('id' => 'create_account_btn', 'value' => 'Create Account')).'<br>';
					echo form_close(); 
					
					echo '<span id="create_account_failed">' . $this->session->flashdata('create_account_failed') . '</span>';
					echo '<span id="create_account_success">' . $this->session->flashdata('create_account_success') . '</span>';
					echo '</div>';
				?>
				</div>
			</div>
		
		</div>
		<br><br><br>
		
	</div>
</div>
<?php
	$this->load->view('footer'); 
?>
