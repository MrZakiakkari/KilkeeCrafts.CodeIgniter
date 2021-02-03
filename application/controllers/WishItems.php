<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class WishItems extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('WishItemRepository');
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}

	public function add($productId)
	{
		$customerId = $this->session->userdata("CustomerId");

		$wishitem = $this->WishItemRepository->getWishItemByKey($customerId, $productId);

		if($wishitem!=null)
		{
			//TODO Alert Already exists
			redirect('WishItems/');
		}

		$wishItemValuesArray = array(
			"CustomerId" => $customerId,
			"ProductId" => $productId,
		);


		$wishitemIsAdded = $this->WishItemRepository->addWishItem($wishItemValuesArray);

		if ($wishitemIsAdded) {
			redirect('WishItems/');
		} else {
			//TODO : Check and refactor
			$data['message'] = "Uh oh ... problem on update";
			$this->load->view('updatewishitemView', $data);
		}
	}
	public function index()
	{
		$paginationConfig = array(
			'base_url' => site_url('WishItems/index/'),
			'total_rows' => $this->WishItemRepository->getWishItemCount(),
			'per_page' => 2
		);
		$customerId = $this->session->userdata("CustomerId");
		$this->pagination->initialize($paginationConfig);
		//(2, $this->uri->segment(3));

		$vars = array(
			'wishItems' => $this->WishItemRepository->getWishItemsByCustomerId($customerId)
		);
		$this->load->view('wishitemListView', $vars);
	}

	public function editwishitem($CustomerId)
	{
		$data = array("wishitem" => $this->WishItemRepository->getWishlistByCustomerId($CustomerId));
		$this->load->view('updatewishitemView', $data);
	}

	public function viewwishitem($CustomerId)
	{
		$data = array('wishitem' => $this->WishItemRepository->getWishlistByCustomerId($CustomerId));
		$this->load->view('wishitemView', $data);
	}

	public function deletewishitem($CustomerId)
	{
		$deletedRows = $this->WishItemRepository->deleteWishItemByKey($CustomerId);
		if ($deletedRows > 0)
			$data['message'] = "$deletedRows wishitem has been deleted";
		else
			$data['message'] = "There was an error deleting the wishitem with an ID of $CustomerId";
		$this->load->view('displayMessageView', $data);
	}

	public function updatewishitem($CustomerId)
	{
		$pathToFile = $this->uploadAndResizeFile();
		$this->createThumbnail($pathToFile);

		//set validation rules
		$this->form_validation->set_rules('CustomerId', 'CustomerId', 'required');
		$this->form_validation->set_rules('ProductId', 'ProductId', 'required');




		$wishitem = array(
			"CustomerId" => $this->input->post('CustomerId'),
			"ProductId" => $this->input->post('ProductId'),


		);

		var_dump($wishitem);


		//check if the form has passed validation
		if (!$this->form_validation->run()) {
			//validation has failed, load the form again
			$this->load->view('updatewishitemView', array("wishitem" => $wishitem));
			return;
		}


		$wishitemUpdated = $this->WishItemRepository->updateWishlist($wishitem);
		//check if update is successful
		if ($wishitemUpdated) {
			redirect('WishItems/listwishitem');
		} else {
			$data['message'] = "Uh oh ... problem on update";
			$data['wishitem'] = $wishitem;
			$this->load->view('updatewishitemView', $data);
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
			$wishitem['CustomerId'] = $this->input->post('CustomerId');
			$wishitem['ProductId'] = $this->input->post('ProductId');


			//check if the form has passed validation
			if (!$this->form_validation->run()) {
				//validation has failed, load the form again – keeping all the data in place
				//and pass the appropriate validation error messages via the 
				//form_validation library
				$this->load->view('insertwishitemView', $wishitem);
				return;
			}

			//check if insert is successful
			if ($this->WishItemRepository->addWishlist($wishitem)) {
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
		$wishitem['CustomerId'] = "";
		$wishitem['ProductId'] = "";



		//load the form
		$this->load->view('insertwishitemView', $wishitem);
	}
}
