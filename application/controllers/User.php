<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
            $sessiondata = array('CustomerId' => $user->Number, 'email' => $email, 'username' => $user->FirstName, "type" => "customer");

            $this->session->set_userdata($sessiondata);
            redirect("Products/index");
         
        } else {
            $this->session->set_flashdata('login_failed', 'Invalid username or password!');
            redirect("user/error");//TODO: fix
        }
    }

    
    public function register()
    {
        
        $this->load->view('UserRegister');
    }
    public function login()
    {
        
        $this->load->view('UserLogin');
    }
    public function index()
    {
        
        $this->load->view('UserLogin');
    }

    public function logout_user()
    {
        $this->session->sess_destroy();

        redirect("Products/index");
    }

    public function createAccount()
    {
        $user['Number'] = $this->input->post('Number');
        $user['LastName'] = $this->input->post('LastName');
        $user['FirstName'] = $this->input->post('FirstName');
        $user['Phone'] = $this->input->post('Phone');
        $user['AddressLine1'] = $this->input->post('AddressLine1');
        $user['AddressLine2'] = $this->input->post('AddressLine2');
        $user['City'] = $this->input->post('City');
        $user['PostalCode'] = $this->input->post('PostalCode');
        $user['Country'] = $this->input->post('Country');
        $user['CreditLimit'] = $this->input->post('CreditLimit');
        $user['Email'] = $this->input->post('Email');
        $user['Password'] = $this->UserRepository->createPasswordHash($this->input->post('Password'));
        $inserted =  $this->UserRepository->createAccount($user);

        if ($inserted) {
            $this->session->set_flashdata('create_account_success', 'Account Created');
        } else {
            $this->session->set_flashdata('create_account_failed', 'Error! Account creation failed');
        }

        
        $this->load->view('login_Register');
    }

}
