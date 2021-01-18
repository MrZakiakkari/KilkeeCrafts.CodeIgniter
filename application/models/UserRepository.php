<?php

class UserRepository extends CI_Model
{


    public function getCustomer($email)
    {
        //Checks db for customer with matching email
        $this->db->select('contactFirstName');
        $this->db->select('customerNumber');
        $this->db->select('password');
        $this->db->from('customers');
        $this->db->where('email', $email);
        $query = $this->db->get();

        //returns users email and password
        return $query->result_array();
    }
    public function addRememberMe($value1, $customerNumber)
    {
        // Add users  Remember_me_token
        //$this->db->query('UPDATE customers SET remember_me_token = "$value1" WHERE customerNumber = "$customerNumber" ');

        $this->db->set('remember_me_token', $value1);
        $this->db->where('customerNumber', $customerNumber);
        $this->db->update('customers');
        $query = $this->db->get();
        return $query->result();
    }

    public function getRemeberMe()
    {
        $this->db->select('customerNumber,customerName,contactLastName,contactFirstName,phone,addressLine1,addressLine2,city,postalCode,country,creditLimit,email,password,remember_me_token');
        $this->db->from('customers');
        $where = "remember_me_token is  NOT NULL";
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function deleteRememberMe($customerNumber)
    {
        //$this->db->set('remember_me_token' , null);

        $data = array('remember_me_token' => NULL);
        //$this->db->where('customerNumber', $customerNumber);
        //$this->db->update('customers');
        $this->db->update('customers', $data, 'customerNumber = ' . $customerNumber . ' ');
        $query = $this->db->get();


        return $query->result();
    }

    public function getAdmin($username)
    {
        $this->db->select('adminNumber');
        $this->db->select('password');
        $this->db->from('admin');
        $this->db->where('username', $username);
        $query = $this->db->get();

        //returns admins email and password
        return $query->result_array();
    }

    public function createAccount($values)
    {
        if ($this->db->insert('customers', $values))
            return true;

        else
            return false;
    }

    public function if_ID_Exists($customerNumber)
    {
        $this->db->select('customerNumber');
        $this->db->from('customers');
        $this->db->where('customerNumber', $customerNumber);
        $query = $this->db->get();

        if (count($query->result_array()) > 0)
            return true;

        else
            return false;
    }


    public function GetUserByCredentials($custEmail, $custPassword)
    {
        $custPassword= hash($this->passwordhash, $custPassword);
        $query = $this->db->get_where('customer', array("custEmail" => $custEmail, "custPassword" => $custPassword));
        return $query->num_rows() == 0 ? null : $query->result()[0];
        
    }
    private $passwordhash= 'sha256';
}
