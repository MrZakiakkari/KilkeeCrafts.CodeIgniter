<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ProductController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ProductServices');
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

	//hello
	/* public function listproducts() 
	  {	$data['product_info']=$this->ProductServices->get_all_products();
	  $this->load->view('productListView',$data);
	  } */
	public function listproducts()
	{ //config options for pagination
		$paginationConfig = array(
			'base_url' => site_url('ProductController/listproducts/'),
			'total_rows' => $this->ProductServices->record_count(),
			'per_page' => 2
		);
		$this->pagination->initialize($paginationConfig);
		$data['product_info'] = $this->ProductServices->get_all_product(2, $this->uri->segment(3));
		$this->load->view('productListView', $data);
	}
	public function customerListView() 
	{	$config['base_url']=site_url('ProductController/croductListView/');
		$config['total_rows']=$this->ProductServices->record_count_c();
		$config['per_page']=15;
		$this->pagination->initialize($config);
		$data['customer_info']=$this->ProductServices->get_all_customers(15,$this->uri->segment(3));
		$this->load->view('customerListView',$data);
	}
	public function editproduct($productId)
	{
		$data = array("product" => $this->ProductServices->getProductByCode($productId));
		$this->load->view('updateproductView', $data);
	}

	public function viewproduct($productId)
	{
		$data = array('product' => $this->ProductServices->getProductByCode($productId));
		$this->load->view('productView', $data);
	}

	public function deleteproduct($productId)
	{
		$deletedRows = $this->ProductServices->deleteProductById($productId);
		if ($deletedRows > 0)
			$data['message'] = "$deletedRows product has been deleted";
		else
			$data['message'] = "There was an error deleting the product with an ID of $productId";
		$this->load->view('displayMessageView', $data);
	}

	public function updateproduct($productId)
	{
		$pathToFile = $this->uploadAndResizeFile();
		$this->createThumbnail($pathToFile);

		//set validation rules
		$this->form_validation->set_rules('Id', 'Product Code', 'required');
		$this->form_validation->set_rules('prodDescription', 'Description', 'required');
		$this->form_validation->set_rules('prodCategory', 'Category', 'required');
		$this->form_validation->set_rules('prodArtist', 'Artist', 'required');
		$this->form_validation->set_rules('prodQtyInStock', 'Product in stock', 'required');
		$this->form_validation->set_rules('prodBuyCost', 'Cost', 'required');
		$this->form_validation->set_rules('prodSalePrice', 'Sale Price', 'required');
		$this->form_validation->set_rules('priceAlreadyDiscounted', 'Discount', 'required');

		$product = array(
			"Id" => $this->input->post('Id'),
			"prodDescription" => $this->input->post('prodDescription'),
			"prodCategory" => $this->input->post('prodCategory'),
			"prodArtist" => $this->input->post('prodArtist'),
			"prodQtyInStock" => $this->input->post('prodQtyInStock'),
			"prodBuyCost" => $this->input->post('prodBuyCost'),
			"prodSalePrice" => $this->input->post('prodSalePrice'),
			"priceAlreadyDiscounted" => $this->input->post('priceAlreadyDiscounted'),
			"prodPhoto" => $_FILES['userfile']['name']
		);

		var_dump($product);


		//check if the form has passed validation
		if (!$this->form_validation->run()) {
			//validation has failed, load the form again
			$this->load->view('updateproductView', array("product" => $product));
			return;
		}


		$productUpdated = $this->ProductServices->updateProduct($product);
		//check if update is successful
		if ($productUpdated) {
			redirect('ProductController/listproducts');
		} else {
			$data['message'] = "Uh oh ... problem on update";
			$data['product'] = $product;
			$this->load->view('updateproductView', $data);
		}
	}

	function uploadAndResizeFile()
	{ //set config options for thumbnail creation 
		$config['upload_path'] = './assets/images/products/full/';
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
			$this->form_validation->set_rules('Id', 'Product Code', 'required');
			$this->form_validation->set_rules('prodDescription', 'Description', 'required');
			$this->form_validation->set_rules('prodCategory', 'Category', 'required');
			$this->form_validation->set_rules('prodArtist', 'Artist', 'required');
			$this->form_validation->set_rules('prodQtyInStock', 'Product in stock', 'required');
			$this->form_validation->set_rules('prodBuyCost', 'Cost', 'required');
			$this->form_validation->set_rules('prodSalePrice', 'Sale Price', 'required');
			$this->form_validation->set_rules('priceAlreadyDiscounted', 'Discount', 'required');

			//get values from post
			$product['Id'] = $this->input->post('Id');
			$product['prodDescription'] = $this->input->post('prodDescription');
			$product['prodCategory'] = $this->input->post('prodCategory');
			$product['prodArtist'] = $this->input->post('prodArtist');
			$product['prodQtyInStock'] = $this->input->post('prodQtyInStock');
			$product['prodBuyCost'] = $this->input->post('prodBuyCost');
			$product['prodSalePrice'] = $this->input->post('prodSalePrice');
			$product['priceAlreadyDiscounted'] = $this->input->post('priceAlreadyDiscounted');
			$product['prodPhoto'] = $_FILES['userfile']['name'];

			//check if the form has passed validation
			if (!$this->form_validation->run()) {
				//validation has failed, load the form again – keeping all the data in place
				//and pass the appropriate validation error messages via the 
				//form_validation library
				$this->load->view('insertproductView', $product);
				return;
			}

			//check if insert is successful
			if ($this->ProductServices->addProduct($product)) {
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
		$product['Id'] = "";
		$product['prodDescription'] = "";
		$product['prodCategory'] = "";
		$product['prodArtist'] = "";
		$product['prodQtyInStock'] = "";
		$product['prodBuyCost'] = "";
		$product['prodSalePrice'] = "";
		$product['priceAlreadyDiscounted'] = "";

		//load the form
		$this->load->view('insertproductView', $product);
	}
 public function adminOrders()
    {
		
        if($this->input->post('orderNumber'))
        {
			$config['total_rows']=$this->ProductServices->record_count_Order();
			$config['per_page']=15;
			$this->pagination->initialize($config);
            
			$orderNumber = $this->input->post('orderNumber');
            $data['requiredDate'] = $this->input->post('requiredDate');
            $data['shippedDate'] = $this->input->post('shippedDate');
            $data['status'] = $this->input->post('status');
            $data['comments'] = $this->input->post('comments');
			
			//$data['product_info']=$this->ProductServices->update_order($orderNumber, $data,15,$this->uri->segment(3);
            $this->ProductServices->update_order($orderNumber, $data);
        }  

        $data = $this->ProductServices->get_orders();
        $this->load->view('AdminOrders', array('data' => $data));
    }

    public function orders()
    {
        if($this->input->post('orderNumber'))
        {
            $orderNumber = $this->input->post('orderNumber');
            $data['requiredDate'] = $this->input->post('requiredDate');
            $data['shippedDate'] = $this->input->post('shippedDate');
            $data['status'] = $this->input->post('status');
            $data['comments'] = $this->input->post('comments');

            $this->ProductServices->update_order($orderNumber, $data);
        }  

        $data = $this->ProductServices->get_orders_by_customer($this->session->userdata('customerNumber'));
        $this->load->view('orders', array('data' => $data));
        
    }

    public function delete_order()
    {
        $this->ProductServices->delete_order($_GET['orderNumber']);
        $this->ProductServices->delete_order_details($_GET['orderNumber']);
        redirect('ProductController/adminOrders');
    }

    public function cancel_order()
    { 
		$this->ProductServices->delete_order_details($_GET['orderNumber']);
        $this->ProductServices->delete_order($_GET['orderNumber']);
       
        redirect('ProductController/orders');
    }

    public function OrderDetails($orderNumber)
    {
		
		$order = $this->input->post('order');
		$config['base_url']=site_url('index.php/ProductController/OrderDetails');
		$data['product_info']=$this->ProductServices->get_order_details($orderNumber);
		$this->load->view('OrderDetails', $data);
		
 
    }
	
	public function AllOrderDetails()
    {
		
		$config['base_url']=site_url('index.php/ProductController/AdminAllOrderDetails');
		$data['product_info']=$this->ProductServices->get_all_order_details();
		$this->load->view('AdminAllOrderDetails', $data);
		
 
    }
    public function update_order_details()
    {
        if($this->input->post('orderNumber'))
        {
			$data = $this->ProductServices->get_order_details($this->input->post('orderNumber'));
			
            $data = $this->ProductServices->update_order_details($this->input->post('orderNumber'), $this->input->post('productCode'), $this->input->post('quantity_ordered'));

            

            $this->load->view('admin_order_details',  array('data' => $data));
        }  
    }
	public function SearchProducts()
	{
				
		$search = $this->input->post('searchInput');
		$config['base_url']=site_url('index.php/ProductController/SearchProducts');
		$data['product_info']=$this->ProductServices->SearchAllProducts($search );
		
		
		$this->load->view('ProductViews/SearchView', $data);
			
	}
	
	public function SearchOrders()
	{
				
		$search = $this->input->post('searchOrderInput');
		$config['base_url']=site_url('index.php/ProductController/SearchOrders');
		$data['product_info']=$this->ProductServices->SearchAllOrders($search );
		
		
		$this->load->view('ProductViews/SearchOrderView', $data);
			
	}
	
   	public function ProductWishlist()
    {
        $customerNumber = $this->session->userdata('customerNumber');
        $product_list = $this->ProductServices->get_products_wishlist($customerNumber);
        $data = null;


        for($i=0; $i<count($product_list); $i++)
        {
            $produceCode = $product_list[$i]['produceCode'];

            $product_info = $this->ProductServices->getProductId($produceCode);
            $photo = '<img src="' . base_url() . 'assets/images/products/thumbs/' . $product_info[0]['photo'] . '" alt="' . $product_info[0]['photo'] .'"';

            $data[$i] = array('produceCode' => $product_info[0]['produceCode'], 'description' => $product_info[0]['description'],'bulkBuyPrice' => $product_info[0]['bulkBuyPrice'], 'bulkSalePrice' => $product_info[0]['bulkSalePrice'], 'photo' => $photo);

        }

              
        $this->load->view('wishlist', array('data' => $data));
        

    }

    public function addToWishlist()
    {
        $customerNumber = $this->session->userdata('customerNumber');
        $produceCode = $_GET['produceCode'];
       
        $this->ProductServices->addToWishlist($customerNumber, $produceCode);

        redirect(base_url('index.php/ProductController/viewProduct/' . $produceCode));
        
    }
	
	public function removeFromWishlist()
    {
        $customerNumber = $this->session->userdata('customerNumber');
        $produceCode = $_GET['produceCode'];

        $this->ProductServices->removeFromWishlist($customerNumber, $produceCode);
		redirect(base_url('index.php/ProductController/viewProduct/' . $produceCode));
    }

    public function removeFromMainWishlist()
    {
        $customerNumber = $this->session->userdata('customerNumber');
        $produceCode = $_GET['produceCode'];

        $this->ProductServices->removeFromWishlist($customerNumber, $produceCode);
		redirect(base_url('index.php/ProductController/ProductWishlist'));
    }
	
	public function emptyWishlist()
	{
		$customerNumber = $this->session->userdata('customerNumber');
		$this->ProductServices->emptyWishlist($customerNumber);
        redirect(ProductController);
		
	}
	
	public function product_by_id() 
    {   
        $produceCode = $_GET['produceCode'];
        $data['products'] = $this->productModel->getProductId($produceCode);
              
        foreach($data['products'] as &$row)
        {
            $img=$row['image'];
            $row['image'] = '<img src="' . base_url() . 'assets/images/products/' . $img . '" alt="' . $img .'"';
            //$row['msrp'] = '€' . $row['msrp']; 
        }

        $this->load->view('header');        
        $this->load->view('product', $data);
        $this->load->view('footer'); 
    }

	public function cart()
	{
		$this->load->view('CartView');
	}
	
	public function emptyCart()
	{
		$this->cart->destroy();
		redirect('ProductController/Cart');
	}
	
    public function addToCart()
    {
        $product = $this->ProductServices->getProductId($_GET['produceCode']);
		$produceCode = $_GET['produceCode'];
        $photo = '<img src="' . base_url() . 'assets/images/products/thumbs/' . $product[0]['photo'] . '" alt="' . $product[0]['photo'] .'">';

        $data = array(
            'id'      => $product[0]['produceCode'],
            'qty'     => 1,
			'price'   => 39.95,
            'name' => $product[0]['description'],
            'photo'   => $photo
        );

        $this->cart->insert($data);
        redirect(base_url('index.php/ProductController/viewProduct/'.$produceCode));
    }
	
	public function addToCartFromWishlist()
    {
        $product = $this->ProductServices->getProductId($_GET['produceCode']);
        $photo = '<img src="' . base_url() . 'assets/images/products/thumbs/' . $product[0]['photo'] . '" alt="' . $product[0]['photo'] .'">';

        $data = array(
            'id'      => $product[0]['produceCode'],
            'qty'     => 1,
			'price'   => 39.95,
            'name' => $product[0]['description'],
            'photo'   => $photo
        );

        $this->cart->insert($data);
       redirect(base_url('index.php/ProductController/ProductWishlist'));
    }

    public function removeFromCart()
    {
        $data = array(
            'rowid'  => $_GET['rowid'],
            'qty' => 0
        );

        $this->cart->update($data);
        redirect(base_url('index.php/ProductController/Cart'));
    }

    public function cartQuantity()
    {
        $rowid = $this->input->post("rowid");
        $quantity = $this->input->post("quantity");

        $data = array(
            'rowid'  => $rowid,
            'qty' => $quantity
        );

        $this->cart->update($data);
      
        $this->load->view('CartView');
    }

    public function cartOrder()
    {
        $this->load->view('OrderView');
        
    }

    public function order_quantity()
    {
        $rowid = $this->input->post("rowid");
        $quantity = $this->input->post("quantity");

        $data = array(
            'rowid'  => $rowid,
            'qty' => $quantity
        );

        $this->cart->update($data);
     
        $this->load->view('OrderView');
    }

    public function remove_from_order()
    {
        $data = array(
            'rowid'  => $_GET['rowid'],
            'qty' => 0
        );

        $this->cart->update($data);
        $this->load->view('order');
    }

    public function checkout()
    {
        $orderDate = 
        $required_date = "0000-00-00";
        $orderNumber = null;
        $loop = true;

        while($loop == true)
        {
            $orderNumber = mt_rand(1000,9999);

            if(!$this->ProductServices->if_order_exists($orderNumber))
            {
                $loop = false;
            }
        }

        $data = array(
            'orderNumber' => $orderNumber,
            'orderDate' => date('Y-m-d'),
            'requiredDate' => "0000-00-00",
            'status' => "In Process",
            'customerNumber' => $this->session->userdata('customerNumber')
        );

        if($this->ProductServices->create_order($data))
        {
            foreach ($this->cart->contents() as $item)
            {
                $data = array(
                    'orderNumber' => $orderNumber,
                    'productCode' => $item['id'],
                    'quantityOrdered' => $item['qty'],
                    'priceEach' => $item['price']
                );
                
                $this->ProductServices->create_order_details($data);
            }        

            $this->cart->destroy();
			
            
			$this->load->view('OrderSuccessful');
            echo '<br><a href="' . base_url() .'">Return To Homepage</a>'; 
        }

        else
        {
            echo "Error Creating order";
            echo '<br><a href="' . base_url() .'">Return To Homepage</a>'; 
        }

    }
	
}
