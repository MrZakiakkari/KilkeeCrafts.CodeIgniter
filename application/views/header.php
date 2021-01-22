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
		</div>
		</form>

		</div>


		<div class="col-3">
			<!-- Login -->

			<div class="ShoppingBasket">
				<?php

				if ($this->session->userdata('CustomerNumber') != null) {


					echo '<a href="' . base_url('Product/index', 'Home', 'title="Home"')  . '"><span>Home</span></a>';
					echo '<a href="' . base_url('Product/handleInsert', 'Insert', 'title="Insert"')  . '"><span>Inser</span></a>';
					echo '<a href="' . base_url('Product/listproducts/', 'List', 'title="List"')  . '"><span>List</span></a>';

					//Logout
					echo '<a href="' . base_url("index.php/UserController/logout_user")  . '"><span>Logout</span></a>';
				}
				//Admin
				else if ($this->session->userdata('AdminNumber') != null) {
					//Control Panel
					echo '<a href="' . base_url("index.php/Admin/controlPanel") . '"><span>' . $this->session->userdata('AdminName') . '</span></a>';
					echo '<a href="' . base_url('Product/index', 'Home', 'title="Home"')  . '"><span>Home</span></a>';
					echo '<a href="' . base_url('Product/handleInsert', 'Insert', 'title="Insert"')  . '"><span>Inser</span></a>';
					echo '<a href="' . base_url('Product/listproducts/', 'List', 'title="List"')  . '"><span>List</span></a>';
					//Admin logout
					echo '<a href="' . base_url("index.php/Admin/logout_user")  . '"><span>Logout</span></a>';
					//echo '<div id="'
				} else {
					//Login
					echo '<div id="header_login">';
					echo '<a href="' . base_url() . "index.php/User/login" . '">Login<a><br>';
					echo '<a href="' . base_url() . "index.php/Admin/login" . '">Admin</a><br>';
					echo '<a href="' . base_url() . "index.php/User/register" . '">Register</a><br>';

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