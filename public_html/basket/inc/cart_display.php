<?php
/****************************************************************************/
/* Displays the cart table and the buttons - called by different AJAX calls */
/****************************************************************************/

require_once dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/inc/standard_functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/basket/inc/cart_functions.php';

/**********************************************************/
/* Get variables and set up for the rest of the functions */
/**********************************************************/

$user_id = track_visit(); 

// if they are deleting item from cart
if(isset($_POST['productID']) && isset($_POST['cartID']))
{
	delete_item($_POST['cartID']);
}

@$pID = $_POST['pid'];
@$cID = $_POST['cid'];
@$qnty = $_POST['qty'];

if((isset($pID) || isset($cID)) && isset($qnty)) // checks if they are trying to update the cart (ajax call has been made).
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

	if($qnty != 0)
	{
        update_quantity($cID, $qnty); //$qnty is how many to add on to what is already in the cart
	} else {
	    // delete if the quantity is 0
	    delete_item($cID);
    }
}

$count = count_items();
$count_string = ($count == 1) ? $count . ' item' : $count . ' items';

/**********************************************************/
/* Start displaying the table in which the cart items sit */
/**********************************************************/
$table =  '	<div id="cart-table"><table class="cart-list">';
$table .= '		<tr class="table-header">';
$table .= '		    <th>Product Name</th>';
$table .= '		    <th>Quantity</th>';
$table .= '		    <th>Price</th>';
$table .= '		</tr> ';

$total_price = 0;
$shipping = 0;
$full_post = false;

if($count > 0)
{	
	$show_paypal = true;

    $url = BASE_API_URL.'/users/'.$user_id.'/basket_items';

    $result = APIService::callAPI("GET", $url);
    $jsonResult = json_decode($result);
    $basketItems = $jsonResult->data;

    if(sizeof($basketItems) > 0)
	{
        foreach($basketItems as $item)
		{
            $selectionString = '';
            // Set the selection string if it is available
            if(sizeof($item->selections) > 0)
            {
                $selectionString .= '- ';
                foreach ($item->selections as $selection)
                {
                    $selectionString .= $selection->amount .'x '. $selection->preview_item->name.', ';
                }

                $selectionString = rtrim($selectionString, ', ');
            }

            // Check if the update buttons are meant to be visible
            if(isset($visible))
                $is_visible = $visible[$item->id];
            else
                $is_visible = "no";

            //
            if(isset($quantarr))
                $quant = $quantarr[$item->id];
            else
                $quant = $item->quantity;

            $table .= "<tr class='itemrows'>";
            $table .= "    <td class='row'>";
            $table .= "         <div class='img-cont col-2'>";
            $table .= "             <img alt='{$item->product->name}' width='100' class='img-responsive thumb' src='/images/uploads/products/".$item->product->images[0]->image_name."'>";
            $table .= "			 </div>";
            $table .= "    	    <div class='visible-xs-block clearfix'></div>";
            $table .= "    		<div class='title-cont col-12 col-sm-10'>";

            $table .= "        		<a class='standard-link' href='/shop/product.php?id={$item->product->id}'><p><input type='hidden' name='product_name[]' value='{$item->product->name}'>{$item->product->name} <span class='tiny-txt'>{$selectionString}</span></p></a>";

            $table .= "    		    <span class='remove-cart-item'><input type='submit' data-remove_product_id='{$item->product->id}' data-cart_id='{$item->id}' name='remove-item' value='Remove'/>";

           $table .= "               <input type='hidden' name='basket_ids[]' value='{$item->id}'><input type='hidden' name='ids[]' value='{$item->product->id}'>";

            $table .= "             </span>";
            $table .= "    			<div class='clearfix'></div>";
            $table .= "    	    </div>";

            $table .= "    	</td>";
            $table .= "		<td>";
            $table .= "			<input class='cart-qty-input' type='number' data-qty_cart_id='{$item->id}' data-qty_product_id='{$item->id}' data-orig_qty='{$item->quantity}' name='quantity[]' min='1' max='500' value='{$quant}'>";

            $table .= "			<span class='enter-number-warning' style='display:none;'>Enter a number</span>";
            $table .= "			<input type='submit' data-visible='{$is_visible}' data-update_cart_id='{$item->id}' data-update_product_id='{$item->product->id}' name='update-qty' value='Update'/>";

            $table .= "		</td>";
            $table .= "		<td>";
            $table .= "			<input type='hidden' name='price[]' value='{$item->product->price}'>".view_price($item->product->price);
            $table .= "    	</td>";
            $table .= "	</tr>";


            $total_price += $item->product->price * $quant;

            // work out dynamic postage
            if($item->product->postage_price < 1.99)
            {
                while($quant > 0)
                {
                    if($quant == 1)
                    {
                        $shipping += $item->product->postage_price;
                        $quant--;
                    }
                    else
                    {
                        $shipping += 1.99;
                        $quant -= 2;
                    }
                }
            }
            else {
                if(!$full_post && $item->product->postage_price > 1.99)
                {
                    $shipping += $item->product->postage_price;
                    $quant--;
                    $shipping += 1.99 * $quant;

                    $full_post = true;
                }
                else
                {
                    $shipping += 1.99 * $quant;
                }
            }
	 	}
	}

	$subtotal = $total_price;
	$total_price += $shipping;


	$table .= '<tr class="payrow"><td class="subrow">&nbsp;</td><td class="subrow">Subtotal</td><td class="subrow">'.view_price($subtotal).'</td></tr>';

	$table .= '<tr class="payrow"><td>&nbsp;</th><td>Delivery<br><a href="/post_packaging/" class="tiny-link">(P&P Terms)</a></td><td>'.view_price($shipping).'</td></tr>';

	$table .= '<tr class="payrow"><td class="totrow">&nbsp;</td><td class="totrow">Total <br>('.$count_string.')</td><td class="totrow">'.view_price($total_price).'</td></tr>';

}
else {
	$table .= '<tr><td>There are no chocolates in this basket, what are you waiting for? <a class="traditional-link" href="/shop/">Shop Now</a></td>&nbsp;<td></td><td>&nbsp;</td></tr>';

	$show_paypal = false;
}

$table .= '</table></div>';

$paypal = '';

if($show_paypal)
{
	$paypal .= '<input class="paypal-button" type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" name="submit" alt="Submit Form" 	align="left" style="margin-right:40px;">';
	$paypal .= '<input type="hidden" name="cmd" value="_xclick">';
	$paypal .= '<input type="hidden" name="business" value="kneals-info@knealschocolates.com">';
	$paypal .= '<input type="hidden" name="total_quantity" value="'.$count.'">';
	$paypal .= '<input type="hidden" name="basket_name" value="Kneals Basket">';
	$paypal .= '<input type="hidden" id="basket_total" name="total" value="'.$total_price.'">';
	$paypal .= '<input type="hidden" name="shipping" value="'.$shipping.'">';
	$paypal .= '<input type="hidden" name="no_note" value="1">';
	$paypal .= '<input type="hidden" name="user_id" value="'.$user_id.'">';
}


echo json_encode(array(
    "count" => "{$count}",
    "table" => "{$table}",
    "paypal" => "{$paypal}"
));

?>