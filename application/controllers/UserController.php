<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller
{
	public function __construct()
    {
    	parent::__construct();

		$this->load->model('UserRepository');
    	$this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');    
        $this->load->library('session');
		$this->load->helper('cookie');  
        $this->load->library('form_validation');
    }

    public function login_user()
    {
        //Get the posted values
        $email = $this->input->post("email");
        $password = $this->input->post("password");
		//$remember = $this->input->post("RememberMe");
		
        $customerNumber = null;
        $stored_password = null;
        $contactFirstName = null;

        $result = $this->UserRepository->getCustomer($email); //Gets ID and password hash of user

        foreach ($result as $row)
        {
           $customerNumber = $row['customerNumber'];
           $stored_password = $row['password'];
           $contactFirstName = $row['contactFirstName'];
        }
			// Get Checkbox remember me 
			// Remember Me Cookie 
				$name1 = "rememberMeToken";
				$value1 = "This is how the cookie crumbles";
				// Two weeks from this DateTime
				$expire1 =  time() + 1209600;  
				$domain1 = 'localhost';
				$path1   = '/';
					
			
		
        $hashed_password = hash('sha256', $customerNumber.$password); //Concatonates user id and password and hashes it
       		
        if($result != null && $hashed_password == $stored_password) //Compares entered password and stored password hashes
        {        
            //Set the session variables, logging the user in
            $sessiondata = array('customerNumber' => $customerNumber, 'email' => $email, 'contactFirstName' => $contactFirstName);
            
			$this->session->set_userdata($sessiondata);
			
			//Setting Up my own cookie for testing
			$name = "Cookie_Email";
			$value = $this->session->userdata('email');
			$expire = time()+1000;
			$path   = '/';
			$domain = 'localhost';
			
			setcookie($name,$value,$expire,$path,$domain);	
			// End of My own cookie		
			setcookie($name1,$value1,$expire1,$domain1,$path1);	
						
            $remember = $this->input->post("RememberMe");
			echo $remember;
			if((int)($remember) == 1)
			{
				$this->UserRepository->addRememberMe($value1, $customerNumber); 	
				echo "logged in";	
				redirect("ProductController/index");  
			}
			echo "logged in";	
            redirect("ProductController/index");  
						
        }    

        else
        {
            $this->session->set_flashdata('login_failed', 'Invalid username or password!');
            redirect('ProductController');
        } 
    } 

    public function login_admin()
    {    
        if($this->input->post("username"))
        {
            //Get the posted values
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            $adminNumber = null;
            $stored_password = null;

            $result = $this->UserRepository->getAdmin($username); //Gets ID and password hash of user

            //var_dump($result);
            foreach ($result as $row)
            {
               $adminNumber = $row['adminNumber'];
               $stored_password = $row['password'];
            }
            
            $hashed_password = hash('sha256', $adminNumber.$password); //Concatonates user id and password and hashes it

            if($result != null && $hashed_password == $stored_password) //Compares entered password and stored password hashes
            {        
                //Set the session variables, logging the user in
                $sessiondata = array('adminNumber' => $adminNumber, 'username' => $username);
                $this->session->set_userdata($sessiondata);
				echo "logged in";
                redirect("MoylishMarketController");        
            }    

            else
            {
                $this->session->set_flashdata('login_failed', 'Invalid username or password!');
                redirect("UserController/login");
            }       
        }   
    }

    public function login()
    {
        $this->load->view('header');        
        $this->load->view('login');
    } 
	
	public function logout_user()
    {
        //Ends the session, logging the user out
		// deletes my test cookie
        //delete_cookie($name,$value,$expire,$path,$domain);
		// deletes my remember me cookie
		//delete_cookie($name1,$value1,$expire1,$path1,$domain1);
		$customerNumber = $this->session->userdata('customerNumber');
		$result = $this->UserRepository->getRemeberMe(); 
		if($result != null)
			$this->UserRepository->deleteRememberMe($customerNumber); 
		$this->session->sess_destroy();
		
        redirect("ProductController/index"); 
    }
	
    public function createAccount()
    {
        $values = $_POST;

        $loop = true;

        while($loop == true)
        {
            $customerNumber = mt_rand(1000,9999);

            if(!$this->UserRepository->if_ID_Exists($customerNumber))
            {
                $loop = false;
            }
        }

        $hashed_password = hash('sha256', $customerNumber.$this->input->post('password')); //Concatonates user id and password and hashes it

        $values['customerNumber'] = $customerNumber;
        $values['password'] = $hashed_password;

        $result = $this->UserRepository->createAccount($values);

        if($result)
        {
            $this->session->set_flashdata('create_account_success', 'Account Created');
        }
            
        else
        {
            $this->session->set_flashdata('create_account_failed', 'Error! Account creation failed');
        }
        
        $this->load->view('header');        
        $this->load->view('login');

    }

    
    public function controlPanel()
    {
        $this->load->view('controlPanel');
    }
}


