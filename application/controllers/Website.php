<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller {

	public function error403()
	{
		$this->load->view("403.php");
	}
}
