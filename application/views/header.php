<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('url');
$cssbase = base_url() . "assets/css/";
$jsbase = base_url() . "assets/javascript/";
$img_base = base_url() . "assets/images/";
$base = base_url() . index_page();
?>

<!DOCTYPE>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Books</title>
	<link href="<?php echo $cssbase . "style.css" ?>" rel="stylesheet" type="text/css" media="all" />
	<script src="<?php echo $jsbase . "common.js" ?>"></script>
</head>

<body>
	<header>
		<img class="center-image" src="<?php echo $img_base . "site/Logo.png" ?>" />
		<div class="col-5">
			<form class="navbar-form">
				<!-- Search -->
				<?php
				echo '<div id="search">';


				?>
		</div>
		</form>

		</div>


		<div class="col-3">
			<!-- Login -->

			<div class="ShoppingBasket">
				<?php

				if ($this->session->userdata('customerNumber')) {

					//wishlist Size Query	
					$this->db->select('produceCode');
					$this->db->from('wishlist');
					$this->db->where('customerNumber', $this->session->userdata('customerNumber'));
					$query = $this->db->get();
					$wishlist_size = count($query->result_array());


					if ($wishlist_size != 0)
						//Wislist
						echo '<a href="' . base_url("index.php/ProductController/ProductWishlist")  . '"><img class = "wislistIcon" src=" ' . $img_base . 'site/wishlist_icon3.png"/><span class = "wishlistIconNumber">(' . $wishlist_size . ')</span></a>';

					if ($this->cart->total_items() != 0)
						//Cart
						echo '<a href="' . base_url("index.php/ProductController/Cart")  . '"><img class = "wislistIcon" src=" ' . $img_base . 'site/cart_icon.png"/><span>(' . $this->cart->total_items() . ')</span></a>';

					//Orders
					echo '<a href="' . base_url("index.php/ProductController/orders")  . '"><span>Orders</span></a>';
					//Logout
					echo '<a href="' . base_url("index.php/UserController/logout_user")  . '"><span>Logout</span></a>';
				}
				//Admin
				else if ($this->session->userdata('adminNumber')) {
					//Control Panel
					echo '<a href="' . base_url("index.php/UserController/controlPanel") . '"><span>' . $this->session->userdata('username') . '</span></a>';
					//Admin logout
					echo '<a href="' . base_url("index.php/UserController/logout_user")  . '"><span>Logout</span></a>';
					//echo '<div id="'
				} else {
					//Login
					echo '<div id="header_login">';
					echo '<a href="' . base_url() . "index.php/UserController/login" . '">Login/Create Account</a><br>';
					echo '</div>';
				}

				?>
			</div>
			<br>
		</div>


		<?= anchor('ProductController/index', 'Home', 'title="Home"'); ?>
		&nbsp;&nbsp;&nbsp;
		<?= anchor('ProductController/handleInsert', 'Insert', 'title="Insert"'); ?>
		&nbsp;&nbsp;&nbsp;
		<?= anchor('ProductController/listproducts/', 'List', 'title="List"'); ?>
		&nbsp;&nbsp;&nbsp;

	</header>