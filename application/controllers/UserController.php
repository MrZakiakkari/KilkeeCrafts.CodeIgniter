<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        $email = $this->input->post("email");
        $password = $this->input->post("password");

        $user = $this->UserRepository->GetUserByCredentials($email, $password);
        if ($user != null) {
            $sessiondata = array('customerNumber' => $user->custNumber, 'email' => $email, 'contactFirstName' => $user->custFirstName);

            $this->session->set_userdata($sessiondata);
        } else {
            $this->session->set_flashdata('login_failed', 'Invalid username or password!');
        }
        redirect("ProductController/index");
    }

    public function login_admin()
    {
        if ($this->input->post("username")) {
            //Get the posted values
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            $adminNumber = null;
            $stored_password = null;

            $user = $this->UserRepository->getAdmin($username); //Gets ID and password hash of user

            //var_dump($user);
            foreach ($user as $row) {
                $adminNumber = $row['adminNumber'];
                $stored_password = $row['password'];
            }

            $hashed_password = hash('sha256', $adminNumber . $password); //Concatonates user id and password and hashes it

            if ($user != null && $hashed_password == $stored_password) //Compares entered password and stored password hashes
            {
                //Set the session variables, logging the user in
                $sessiondata = array('adminNumber' => $adminNumber, 'username' => $username);
                $this->session->set_userdata($sessiondata);
                echo "logged in";
                redirect("MoylishMarketController");
            } else {
                $this->session->set_flashdata('login_failed', 'Invalid username or password!');
                redirect("UserController/login");
            }
        }
    }

    public function login()
    {
        $this->load->view('header');
        $this->load->view('Login_Register');

        $passwordhash = 'sha256';
        $custPassowrd = hash($passwordhash, "letmein");
        echo $custPassowrd;
    }

    public function logout_user()
    {
        //Ends the session, logging the user out
        // deletes my test cookie
        //delete_cookie($name,$value,$expire,$path,$domain);
        // deletes my remember me cookie
        //delete_cookie($name1,$value1,$expire1,$path1,$domain1);
        $customerNumber = $this->session->userdata('customerNumber');
        $user = $this->UserRepository->getRemeberMe();
        if ($user != null)
            $this->UserRepository->deleteRememberMe($customerNumber);
        $this->session->sess_destroy();

        redirect("ProductController/index");
    }

    public function createAccount()
    {
        $values = $_POST;

        $loop = true;

        while ($loop == true) {
            $customerNumber = mt_rand(1000, 9999);

            if (!$this->UserRepository->if_ID_Exists($customerNumber)) {
                $loop = false;
            }
        }

        $hashed_password = hash('sha256', $customerNumber . $this->input->post('password')); //Concatonates user id and password and hashes it

        $values['customerNumber'] = $customerNumber;
        $values['password'] = $hashed_password;

        $user = $this->UserRepository->createAccount($values);

        if ($user) {
            $this->session->set_flashdata('create_account_success', 'Account Created');
        } else {
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
