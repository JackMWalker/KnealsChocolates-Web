<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/basket/inc/cart_functions.php';

//add item to cart
if(isset($_POST['pid']) && isset($_POST['qty']))
{
	$pId = (string)$_POST['pid'];
	$quantity = (string)$_POST['qty'];

	$selection = isset($_POST['slct']) ? explode(',', $_POST['slct']) : null;

    add_to_cart($pId, $quantity, $selection);
}

$count = count_items();

echo json_encode(array(
    "count" => "{$count}"
));

?>