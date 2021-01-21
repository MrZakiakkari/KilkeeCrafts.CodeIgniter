<?php

class AdminRepository extends CI_Model
{

    public function __construct()
    {
        $this->load->model("schema/KilkeekraftsSchema");
        $this->load->model("schema/AdminSchema");

    }

    public function createPasswordHash($plainTextPassword)
    {
        return hash($this->AdminSchema->Password_Hash, $plainTextPassword);
    }
  

    public function GetAdminByCredentials($name, $Password)
    {
        $Password = $this->createPasswordHash($Password);
        $query = $this->db->get_where('admin', array("AdminName" => $name, "Password" => $Password));
        return $query->num_rows() == 0 ? null : $query->result()[0];
    }
}
