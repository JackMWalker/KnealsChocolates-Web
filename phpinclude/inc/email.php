<?php
if(ServerManager::isLive()) {
    $toCustomer = $query_array['payer_email'];
    $toBusiness = 'kneals-info@knealschocolates.com';
} else {
    $toBusiness = 'admin@knealschocolates.com';
    $toCustomer = $toBusiness; 
}

$subjectCustomer = 'Kneals Chocolates Order Confirmation';
$subjectBusiness = 'Kneals PayPal Confirmation'; 

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: do-not-reply@knealschocolates.com" . "\r\n";

$busEmail = "<html>
<head>
<title>Kneals Chocolates Payment Confirmation</title>
</head>
<body style='width:700px; margin:10px auto; font-family:helvetica;'>
<header style='width:100%; height:60px; line-height:60px;'>
<h2>PayPal Payment Confirmation:</h2>
</header>
<table style='width:100%; border:1px solid #333;'>
<tr style='border-bottom:1px solid #333;'>
    <th style='padding:10px 2px; width:33%;'>Product</th>
    <th style='padding:10px 2px; width:33%;'>Quantity</th>
    <th style='padding:10px 2px; width:33%;'>Total</th>
</tr>";

$custEmail = "<html>
<head>
<title>Kneals Chocolates Order Confirmation</title>
</head>
<body style='width:700px; margin:10px auto; font-family:helvetica'>
<header style='width:100%; height:120px; line-height:120px;'><img width=68 height=120 src='http://www.knealschocolates.com/images/housestyle/logo404.gif'><img width=250 height=55 src='http://www.knealschocolates.com/images/housestyle/title404.gif' style='margin-bottom: 27px; margin-left: 15px;'></header>
<h2>Thank you for your purchase of:</h2>
<p style='margin-bottom:0px;'>PayPal Transaction ID: {$paymentId}</p>
<table style='width:100%; border:1px solid #333;'>
<tr style='border-bottom:1px solid #333;'>
    <th style='padding:10px 2px;'>Product</th>
    <th style='padding:10px 2px;'>Quantity</th>
    <th style='padding:10px 2px;'>Total</th>
</tr>";

$query = "SELECT product_id_list, quantity_list, postage FROM cart_transactions WHERE uniqid = ?";
$result = $db_cart -> query($query, $unid);

while($row = $result->fetch(PDO::FETCH_ASSOC)) 
{
	$product_ids_list = $row['product_id_list'];
	$quantity_list = $row['quantity_list'];
    $postage = format_price($row['postage'] * 100);
}

$product_ids = explode(';', $product_ids_list);
$quantities = explode(';', $quantity_list);

$i = 0;

foreach ($product_ids as $product_id) 
{
    $extra_deets = false;
    
    if(strpos($product_id, ':') !== false)
    {
        $product_id_parts = explode(':', $product_id);
        $product_id = $product_id_parts[0];
        $choc_id_string = $product_id_parts[1];
        $extra_deets = true;
    }
   
	$query = "SELECT title, price FROM products WHERE id = ?";
	$result = $db_cart -> query($query, $product_id);

	while($row = $result->fetch(PDO::FETCH_ASSOC)) 
    {
        $temp_title = $row['title'];
        if($extra_deets)
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

		$total_row_price = $row['price'] * $quantities[$i];
		$price_f = format_price($total_row_price);
		$custEmail .= "<tr><td style='padding:10px 2px;'>{$temp_title}</td><td style='padding:10px 2px; text-align:center; '>{$quantities[$i]}</td><td style='padding:10px 2px;'>{$price_f}</td></tr>";
		$busEmail .= "<tr><td style='padding:10px 2px;'>{$temp_title}</td><td style='padding:10px 2px; text-align:center; '>{$quantities[$i]}</td><td style='padding:10px 2px; text-align:center;'>{$price_f}</td></tr>";
	}

	$i++;
}


$busEmail .= "<tr>
    <td style='padding:10px 2px;'>&nbsp;</td>
    <td style='padding:10px 2px; text-align:right;'><b>Delivery</b></td>
    <td style='padding:10px 2px; text-align:center;'>{$postage}</td>
</tr>

<tr>
    <td style='padding:10px 2px;'>&nbsp;</td>
    <td style='padding:10px 2px; text-align:right;'><b>Total</b></td>
    <td style='padding:10px 2px; text-align:center;'><b>&pound;{$query_array['price']}</b></td>
</tr>

</table>  
<br>
<hr>
<br>";

$custEmail .= "<tr>
    <td style='padding:10px 2px;'>&nbsp;</td>
    <td style='padding:10px 2px; text-align:right;'><b>Delivery</b></td>
    <td style='padding:10px 2px;'><b>{$postage}</b></td>
</tr>

<tr>
    <td style='padding:10px 2px;'>&nbsp;</td>
    <td style='padding:10px 2px; text-align:right;'><b>Total</b></td>
    <td style='padding:10px 2px;'><b>&pound;{$query_array['price']}</b></td>
</tr>

</table>
<p>We will send your order out within 5 working days to: </p>";

$address_f = makeAddress($line1, $line2, $city, $postal_code, true);
$custEmail .= "<p>{$address_f}</p>";
$busEmail .= "<p>{$address_f}</p>";

$custEmail .= "<p>If this isn't the correct delivery address, please contact Kneals at <a href='mailto:kneals-info@knealschocolates.com'>kneals-info@knealschocolates.com</a> stating your kneals reference number below and your up-to-date delivery address.</p><br>
    
<p>We'd love to know what you think of your chocolates on <a class='follow-button' target='_blank' href='https://facebook.com/KnealsChocolates' ><img alt='facebook' width='25px' height='25px' src='http://knealschocolates.com/images/housestyle/facebook.png'/></a> or <a class='follow-button' target='_blank' href='https://twitter.com/knealschocolate' ><img alt='twitter' width='25px' height='25px' src='http://knealschocolates.com/images/housestyle/twitter.png'/></a></p><br>
<p style='margin-bottom:2px;'>We hope you enjoy!</p>
<p style='margin-top:2px; font-size:0.9em; font-family:cursive;'>Kneals Chocolates</p>
<p style='font-family:helvetica;'><i><a href='mailto:kneals-info@knealschocolates.com'>kneals-info@knealschocolates.com</a><br>Phone: 0121 771 2990</i></p>

<p>Kneals Reference Number: {$query_array['transaction_id']}</p>

</body>
</html>";

$busEmail .= "<br>
<hr>
<br>
<p style='margin-bottom:0px;'>PayPal Transaction ID: {$paymentId}</p>
<p>Kneals Reference Number: {$query_array['transaction_id']} </p>

</body>
</html>";

mail($toCustomer, $subjectCustomer, $custEmail, $headers);
mail($toBusiness, $subjectBusiness, $busEmail, $headers);