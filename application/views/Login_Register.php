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
				

				echo form_submit(array('id' => 'login_btn', 'value' => 'Login')).'<br>';
				echo form_close(); 	
				
				echo '<span id="login_failed">' . $this->session->flashdata('login_failed') . '</span>';			               		 
				echo '</div><br><br>';
				
				echo '<div id="login_form">';		
				echo form_open('Admin/login_admin'); 
				echo '<span id="login_heading">Login as an Admin</span><br>';
				echo form_input(array('class' => 'form_field', 'name' => 'AdminName', 'type' => 'text', 'placeholder' => 'Username', 'required'=>'required')).'<br>';	
				echo form_input(array('class' => 'form_field', 'name' => 'Password', 'type' => 'password', 'placeholder' => '*********', 'required'=>'required')).'<br><br>';	
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
					if($this->session->userdata('Number'))
					{
						redirect(KilkeekraftsController);	
					}

					echo '<div id="create_account_form">';
					echo form_open('User/createAccount'); 	
					echo '<span id="create_account_heading">Create Account</span><br>';
					echo form_input(array('class' => 'form_field', 'name' => 'Email', 'type' => 'email', 'placeholder' => 'Email', 'required'=>'required||min_length[10] '   )).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'Password', 'type' => 'password', 'placeholder' => 'Password', 'required'=>'required||min_length[8]')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'FirstName', 'type' => 'text', 'placeholder' => 'First Name', 'required'=>'required')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'LastName', 'type' => 'text', 'placeholder' => 'Last Name', 'required'=>'required')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'Phone', 'type' => 'text', 'placeholder' => 'Contact Number', 'required'=>'required||min_length[10]')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'AddressLine1', 'type' => 'text', 'placeholder' => 'Address 1', 'required'=>'required')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'AddressLine2', 'type' => 'text', 'placeholder' => 'Address 2')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'City', 'type' => 'text', 'placeholder' => 'City', 'required'=>'required')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'PostalCode', 'type' => 'text', 'placeholder' => 'Postal Code')).'<br>';
					echo form_input(array('class' => 'form_field', 'name' => 'Country', 'type' => 'text', 'placeholder' => 'Country', 'required'=>'required')).'<br>';	
					echo form_input(array('class' => 'form_field', 'name' => 'CreditLimit', 'type' => 'text', 'placeholder' => 'Credit Limit', 'required'=>'required')).'<br><br>';
					echo form_submit(array('Number' => 'create_account_btn', 'value' => 'Create Account')).'<br>';
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
