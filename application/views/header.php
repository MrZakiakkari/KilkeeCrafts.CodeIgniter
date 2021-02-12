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
				if (isset($this->session->userdata["username"])) {
					$username = $this->session->userdata["username"];
					echo "You are logged in as " . $username;
				} else {
					echo "Please login ";
				}
				echo '<div id="search">';
				?>
			</form>
		</div>
		<div class="col-3">
			<!-- Login -->
			<div class="ShoppingBasket">
				<?php
				if ($this->session->userdata('CustomerId') != null) { ?>
					<?= anchor('Products/', 'Product Search', 'title="Product Search"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Products/listproducts/', 'Products', 'title="Products"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Artists/', 'Artist Search', 'title="Artist Search"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Artists/listartists/', 'Artists', 'title="Artists"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('WishItems/', 'Wishlist', 'title="Wishlist"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('ShoppingCart/', 'Cart', 'title="Shopping Cart"'); ?>
					&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;
					<?= anchor('User/controlPanel/', '<span>' . $this->session->userdata('username') . '</span>', 'title="Control Panel"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('User/logout_user/', 'Logout', 'title="Logout"'); ?>
				<?Php } else if ($this->session->userdata('AdminId') != null) { ?>
					<?= anchor('Products/index', 'Product Search', 'title="Product Search"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Products/handleInsert', 'Insert Product', 'title="Insert"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Products/listproducts/', 'Products', 'title="Products"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Artists/index', 'Artist Search', 'title="Artist Search"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Artists/handleInsert', 'Insert Artist', 'title="Insert"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Artists/listartists/', 'Artists', 'title="Artists"'); ?>
					&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Orders/listorders/', 'Orders', 'title="Orders"'); ?>
					&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Admin/controlPanel/', '<span>' . $this->session->userdata('username') . '</span>', 'title="Control Panel"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Admin/logout_user/', 'Logout', 'title="Logout"'); ?>
					&nbsp;&nbsp;&nbsp;
				<?php } else { ?>
					<?= anchor('Products/listproducts/', 'Products', 'title="Products"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Products/index', 'Product Search', 'title="Product Search"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Artists/listartists/', 'Artists', 'title="Artists"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Artists/index', 'Artist Search', 'title="Artist Search"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('ShoppingCart/', 'Cart', 'title="Shopping Cart"'); ?>
					&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;
					<?= anchor('User/login/', 'Login', 'title="Login"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('Admin/login/', 'Admin', 'title="Admin Login"'); ?>
					&nbsp;&nbsp;&nbsp;
					<?= anchor('User/register/', 'Register', 'title="Register"'); ?>
					&nbsp;&nbsp;&nbsp;
				<?php }
				?>
			</div>
			<br>
		</div>
	</header>