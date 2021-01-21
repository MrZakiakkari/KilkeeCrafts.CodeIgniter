<?php

class UserRepository extends CI_Model
{

    public function __construct()
    {
        $this->load->model("schema/KilkeekraftsSchema");
        $this->load->model("schema/CustomerSchema");
    }

    public function createPasswordHash($plainTextPassword)
    {
        return hash($this->CustomerSchema->Password_Hash, $plainTextPassword);
    }

    public function getCustomer($email)
    {
        $this->db->from('customer');
        $this->db->where('email', $email);
        $query = $this->db->get();

        //returns users email and password
        return $query->result_array();
    }
    public function createAccount($values)
    {
        if ($this->db->insert('customer', $values))
            return true;

        else
            return false;
    }


    public function GetUserByCredentials($Email, $Password)
    {
        $Password = $this->createPasswordHash($Password);
        $query = $this->db->get_where('customer', array("Email" => $Email, "Password" => $Password));
        return $query->num_rows() == 0 ? null : $query->result()[0];
    }
}
