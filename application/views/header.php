<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->helper('url'); 
	$cssbase = base_url()."assets/css/";
	$jsbase = base_url()."assets/javascript/";
	$img_base = base_url()."assets/images/";
	$base = base_url() . index_page();
?>

<!DOCTYPE>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Books</title>
<link href="<?php echo $cssbase . "style.css"?>" rel="stylesheet" type="text/css" media="all" />
<script src="<?php echo $jsbase."common.js"?>"></script>
</head>

<body>
<header>
	<img class="center-image" src="<?php echo $img_base . "site/Logo.png"?>" />
    <?= anchor('AdminController/index', 'Home', 'title="Home"'); ?>
	&nbsp;&nbsp;&nbsp;
	<?= anchor('AdminController/handleInsert', 'Insert', 'title="Insert"'); ?>
    &nbsp;&nbsp;&nbsp;
	<?= anchor('AdminController/listproducts/', 'List', 'title="List"'); ?>
	&nbsp;&nbsp;&nbsp;
	<?= anchor('PublisherController/listPublishers', 'List Publishers', 'title="List Publishers"'); ?>
	<?= anchor('CustomerController/handleInsert', 'Insert Customer', 'title="Insert Customer"'); ?>
    &nbsp;&nbsp;&nbsp;
	<?= anchor('CustomerController/listCustomers', 'List Customer', 'title="List Customer"'); ?>
</header>
