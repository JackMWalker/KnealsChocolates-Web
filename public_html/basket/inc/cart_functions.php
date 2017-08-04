<?php
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');
require_once (SERVER_ROOT.'inc/track_visit.php');

/**	Add a product to the users cart
 */
function add_to_cart($pid, $slct){
	$user_id = track_visit(); 
	$db_cart = EShopDB::inst();

	$query_array['user_id'] = $user_id;
	$query_array['product_id'] = $pid;
	$query_array['quantity'] = 1;
	$query_array['selection'] = $slct;

	$db_cart -> insert('cart_current', $query_array);
	$db_cart -> insert('cart_master', $query_array);
}

/**	Check if the given product is in the cart
 */
function check_product_in_cart($pid, $cid = false, $selection = false){
	$user_id = track_visit(); 
	$db_cart = EShopDB::inst();

	//if using cart id
	if($cid)
	{
		$query = "SELECT * FROM cart_current WHERE id = ?";
		$result = $db_cart -> query($query, $cid);

		if($result->rowCount() > 0)
		{
			while($row = $result->fetch(PDO::FETCH_ASSOC)) 
			{
				return $row['id']; // if it is in the cart return the cart id as specified.
			}
		}
		else 
		{
			return false; // not in cart for some reason
		}
	}
	else // if using pid 
	{
		if($selection) // if using pic and selection
		{
			$query = "SELECT * FROM cart_current WHERE user_id = ? AND product_id = ? AND selection = ?";
			$result = $db_cart -> query($query, $user_id, $pid, $selection);
			if($result->rowCount() > 0)
			{
				while($row = $result->fetch(PDO::FETCH_ASSOC)) 
				{
					return $row['id']; //return cartid of if exact product with matching selection is already in cart 
				}
			}
			else
			{
				return false; 
			}
		}
		else
		{
			$query = "SELECT * FROM cart_current WHERE user_id = ? AND product_id = ?";
			$result = $db_cart -> query($query, $user_id, $pid);
			
			if($result->rowCount() > 0)
			{
				while($row = $result->fetch(PDO::FETCH_ASSOC)) 
				{
					return $row['id'];
				}
			}
			else
			{
				return false;
			}
		}
	}
}

/** Check if the users cart is empty
*/

function isEmpty(){
	return count_items() == 0;
}

/**	Count the number of products currently in this users cart
 */
function count_items(){
	$user_id = track_visit(); 
	$db_cart = EShopDB::inst();

	$query = "SELECT quantity FROM cart_current WHERE user_id = ?";
	$result = $db_cart -> query($query, $user_id);
	$count = 0;	
	if($result->rowCount() > 0){
	 	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	 		$count += $row['quantity'];
	 	}
	}
	return $count;
}
 
/**	Update the current cart
 */
function update_cart($cid, $qty){
	$user_id = track_visit(); 
	$db_cart = EShopDB::inst();

	$query = "SELECT quantity FROM cart_current WHERE user_id = ? AND id = ?";
	$result = $db_cart -> query($query, $user_id, $cid);

	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$qnty = $row['quantity'];
	}
	$qnty += $qty;
	if($qnty < 0){
		$qnty = 0;
	}
	$update_query = "UPDATE cart_current SET quantity = ? WHERE user_id = ? AND id = ?";
	$update_query_master = "UPDATE cart_master SET quantity = ? WHERE user_id = ? AND id = ?";
	$update_result = $db_cart -> query($update_query, $qnty, $user_id, $cid);
	$update_result_master = $db_cart -> query($update_query_master, $qnty, $user_id, $cid);
	//update quantity
}

/**	Remove the given item from the cart
 */
function delete_item($pid, $cid){
	$user_id = track_visit(); 
	$db_cart = EShopDB::inst();

	$query = "DELETE FROM cart_current WHERE user_id = ? AND id = ?";
	$update_query_master = "UPDATE cart_master SET item_status = ? WHERE user_id = ? AND id = ?";
	$result = $db_cart -> query($query, $user_id, $cid);
	$result_master = $db_cart -> query($update_query_master, 2, $user_id, $cid);
}

function delete_cart(){
	$user_id = track_visit(); 
	$db_cart = EShopDB::inst();

	$query = "DELETE FROM cart_current WHERE user_id = ?";
	$update_query_master = "UPDATE cart_master SET item_status = ? WHERE user_id = ?";
	$result = $db_cart -> query($query, $user_id);
	$result_master = $db_cart -> query($update_query_master, 2, $user_id);
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