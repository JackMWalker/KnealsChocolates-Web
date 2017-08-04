<?php
/****************************************************************************/
/* Displays the cart table and the buttons - called by different AJAX calls */
/****************************************************************************/

require_once dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/inc/display_price.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/basket/inc/cart_functions.php';

/**********************************************************/
/* Get variables and set up for the rest of the functions */
/**********************************************************/
$ccID = array();
$id = array();
$name = array();
$price = array();
$quantity = array();
$selection =  array();
$transids = array();
$postage = array();

$user_id = track_visit(); 
$db_cart = EShopDB::inst(); 

// if they are deleting item from cart
if(isset($_POST['productID']) && isset($_POST['cartID']))
{
	$productID = $_POST['productID'];
	$cartID = $_POST['cartID'];
	if(check_product_in_cart($productID, $cartID))
	{
		delete_item($productID, $cartID); 
	}
}

@$pID = $_POST['pid'];
@$cID = $_POST['cid'];
@$qnty = $_POST['qty'];

if((isset($pID) || isset($cID)) && isset($_POST['qty'])) // checks if they are trying to update the cart (ajax call has been made).
{ 

	if(isset($_POST['visible']))
	{ // this is used to change the visibility of the update(quantity) button.
		$visible = $_POST['visible']; //$_POST['visible'] is an array sent from the ajax call already
		$visible[$cID] = "no"; 	// this simply turns the update button with the product id of where it came from to "no"
	}
	if(isset($_POST['quantArr']))
	{ // if user has tried to change two quantities at once, after they've updated one the other will remain where they left it until they update that one.
		$quantarr = $_POST['quantArr']; //this is an array of all of the quantities in the cart sent by the form
	}

	if(isset($pID))
	{
		$cID = check_product_in_cart($pID);
	}
	if($cID && $qnty != 0)
	{
		update_cart($cID, $qnty); //$qnty is how many to add on to what is already in the cart
	}
	else if($qnty != 0 && isset($pID))
	{
		add_to_cart($pID); //adds one to the cart
	}
	else if($qnty == 0 && $cID)//if the qnty is put to 0 or blank and then 'updated' 
	{ 
		update_cart($cID, $qnty);
	}
}

$count = count_items();
$count_string = ($count == 1) ? $count . ' item' : $count . ' items';

/**********************************************************/
/* Start displaying the table in which the cart items sit */
/**********************************************************/
$table = '	<div id="cart-table" class="col-xs-10 col-xs-offset-1"><table class="cart-list">
				<tr class="table-header">
				    <th>Product Name</th>
				    <th>Quantity</th> 
				    <th>Price</th>
				</tr>
			';

$total_price = 0;
$shipping = 0;
$full_post = false;

if(!isEmpty())
{	
	$show_paypal = true;
	$category = 'luxury';
	$query = "SELECT cart_current.id as ccID, products.id as pID, cart_current.selection, products.title, products.price, cart_current.quantity, products.postage_cost FROM cart_current INNER JOIN products ON cart_current.product_id=products.id WHERE user_id = ?";
	$result = $db_cart -> query($query, $user_id);
	if($result->rowCount() > 0)
	{
		while($row = $result->fetch(PDO::FETCH_ASSOC)) 
		{
			array_push($ccID, $row['ccID']);
	 		array_push($id, $row['pID']);
	 		array_push($name, $row['title']);
	 		array_push($price, $row['price']);
	 		array_push($quantity, $row['quantity']);
	 		array_push($selection, $row['selection']);
	 		array_push($postage, $row['postage_cost']);
	 		if($row['selection'] != '')
	 		{	
	 			$transid = "{$row['pID']}:{$row['selection']}";
	 		}
	 		else
	 		{
	 			$transid = $row['pID'];
	 		}

	 		array_push($transids, $transid);
	 	}
	}

	for($i = 0; $i < count($id); $i++)
	{
		$quant = $quantity[$i];

		if(isset($visible))
			$is_visible = $visible[$ccID[$i]];
		else
			$is_visible = "no";
		
		if(isset($quantarr))
			$quant = $quantarr[$ccID[$i]];
		else
			$quant = $quant;
		
		$chocs_string = '';

		if($selection[$i] != '')
		{
			$chocs_string .= '- ';
			$chocIDs = explode(',', $selection[$i]);
			foreach ($chocIDs as $chocID) 
			{
				$query2 = "SELECT title FROM individual_chocs WHERE id = ?";
				$result2 = $db_cart -> query($query2, $chocID);
				if($result2->rowCount() > 0)
				{
					while($row2 = $result2->fetch(PDO::FETCH_ASSOC))
					{
						$substr = format_choc_title($row2['title']);
						$chocs_string .= $substr.', ';
					}

				}
			}
			
			$chocs_string = rtrim($chocs_string, ', ');

		}

		$table .= " <tr class='itemrows'>
						<td class='row'>
							<div class='title-section'>
								<div class='img-cont col-xs-2'>
									<img alt='{$name[$i]}' class='img-responsive thumb' src='/images/chocolates/{$category}/{$id[$i]}.png'>
								</div>
								<div class='visible-xs-block clearfix'></div>
								<div class='title-cont col-xs-12 col-sm-10'>
									<a class='standard-link' href='/shop/product.php?id={$id[$i]}'><p><input type='hidden' name='product_name[]' value='{$name[$i]}'>{$name[$i]} <span class='tiny-txt'>{$chocs_string}</span></p></a>
									<span class='remove-cart-item'><input type='submit' data-removeproductid='{$id[$i]}' data-cartid='{$ccID[$i]}' name='remove-item' value='Remove'/><input type='hidden' name='transids[]' value='{$transids[$i]}'><input type='hidden' name='ids[]' value='{$id[$i]}'></span>
									<div class='clearfix'></div>
								</div>
								
							</div>
						</td>
						<td>
							<input class='cart-qty-input' type='number' data-qtycartid='{$ccID[$i]}' data-qtyproductid='{$id[$i]}' data-origqty='{$quantity[$i]}' name='quantity[]' min='1' max='500' value ='{$quant}'>
							<span class='enter-number-warning' style='display:none;'>Enter a number</span>
							<input type='submit' data-visible='{$is_visible}' data-updatecartid='{$ccID[$i]}' data-updateproductid='{$id[$i]}' name='update-qty' value='Update'/>
						</td>
						<td>
							<input type='hidden' name='price[]' value='{$price[$i]}'>".format_price($price[$i])."
						</td>
					</tr>";
					$total_price += $price[$i]*$quant;

		// work out dynamic postage
		if($postage[$i] < 199) 
		{
			while($quant > 0)
			{
				if($quant == 1)
				{
					$shipping += $postage[$i];
					$quant--;
				}
				else
				{
					$shipping += 199;
					$quant -= 2;
				}
			}
		}
		else
		{
			if(!$full_post && $postage[$i] > 199)
			{
				$shipping += $postage[$i];
				$quant--;
				$shipping += 199 * $quant;

				$full_post = true;
			}
			else
			{
				$shipping += 199 * $quant;
			}
		}
	}
	$subtotal = $total_price;
	$total_price += $shipping;

	$table .= '<tr class="payrow"><td class="subrow">&nbsp;</td><td class="subrow">Subtotal</td><td class="subrow">'.format_price($subtotal).'</td></tr>';
	$table .= '<tr class="payrow"><td>&nbsp;</th><td>Delivery<br><a href="/post_packaging/" class="tiny-link">(P&P Terms)</a></td><td>'.format_price($shipping).'</td></tr>';
	$table .= '<tr class="payrow"><td class="totrow">&nbsp;</td><td class="totrow">Total <br>('.$count_string.')</td><td class="totrow">'.format_price($total_price).'</td></tr>';

}
else
{
	$table .= '<tr><td>There are no chocolates in this basket, what are you waiting for? <a class="traditional-link" href="/shop/">Shop Now</a></td>&nbsp;<td></td><td>&nbsp;</td></tr>';
	$show_paypal = false;
}

$table .= '</table></div>';

if($show_paypal)
{
	$paypal = '<input class="paypal-button" type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" name="submit" alt="Submit Form" 			align="left" style="margin-right:40px;">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="kneals-info@knealschocolates.com">
			<input type="hidden" name="total_quantity" value="'.$count.'">
			<input type="hidden" name="basket_name" value="Kneals Basket">
			<input type="hidden" id="basket_total" name="total" value="'.$total_price.'">
			<input type="hidden" name="shipping" value="'.$shipping.'">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="user_id" value="'.$user_id.'">
			';
}
else
{
	$paypal = '';
}

echo json_encode(array(
    "count" => "{$count}",
    "table" => "{$table}",
    "paypal" => "{$paypal}"
));

?>