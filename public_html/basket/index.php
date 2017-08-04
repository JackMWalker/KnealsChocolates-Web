<?php 
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');
require_once (SERVER_ROOT.'inc/track_visit.php'); 
?>
<!DOCTYPE html>
<html lang="en-us">

<head>	
	<title>Kneals Chocolates - Basket</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="Keywords" content="Kneals, Chocolates, Handmade, Luxury, Confectionery, Wedding, Favours, Gifts">
	<meta name="Description" content="Kneals Chocolates is all about quality, locally produced handmade chocolates. We are constantly aiming to create new and interesting flavours for you to taste. Our traditional methods and craftsmanship enable us to provide you with a unique tasting experience every time.">

	<?php include SERVER_ROOT.'inc/meta.html' ; ?>
</head>
<body onload="loadCart()">
<?php 
$user_id = track_visit();
$page_name = 'cart';

include SERVER_ROOT.'inc/header.php'; 
?>

	<div class="container"> 
		<div class="cart-section row standard-row">
			<form class="form" action="/rtn/paypal_setup.php" method="POST">
				<section id="update-form"> 

				</section>
				<section id="payment_form">

				</section>
			</form>
		</div>
	</div> <!-- End of container -->	
<?php include SERVER_ROOT.'inc/footer.php'; ?>