<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Wishlist extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('WishlistRepository');
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
public function listwishlists()
	{ //config options for pagination
		$paginationConfig = array(
			'base_url' => site_url('Wishlist/listwishlist/'),
			'total_rows' => $this->WishlistRepository->getArtistCount(),
			'per_page' => 2
		);
		$this->pagination->initialize($paginationConfig);
		$data['wishlists'] = $this->WishlistRepository->getWishlist();//(2, $this->uri->segment(3));
		$this->load->view('wishlistListView', $data);
	}
 
	public function editwishlist($CustomerId)
	{
		$data = array("wishlist" => $this->WishlistRepository->getWishlistByCustomerId($CustomerId));
		$this->load->view('updatewishlistView', $data);
	}

	public function viewwishlist($CustomerId)
	{
		$data = array('wishlist' => $this->WishlistRepository->getWishlistByCustomerId($CustomerId));
		$this->load->view('wishlistView', $data);
	}

	public function deletewishlist($CustomerId)
	{
		$deletedRows = $this->WishlistRepository->deleteWishlistByCustomerId($CustomerId);
		if ($deletedRows > 0)
			$data['message'] = "$deletedRows wishlist has been deleted";
		else
			$data['message'] = "There was an error deleting the wishlist with an ID of $CustomerId";
		$this->load->view('displayMessageView', $data);
	}

	public function updatewishlist($CustomerId)
	{
		$pathToFile = $this->uploadAndResizeFile();
		$this->createThumbnail($pathToFile);

		//set validation rules
		$this->form_validation->set_rules('CustomerId', 'CustomerId', 'required');
		$this->form_validation->set_rules('ProductId', 'ProductId', 'required');
		
	
	

		$wishlist = array(
			"CustomerId" => $this->input->post('CustomerId'),
			"ProductId" => $this->input->post('ProductId'),
		
			
		);

		var_dump($wishlist);


		//check if the form has passed validation
		if (!$this->form_validation->run()) {
			//validation has failed, load the form again
			$this->load->view('updatewishlistView', array("wishlist" => $wishlist));
			return;
		}


		$wishlistUpdated = $this->WishlistRepository->updateWishlist($wishlist);
		//check if update is successful
		if ($wishlistUpdated) {
			redirect('Wishlist/listwishlist');
		} else {
			$data['message'] = "Uh oh ... problem on update";
			$data['wishlist'] = $wishlist;
			$this->load->view('updatewishlistView', $data);
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
			$this->form_validation->set_rules('CustomerId', 'CustomerId', 'required');
			$this->form_validation->set_rules('ProductId', 'ProductId', 'required');
		
	

			//get values from post
			$wishlist['CustomerId'] = $this->input->post('CustomerId');
			$wishlist['ProductId'] = $this->input->post('ProductId');
		

			//check if the form has passed validation
			if (!$this->form_validation->run()) {
				//validation has failed, load the form again – keeping all the data in place
				//and pass the appropriate validation error messages via the 
				//form_validation library
				$this->load->view('insertwishlistView', $wishlist);
				return;
			}

			//check if insert is successful
			if ($this->WishlistRepository->addWishlist($wishlist)) {
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
		$wishlist['CustomerId'] = "";
		$wishlist['ProductId'] = "";
	
	

		//load the form
		$this->load->view('insertwishlistView', $wishlist);
	}


	}