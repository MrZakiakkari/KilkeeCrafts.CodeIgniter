<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminController extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('AdminModel');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}

	public function index() {
		//load the index page
		$this->load->view('index');
	}
		//hello
	/*public function listproducts() 
	{	$data['product_info']=$this->AdminModel->get_all_products();
		$this->load->view('productListView',$data);
	}*/
	public function listproducts() 
	{	//config options for pagination
		$config['base_url']=site_url('AdminController/listproducts/');
		$config['total_rows']=$this->AdminModel->record_count();
		$config['per_page']=2;
		$this->pagination->initialize($config);
		$data['product_info']=$this->AdminModel->get_all_products(2, $this->uri->segment(3));
		$this->load->view('productListView',$data);
	}
	
	public function editproduct($productcode)
	{	$data['edit_data']=$this->AdminModel->drilldown($productcode);
		$this->load->view('updateproductView',$data);
	}

	public function viewproduct($productcode)
	{	$data['view_data']=$this->AdminModel->drilldown($productcode);
		$this->load->view('productView',$data);
	}

	public function deleteproduct($productcode)
	{	$deletedRows = $this->AdminModel->deleteAdminModel($productcode);
		if ($deletedRows >0)
			$data['message']="$deletedRows product has been deleted";
		else
			$data['message']="There was an error deleting the product with an ID of $productcode";
		$this->load->view('displayMessageView',$data);
	}
    public function updateproduct($productcode)
    {	$pathToFile = $this->uploadAndResizeFile();
		$this->createThumbnail($pathToFile);

		//set validation rules
		$this->form_validation->set_rules('productcode', 'product ID', 'required');
		$this->form_validation->set_rules('firstName', 'First Name', 'required');
		$this->form_validation->set_rules('lastName', 'Last Name', 'required');	
		$this->form_validation->set_rules('yearBorn', 'Year Born', 'required');
	
		//get values from post
		$productcode = $this->input->post('productcode');
		$anproduct['firstName'] = $this->input->post('firstName');
		$anproduct['lastName'] = $this->input->post('lastName');
		$anproduct['yearBorn'] = $this->input->post('yearBorn');
		$anproduct['image'] = $_FILES['userfile']['name'];

		//check if the form has passed validation
		if (!$this->form_validation->run()){
			//validation has failed, load the form again
			$this->load->view('updateproductView', $anproduct);
			return;
		}

		
		//check if update is successful
		if ($this->AdminModel->updateAdminModel($anproduct, $productcode)) {
			redirect('AdminController/listproducts');
		}
		else {
			$data['message']="Uh oh ... problem on update";
		}
    }

	function uploadAndResizeFile() 
	{ //set config options for thumbnail creation 
		$config['upload_path']='./assets/images/products/full/'; 
		$config['allowed_types']='gif|jpg|png'; 
		$config['max_size']='100'; 
		$config['max_width']='1024'; 
		$config['max_height']='768';
		
		$this->load->library('upload',$config); 
		if (!$this->upload->do_upload()) 
			echo $this->upload->display_errors(); 
		else 
			echo 'upload done<br>'; 
		
		$upload_data = $this->upload->data(); 
		$path = $upload_data['full_path']; 
		
		$config['source_image']=$path; 
		$config['maintain_ratio']='FALSE'; 
		$config['width']='180'; 
		$config['height']='200'; 
		
		$this->load->library('image_lib',$config); 
		if (!$this->image_lib->resize()) 
			echo $this->image_lib->display_errors(); 
		else 
			echo 'image resized<br>'; 
		$this->image_lib->clear(); 
		return $path; 
	}
	
	function createThumbnail($path) 
	{ //set config options for thumbnail creation 
		$config['source_image']=$path; 
		$config['new_image']='./assets/images/products/thumbs/'; 
		$config['maintain_ratio']='FALSE'; 
		$config['width']='42'; 
		$config['height']='42'; 
		
		//load library to do the resizing and thumbnail creation 
		$this->image_lib->initialize($config); 
		
		//call function resize in the image library to physiclly create the thumbnail 
		if (!$this->image_lib->resize()) 
			echo $this->image_lib->display_errors(); 
		else 
			echo 'thumbnail created<br>'; }
	
	public function handleInsert(){
		//if the user has submitted the form
		if ($this->input->post('submitInsert')){
			
			$pathToFile = $this->uploadAndResizeFile(); 
			$this->createThumbnail($pathToFile);
			
			//set validation rules
			$this->form_validation->set_rules('productcode', 'product ID', 'required');
			$this->form_validation->set_rules('firstName', 'First Name', 'required');
			$this->form_validation->set_rules('lastName', 'Last Name', 'required');	
			$this->form_validation->set_rules('yearBorn', 'Year Born', 'required');
			
			//get values from post
			$anproduct['productcode'] = $this->input->post('productcode');
			$anproduct['firstName'] = $this->input->post('firstName');
			$anproduct['lastName'] = $this->input->post('lastName');
			$anproduct['yearBorn'] = $this->input->post('yearBorn');
			$anproduct['image'] = $_FILES['userfile']['name'];
			
			//check if the form has passed validation
			if (!$this->form_validation->run()){
				//validation has failed, load the form again – keeping all the data in place
				//and pass the appropriate validation error messages via the 
				//form_validation library
				$this->load->view('insertproductView', $anproduct);
				return;
			}

			//check if insert is successful
			if ($this->AdminModel->insertAdminModel($anproduct)) {
				$data['message']="The insert has been successful";
			}
			else {
				$data['message']="Uh oh ... problem on insert";
			}
			
			//load the view to display the message
			$this->load->view('displayMessageView', $data);
			return;
		}

		//the user has not submitted the form
		//initialize the form fields
		$anproduct['productcode'] = "";
		$anproduct['firstName'] = "";
		$anproduct['lastName'] = "";
		$anproduct['yearBorn'] = "";

		//load the form
		$this->load->view('insertproductView', $anproduct);
	}
}
