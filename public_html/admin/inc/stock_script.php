<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php';

if(isset($_POST['id']) && isset($_POST['change']))
{
	$this_product = new Product($_POST['id']);
	$new_stock = $this_product->change_stock($_POST['change']);
	
	echo json_encode(array(
	    "stock" => "{$new_stock}"
	));
}