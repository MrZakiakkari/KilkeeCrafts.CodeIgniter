<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminLogin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('AdminRepository');
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->library('form_validation');
    }

    public function login_admin()
    {
        $name = $this->input->post("AdminName");
        $password = $this->input->post("Password");

        $user = $this->AdminRepository->GetAdminByCredentials($name, $password);
        if ($user != null) {
            $sessiondata = array('AdminId' => $user->Id, 'username' => $name, "type" => "admin");

            $this->session->set_userdata($sessiondata);
         
        } else {
            $this->session->set_flashdata('login_failed', 'Invalid username or password!');
        }
        redirect("admin/Products/index");
    }

    public function index()
    {
        $this->load->view('AdminLogin');
    }
    public function login()
    {
        
        $this->load->view('AdminLogin');
    }

    public function logout_user()
    {
        $this->session->sess_destroy();

        redirect("Products/index");
    }
	 
}