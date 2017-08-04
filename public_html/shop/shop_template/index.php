<?php
	$url = $_SERVER['REQUEST_URI'];
    $folders = explode("/", $url);
	$textNav = "";
	$shopLink = "";
	$foldersLength = count($folders);
	for($i=2; $i<$foldersLength-1; $i++){
		$shopLink .= "$folders[$i]/";
		$capitalLink = ucwords($folders[$i]);
		$textNav .= '<a class="title-shop-link" href="/page/'.$shopLink.'">'.$capitalLink.'</a> &bull;&nbsp;';
	}
	
$pageTitle=$textNav;
?><!DOCTYPE html>
<html lang="en-us">

<head>
	<link rel="stylesheet" type="text/css" href="/css/housestyle.css"> <!-- House Style CSS -->
	<link rel="stylesheet" type="text/css" href="/css/shop_style.css"> <!-- Page style -->
	<link rel="stylesheet" type="text/css" href="/css/shop_style_new.css"> <!-- Page style -->
	<link rel="icon" type="image/x-icon" href="/images/housestyle/Favicon.ico">
	<link href='http://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
	
	<title>Kneals Chocolates - Luxury Selections</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="Keywords" content="Kneals, Chocolates, Handmade, Luxury, Confectionery, Wedding, Favours, Gifts">
	<meta name="Description" content="Kneals Chocolates is all about quality, locally produced handmade chocolates. We are constantly aiming to create new and interesting flavours for you to taste. Our traditional methods and craftsmanship enable us to provide you with a unique tasting experience every time. ">
	
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	
	<script type="text/javascript" src="/js/fancyapp/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="/js/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="/js/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	
	<script type="text/javascript" src="/js/script.js"></script> <!-- Functions -->
</head>
<body>
<?php include  $_SERVER['DOCUMENT_ROOT'].'/inc/left.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/inc/shop_nav.php'; ?>
<div id="maincontent">
						
							<div id="item-container">
							
								<div class="product">
									<div class="product-title">Title</div>
									<div class="product-img"><span><a rel="product1" href="/images/chocolates/large/#.jpg" title="Large Luxury Selection"><img class="outer"src="/images/chocolates/thumbnail/#.jpg"></a></span></div>
									<div class="product-description"><u>Description:</u><br>description here</div>
									<div class="previews"><span><a rel="product1" href="/images/chocolates/large/#.jpg" title="Large Luxury Selection Box"><img class="outer"src="/images/chocolates/thumbnail/#.jpg"></a></span></div>
									<div class="product-price">&pound;00.00</div>
								</div> <!-- End of Left-product-->
								
								<div class="product">
									<div class="product-title">Title</div>
									<div class="product-img"><span><a rel="product1" href="/images/chocolates/large/#.jpg" title="Large Luxury Selection"><img class="outer"src="/images/chocolates/thumbnail/#.jpg"></a></span></div>
									<div class="product-description"><u>Description:</u><br>description here</div>
									<div class="previews"><span><a rel="product1" href="/images/chocolates/large/#.jpg" title="Large Luxury Selection Box"><img class="outer"src="/images/chocolates/thumbnail/#.jpg"></a></span></div>
									<div class="product-price">&pound;00.00</div>
								</div> <!-- End of Middle-product-->								
				
								<div class="product">
									<div class="product-title">Title</div>
									<div class="product-img"><span><a rel="product1" href="/images/chocolates/large/#.jpg" title="Large Luxury Selection"><img class="outer"src="/images/chocolates/thumbnail/#.jpg"></a></span></div>
									<div class="product-description"><u>Description:</u><br>description here</div>
									<div class="previews"><span><a rel="product1" href="/images/chocolates/large/#.jpg" title="Large Luxury Selection Box"><img class="outer"src="/images/chocolates/thumbnail/#.jpg"></a></span></div>
									<div class="product-price">&pound;00.00</div>
								</div> <!-- End of Right-product-->

								<div class="product">
									<div class="product-title">Title</div>
									<div class="product-img"><span><a rel="product1" href="/images/chocolates/large/#.jpg" title="Large Luxury Selection"><img class="outer"src="/images/chocolates/thumbnail/#.jpg"></a></span></div>
									<div class="product-description"><u>Description:</u><br>description here</div>
									<div class="previews"><span><a rel="product1" href="/images/chocolates/large/#.jpg" title="Large Luxury Selection Box"><img class="outer"src="/images/chocolates/thumbnail/#.jpg"></a></span></div>
									<div class="product-price">&pound;00.00</div>
								</div> <!-- End of Left-product-->								
							
							</div><!--End of item-container -->
							<p class ="note">*Prices do not include post &amp; packing<br>*Unfortunately, you currently cannot purchase directly online but we will cater to your needs by phone or email.</p>	
						</div><!-- End of maincontent -->
						
<?php include $_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'; ?>