<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/";
?>
   
		
<!--Main container for page content-->  
<div class="container" > 
	<div class="main">
		<br><br>
		<h3>Admin Control Panel</h3>
		<br><br>
                    <div class="row">
					
						<!--Left Hand Side (LHS) content panel--> 
                        <div class="col-md-12 ">
                                <div class="panel ">
                                    <?php
										echo '<a href="' . base_url("index.php/ProductController/handleInsert") . '">Add Product</a>';
										echo "<br>";
										echo '<a href="' . base_url("index.php/ProductController/ProductListView") . '">View Products:  '. $this->db->count_all('products') .'</a>';
										echo "<br>";
										echo '<a href="' . base_url("index.php/ProductController/customerListView") . '">View Customers : '. $this->db->count_all('customers') .'</a>';
										echo "<br>";
										echo '<a href="' . base_url("index.php/ProductController/adminOrders") . '">View All Orders : '. $this->db->count_all('orders') .'</a>';
										echo "<br>";
										echo '<a href="' . base_url("index.php/ProductController/AllOrderDetails") . '">View All Order Details : '. $this->db->count_all('orderdetails') .'</a>';
										echo "<br>";
										echo '<a href="' . base_url("index.php/ProductController/visitorLog") . '">View Visitor Logs Total : '. $this->db->count_all('loggedIn') .'</a>';
										echo "<br><br>";
										?>
										<br><br><br><br><br><br><br>
                                </div>
                        </div>
       
                    </div>

   </div>
</div>
       
	
<?php
	$this->load->view('footer'); 
?>