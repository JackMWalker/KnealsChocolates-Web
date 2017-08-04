<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/basket/inc/cart_functions.php';

//add item to cart
if(isset($_POST['pid']) && isset($_POST['qty']))
{
	$pid = $_POST['pid'];
	$qty = $_POST['qty'];
	if(isset($_POST['slct']))
		$selection = $_POST['slct'];
	else
		$selection = false;
}

if(isset($pid)){
	$item_id = check_product_in_cart($pid, false, $selection);
	if($item_id)
		update_cart($item_id, $qty); //$qty is how many to add on to what is already in the cart
	else
		add_to_cart($pid, $selection); //adds one to the cart
}

$count = count_items();

echo json_encode(array(
    "count" => "{$count}"
));

?>