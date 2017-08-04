<?php
//show product
include $_SERVER['DOCUMENT_ROOT'].'/shop/populate_products.php';

$url = $_SERVER['REQUEST_URI'];
$folders = explode("/", $url);
$textNav = "";
$shopLink = "";
$foldersLength = count($folders);

for($i = 2; $i < $foldersLength-1; $i++) 
{
	$shopLink .= "$folders[$i]/";
	$capitalLink = ucwords($folders[$i]);
	$textNav .= '<a class="title-shop-link" href="'.$shopLink.'">'.$capitalLink.'</a> &bull;&nbsp;';
}

$pageTitle = $textNav;
?>
<!DOCTYPE html>
<html lang="en-us">

<head>	
	<title>Kneals Chocolates - Shop</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="Keywords" content="Kneals, Chocolates, Handmade, Luxury, Confectionery, Wedding, Favours, Gifts">
	<meta name="Description" content="Kneals Chocolates is all about quality, locally produced handmade chocolates. We are constantly aiming to create new and interesting flavours for you to taste. Our traditional methods and craftsmanship enable us to provide you with a unique tasting experience every time. ">

	<?php include SERVER_ROOT.'inc/meta.html' ; ?>	

	<script type="text/javascript" src="/js/fancyapp/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="/js/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="/js/fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
</head>
<body>
<?php include SERVER_ROOT.'inc/header.php'; ?>

<div class="container">
	<div class="row standard-row">
		<a href="/shop/" class="back-to-shop">Continue Shopping</a>
		<?php echo $productDisplay;?>
	</div>
	<div class="row standard-row">
		<?php echo $prevChocDisplay;?>
	</div>
</div>

<script type="text/javascript">
	$(".thumb").click(function() {
		var mainsrc = $(".mainimg").attr('src');
		var newsrc = $(this).attr('src');
		/* change the "src" attribute of the element whose id is "bigpic" */
		/* the .data() method will get the picture id stored in the data-* attribute */
		if(mainsrc != newsrc){
			$(".mainimg1").attr("href", newsrc);
			$(".mainimg").attr("src", newsrc);
		}else{
			return false;
		}
	});
</script>
<?php include SERVER_ROOT.'inc/footer.php'; ?>