<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php';

if(isset($_POST['id']) && isset($_POST['live']))
{
	$this_product = new Product($_POST['id']);
	$live = $this_product->toggle_live();
	
	echo json_encode(array(
	    "live" => "{$live}"
	));
}