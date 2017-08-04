<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php';

if(isset($_POST['id']) && isset($_POST['priority_change']))
{
	$this_product = new Product($_POST['id']);
	
	$this_product->priority_change($_POST['priority_change']);
	$browse_products = new BrowseProducts() ;
	$browse_products->show_list();
}
