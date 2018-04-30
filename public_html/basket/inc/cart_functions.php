<?php
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');
require_once (SERVER_ROOT.'inc/track_visit.php');

/**	Add a product to the users cart
 */
function add_to_cart($pId, $quantity, $selection = null){
	$userId = track_visit();
	$url = BASE_API_URL.'/users/'.$userId.'/basket_items';

    $data = [
        'quantity' => $quantity,
        'productId' => $pId,
        'selections' => $selection
    ];


    APIService::callAPI("POST", $url, $data);
}


/**
 * Check if the users cart is empty
 */

function isEmpty(){
	return count_items() == 0;
}

/**
 * Count the number of products currently in this users cart
 */
function count_items(){
	$userId = track_visit();
    $url = BASE_API_URL.'/users/'.$userId.'/basket_items/count';

    $result = APIService::callAPI("GET", $url);
    $jsonResult = json_decode($result);

    if(!isset($jsonResult->data))
        return 0;
    else
        return $jsonResult->data;
}
 
/**
 * Update the current cart
 */
function update_quantity($cartID, $quantity){
    $userId = track_visit();
    $url = BASE_API_URL.'/users/'.$userId.'/basket_items/'.$cartID;

    $data = [
        'quantity' => $quantity
    ];

    APIService::callAPI("POST", $url, $data);

}

/**	Remove the given item from the cart
 */
function delete_item($cartID){
    $userId = track_visit();
    $url = BASE_API_URL.'/users/'.$userId.'/basket_items/'.$cartID;

    $data = [
        'status' => "REMOVED",
    ];

    APIService::callAPI("POST", $url, $data);

}

function setBasketPurchased(){
    $userId = track_visit();
    $url = BASE_API_URL.'/users/'.$userId.'/basket_items/purchase';

    APIService::callAPI("POST", $url);
}

//Format choc title 
function format_choc_title($title)
{
	$temptitle = rtrim($title, " 100g");
	$temptitle = str_replace('Dark', 'D', $temptitle );
	$temptitle = str_replace('Milk', 'M', $temptitle );

	return $temptitle;
}

?>