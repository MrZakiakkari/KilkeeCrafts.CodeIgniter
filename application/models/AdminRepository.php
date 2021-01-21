<?php

class UserRepository extends CI_Model
{

    public function __construct()
    {
        $this->load->model("schema/KilkeekraftsSchema");
        $this->load->model("schema/AdminSchema");

    }


  

    public function GetAdminByCredentials($name, $Password)
    {
        $Password = $this->createPasswordHash($Password);
        $query = $this->db->get_where('admin', array("AdminName" => $name, "Password" => $Password));
        return $query->num_rows() == 0 ? null : $query->result()[0];
    }
}
