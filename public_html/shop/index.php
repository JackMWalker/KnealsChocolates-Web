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

</head>
<body>
<?php include SERVER_ROOT.'inc/header.php'; ?>
<div class="container">
	<div class="row standard-row">
		<h2 class="page-title col-12">Luxury Selections</h2>
		<div class="col-10 offset-1 bottom-margin">
            <div class="row">
                <?php
                foreach($products as $product) {
                    if($product->is_live) {
                        echo '<div class="product col-12 offset-1 offset-sm-0 col-md-6 col-lg-4">';
                        echo '    <a href="/shop/product.php?id='.$product->id.'">';
                        echo '        <span class="shop-links"></span>';
                        echo '    </a>';
                        echo '    <div class="product-title">'.$product->name.'</div>';
                        echo '    <div class="product-image"><img width="175" height="128" alt="'.$product->name.'" class="outer" src="/images/uploads/products/'.$product->images[0]->image_name.'"></div>';
                        echo '    <div class="product-desc"><a href="/shop/product.php?id='.$product->id.'"  class="bf_button"><span>See More</span></a></div>';
                        echo '    <div class="product-price">'.view_price($product->price).'</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
		</div><!--End of Products-->
	</div>
</div>				
<?php include SERVER_ROOT.'inc/footer.php'; ?>