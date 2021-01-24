<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('header'); 
	$this->load->helper('url');
	$base = base_url() . index_page();
	$img_base = base_url()."assets/images/products/";
?>
<div class="list">
	<br><br>
	<h1 class="main">List of artists</h1>
	<br><br>
	<table>
		<tr>
			<th align="left" width="100">Id</th>
			<th align="left" width="100">BusinessName</th>
			<th align="left" width="100">Address</th>
			<th align="left" width="100">Contact</th>
			<th align="left" width="100">Phone</th>
			<th align="left" width="100">Photo</th>
		</tr>

		<?php foreach($artist as $artist){?>
		<tr>
			<td><?php echo $row->Id;?></td>
			<td><?php echo $row->BusinessName;?></td>
			<td><?php echo $row->Address;?></td>
			<td><?php echo $row->Contact;?></td>
			<td><?php echo $row->Phone;?></td>
			<td><img src="<?php echo $img_base.'thumbs/'.$row->Photo;?>"></td>
			<td><?php echo anchor('Artists/viewartist/'.$row->Id,'View');?></td>
			<td><?php echo anchor('Artists/editartist/'.$row->Id,'Update');?></td>
			<td><?php echo anchor('Artists/deleteartist/'.$row->Id,
				'Delete', 'onclick="return checkDelete()"');?></td>
		</tr>     
		<?php }?>  
   </table>
   <?php echo $this->pagination->create_links();?>
   <br><br>
</div>
<?php
	$this->load->view('footer'); 
?>