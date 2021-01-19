<?php

class UserRepository extends CI_Model
{


    public function getCustomer($email)
    {
        //Checks db for customer with matching email
        $this->db->select('contactFirstName');
        $this->db->select('customerNumber');
        $this->db->select('password');
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
        $Password = hash($this->passwordhash, $Password);
        $query = $this->db->get_where('customer', array("Email" => $Email, "Password" => $Password));
        return $query->num_rows() == 0 ? null : $query->result()[0];
    }
    private $passwordhash = 'sha256';
}
