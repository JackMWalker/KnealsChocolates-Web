<?php
//show product list
include $_SERVER['DOCUMENT_ROOT'].'/shop/populate_shop_script.php';
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
		<h2 class="page-title">Luxury Selections</h2>
		<div class="col-xs-10 col-xs-offset-1 bottom-margin">			
		
			<?php echo $category1Display;?>
			
		</div><!--End of Products-->
	</div>
</div>				
<?php include SERVER_ROOT.'inc/footer.php'; ?>