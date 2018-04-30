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

$url = BASE_API_URL.'/transactions/paypal?payment_id='.$pmt_id;

$results = APIService::callAPI('GET', $url);

$jsonResults = json_decode($results);
$transaction = $jsonResults->data;

$line1 = $transaction->address_line1;
@$line2 = $transaction->address_line2;
$city = $transaction->city;
$postage = $transaction->transaction->postage;
$postal_code = $transaction->postal_code;
$payer_email = $transaction->email;
$price = $transaction->price;
$txn_id = $transaction->transaction->id;
$basketItems = $transaction->transaction->basket_items;

$product_title_array = array();
$product_price_array = array();
$quantities = array();

foreach ($basketItems as $basketItem)
{
    $temp_title = $basketItem->product->name;

    if(sizeof($basketItem->selections) > 0)
    {
        $temp_title .= '<span style="font-size:12px;"> - ';

        foreach ($basketItem->selections as $selection)
        {
            $substr = format_choc_title($selection->preview_item->name);
            $temp_title .= $substr.', ';
        }
        $temp_title = rtrim($temp_title, ', ');

        $temp_title .= '</span>';
    }

    array_push($product_title_array, $temp_title);
    array_push($product_price_array, $basketItem->product->price);
    array_push($quantities, $basketItem->quantity);
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
				<div class="col-12 col-sm-9 offset-sm-1">
					<h4 class="legal-title">Thank you for your purchase.</h4>
					<p class='smaller-txt'>Kneals Reference Number: <?php echo $txn_id; ?></p>
					<table class="view-table w-100">
						<tr>
							<th>Product</th>
                            <th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
						</tr>

						<?php
							for($i = 0; $i < count($product_title_array); $i++){
								print "<tr><td>{$product_title_array[$i]}</td>
                                       <td>".view_price($product_price_array[$i])."</td>
									   <td>{$quantities[$i]}</td>
									   <td>".view_price($quantities[$i]*$product_price_array[$i]).'</td></tr>';
							}
						?>
                        <tr class="total-row">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><b>Subtotal</b></td>
                            <td><b><?php print view_price($price-$postage); ?></b></td>
                        </tr>
						<tr class="total-row">
							<td>&nbsp;</td>
                            <td>&nbsp;</td>
							<td><b>Delivery</b></td>
							<td><b><?php print view_price($postage); ?></b></td>
						</tr>

						<tr class="total-row">
							<td>&nbsp;</td>
                            <td>&nbsp;</td>
							<td><b>Total</b></td>
							<td><?php print "<b>".view_price($price)."</b>"; ?></td>
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