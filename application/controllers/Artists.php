<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Artists extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ArtistRepository');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}

	public function index()
	{
		//load the index page
		$this->load->view('index');
}
public function listartists()
	{ //config options for pagination
		$paginationConfig = array(
			'base_url' => site_url('Artists/listartists/'),
			'total_rows' => $this->ArtistRepository->getArtistCount(),
			'per_page' => 2
		);
		$this->pagination->initialize($paginationConfig);
		$data['artists'] = $this->ArtistRepository->getArtists();//(2, $this->uri->segment(3));
		$this->load->view('artistListView', $data);
	}
 
	public function editartist($Id)
	{
		$data = array("artist" => $this->ArtistRepository->getArtistById($Id));
		$this->load->view('updateartistView', $data);
	}

	public function viewartist($Id)
	{
		$data = array('artist' => $this->ArtistRepository->getArtistById($Id));
		$this->load->view('artistView', $data);
	}

	public function deleteartist($Id)
	{
		$deletedRows = $this->ArtistRepository->deleteArtistsById($Id);
		if ($deletedRows > 0)
			$data['message'] = "$deletedRows artist has been deleted";
		else
			$data['message'] = "There was an error deleting the artist with an ID of $Id";
		$this->load->view('displayMessageView', $data);
	}

	public function updateartist($Id)
	{
		$pathToFile = $this->uploadAndResizeFile();
		$this->createThumbnail($pathToFile);

		//set validation rules
		$this->form_validation->set_rules('Id', 'Artists Code', 'required');
		$this->form_validation->set_rules('BusinessName', 'BusinessName', 'required');
		$this->form_validation->set_rules('Address', 'Address', 'required');
		$this->form_validation->set_rules('Contact', 'Contact', 'required');
		$this->form_validation->set_rules('Phone', 'Phone in stock', 'required');
	
	

		$artist = array(
			"Id" => $this->input->post('Id'),
			"Description" => $this->input->post('BusinessName'),
			"Category" => $this->input->post('Address'),
			"Artist" => $this->input->post('Contact'),
			"QtyInStock" => $this->input->post('Phone'),
		"Photo" => $_FILES['userfile']['name']
		);

		var_dump($artist);


		//check if the form has passed validation
		if (!$this->form_validation->run()) {
			//validation has failed, load the form again
			$this->load->view('updateartistView', array("artist" => $artist));
			return;
		}


		$artistUpdated = $this->ArtistRepository->updateArtists($artist);
		//check if update is successful
		if ($artistUpdated) {
			redirect('Artists/listartists');
		} else {
			$data['message'] = "Uh oh ... problem on update";
			$data['artist'] = $artist;
			$this->load->view('updateartistView', $data);
		}
	}

	function uploadAndResizeFile()
	{ //set config options for thumbnail creation 
		$config['upload_path'] = './assets/images/artists/full/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload())
			echo $this->upload->display_errors();
		else
			echo 'upload done<br>';

		$upload_data = $this->upload->data();
		$path = $upload_data['full_path'];

		$config['source_image'] = $path;
		$config['maintain_ratio'] = 'FALSE';
		$config['width'] = '180';
		$config['height'] = '200';

		$this->load->library('image_lib', $config);
		if (!$this->image_lib->resize())
			echo $this->image_lib->display_errors();
		else
			echo 'image resized<br>';
		$this->image_lib->clear();
		return $path;
	}

	function createThumbnail($path)
	{ //set config options for thumbnail creation 
		$config['source_image'] = $path;
		$config['new_image'] = './assets/images/products/thumbs/';
		$config['maintain_ratio'] = 'FALSE';
		$config['width'] = '42';
		$config['height'] = '42';

		//load library to do the resizing and thumbnail creation 
		$this->image_lib->initialize($config);

		//call function resize in the image library to physiclly create the thumbnail 
		if (!$this->image_lib->resize())
			echo $this->image_lib->display_errors();
		else
			echo 'thumbnail created<br>';
	}

	public function handleInsert()
	{
		//if the user has submitted the form
		if ($this->input->post('submitInsert')) {

			$pathToFile = $this->uploadAndResizeFile();
			$this->createThumbnail($pathToFile);

			//set validation rules
			$this->form_validation->set_rules('Id', 'Artists Code', 'required');
			$this->form_validation->set_rules('BusinessName', 'BusinessName', 'required');
			$this->form_validation->set_rules('Address', 'Address', 'required');
			$this->form_validation->set_rules('Contact', 'Contact', 'required');
			$this->form_validation->set_rules('Phone', 'Phone', 'required');
	

			//get values from post
			$artist['Id'] = $this->input->post('Id');
			$artist['BusinessName'] = $this->input->post('BusinessName');
			$artist['Address'] = $this->input->post('Address');
			$artist['Contact'] = $this->input->post('Contact');
			$artist['Phone'] = $this->input->post('Phone');
			$artist['Photo'] = $_FILES['userfile']['name'];

			//check if the form has passed validation
			if (!$this->form_validation->run()) {
				//validation has failed, load the form again – keeping all the data in place
				//and pass the appropriate validation error messages via the 
				//form_validation library
				$this->load->view('insertartistView', $artist);
				return;
			}

			//check if insert is successful
			if ($this->ArtistRepository->addArtists($artist)) {
				$data['message'] = "The insert has been successful";
			} else {
				$data['message'] = "Uh oh ... problem on insert";
			}

			//load the view to display the message
			$this->load->view('displayMessageView', $data);
			return;
		}

		//the user has not submitted the form
		//initialize the form fields
		$artist['Id'] = "";
		$artist['BusinessName'] = "";
		$artist['Address'] = "";
		$artist['Contact'] = "";
		$artist['Phone'] = "";
		
	

		//load the form
		$this->load->view('insertartistView', $artist);
	}


	}