<?php
//view confirmation page
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/basket/inc/cart_functions.php');
@$pmt_id = $_GET['pmt_id'];

if(!$pmt_id)
{
	print "Invalid Page Access.";
	die();
}

$db_cart = EShopDB::inst();

$query = "SELECT paypal_transaction.line1, paypal_transaction.line2, paypal_transaction.city, paypal_transaction.postal_code, paypal_transaction.payer_email, cart_transactions.price, cart_transactions.postage, cart_transactions.id, cart_transactions.product_id_list, cart_transactions.quantity_list FROM cart_transactions LEFT JOIN paypal_transaction ON paypal_transaction.transaction_id=cart_transactions.id WHERE paypal_transaction.payment_id = ?";

$result = $db_cart->query($query, $pmt_id);

while($row = $result->fetch(PDO::FETCH_ASSOC)) 
{
	$line1 = $row['line1'];
	@$line2 = $row['line2'];
	$city = $row['city'];
	$postage = $row['postage']*100;
	$postal_code = $row['postal_code'];
	$payer_email = $row['payer_email'];
	$price = format_view_price($row['price']);
	$txn_id = $row['id'];
	$product_id_list = $row['product_id_list'];
	$quantity_list = $row['quantity_list'];
}

$product_ids = explode(';', $product_id_list);
$quantities = explode(';', $quantity_list);

$product_title_array = array();
$product_description_array = array();
$product_price_array = array();
$product_chocs_array = array();

foreach ($product_ids as $product_id) 
{
	if(strpos($product_id, ':') !== false)
	{
		$product_id_parts = explode(':', $product_id);
		$product_id = $product_id_parts[0];
		$choc_id_string = $product_id_parts[1];
	}

	$query = "SELECT title, price FROM products WHERE id = ?";
	$result = $db_cart -> query($query, $product_id);

	while($row = $result->fetch(PDO::FETCH_ASSOC)) 
	{
		$temp_title = $row['title'];
        if(isset($choc_id_string))
        {
            $temp_title .= '<span style="font-size:12px;"> - ';
            $chocIDs = explode(',', $choc_id_string);
            foreach ($chocIDs as $chocID) 
            {
                $query2 = "SELECT title FROM individual_chocs WHERE id = ?";
                $result2 = $db_cart -> query($query2, $chocID);
                if($result2->rowCount() > 0)
                {
                    while($row2 = $result2->fetch(PDO::FETCH_ASSOC))
                    {
                        $substr = format_choc_title($row2['title']);
                        $temp_title .= $substr.', ';
                    }
                }
            }
            $temp_title = rtrim($temp_title, ', ');
            $temp_title .= '</span>';
        }
		array_push($product_title_array, $temp_title);
		array_push($product_price_array, $row['price']);
	}

}

$address = makeAddress($line1, $line2, $city, $postal_code);
?>
<!DOCTYPE html>
<html lang="en-us">

<head>	
	<title>Kneals Chocolates - Luxury Handmade Chocolates</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="Keywords" content="Kneals, Chocolates, Handmade, Luxury, Confectionery, Wedding, Favours, Gifts">
	<meta name="Description" content="Kneals Chocolates is all about quality, locally produced handmade chocolates. We are constantly aiming to create new and interesting flavours for you to taste. Our traditional methods and craftsmanship enable us to provide you with a unique tasting experience every time.">
	
	<?php include SERVER_ROOT.'inc/meta.html' ; ?>	
</head>
<body>
<?php include SERVER_ROOT.'inc/header.php'; ?>
		<section class="container"> <!-- Start of center -->
			<div class="row standard-row">
				<div class="col-xs-12 col-sm-9 col-sm-offset-1">
					<h4 class="legal-title">Thank you for your purchase.</h4>
					<p class='smaller-txt'>Kneals Reference Number: <?php echo $txn_id; ?></p>
					<table class="view-table">
						<tr>
							<th>Product</th>
							<th>Quantity</th>
							<th>Total</th>
						</tr>

						<?php
							for($i = 0; $i < count($product_title_array); $i++){
								print "<tr><td>{$product_title_array[$i]}</td>
									   <td>{$quantities[$i]}</td>
									   <td>".format_price($quantities[$i]*$product_price_array[$i]).'</td></tr>';
							}
						?>
						<tr class="total-row">
							<td>&nbsp;</td>
							<td><b>Delivery</b></td>
							<td><b><?php print format_price($postage); ?></b></td>
						</tr>

						<tr class="total-row">
							<td>&nbsp;</td>
							<td><b>Total</b></td>
							<td><?php echo "<b>{$price}</b>"; ?></td>
						</tr>

					</table>

					<p>We will dispatch your order within the next 5 working days to this address:</p><br>
					<p class="smaller-txt"><?php echo $address; ?></p><br>
					<p>If this isn't the correct delivery address, please contact Kneals at <a class='standard-link' href='mailto:kneals-info@knealschocolates.com'>kneals-info@knealschocolates.com</a> stating your reference number and your up-to-date delivery address.</p> <br><br><br>

					<p class='smaller-txt'>PayPal Payment Id: <?php echo $pmt_id; ?></p><br><br>
					<p>We'd love to know what you think of your chocolates on <a class="follow-button" target="_blank" href="https://facebook.com/KnealsChocolates" ><img alt="facebook" width="25px" height="25px" src="/images/housestyle/facebook.png"/></a> or <a class="follow-button" target="_blank" href="https://twitter.com/knealschocolate" ><img alt="twitter" width="25px" height="25px" src="/images/housestyle/twitter.png"/></a>.</p>
					<br><br>
				</div>
			</div>
		</section> <!-- End of center side -->	

<?php include SERVER_ROOT.'inc/footer.php'; ?>