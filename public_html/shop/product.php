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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
</head>
<body>
<?php include SERVER_ROOT.'inc/header.php'; ?>

<div class="container">
	<div class="row standard-row">
		<a href="/shop/" class="back-to-shop col-12">Continue Shopping</a>
	</div>

	<div class="row standard-row">
        <?php

        if(!$product || !$product->is_live) {
            echo 'A product with this product ID does not exist, go back and try again.';
        } else {
            // The main product area
            echo '<div class="product-container col-10 offset-1">';
            echo '  <div class="row">';
            echo '        <div class="product-page-title product-title-container col-10">'.$product->name .' ('. $product->weight.'g)</div>';
            echo '        <div class="product-page-price product-title-container col-2">'.view_price($product->price).'<br><a href="/post_packaging/" class="tiny-link">(P&P Terms)</a></div>';
            echo '    <div class="images-container col-8 offset-2 col-sm-4 offset-sm-0">';
            echo '        <div class="main-product-image"><span>';
            echo '             <a class="mainimg1" id="singleimg" data-fancybox="gallery" href="/images/uploads/products/'.$product->images[0]->image_name.'">';
            echo '                  <img alt="'.$product->name.'" class="mainimg img-responsive" src="/images/uploads/products/'.$product->images[0]->image_name.'">';
            echo '             </a></span>';
            echo '        </div>';
            echo '        <div class="thumbnail-product-images">';
            echo '            <div class="extra-product-image">';
            echo '              <img width="62" height="47" alt="'.$product->name.'" class="thumb" src="/images/uploads/products/'.$product->images[0]->image_name.'">';
            echo '            </div>';
            echo '        </div>';
            echo '    </div>';
            echo '    <div class="product-info-container col-10 offset-1 col-sm-8 offset-sm-0">';
            echo '        <div class="mt-4"><h6>Description:</h6><p>'.$product->description.'</p></div>';
            if($allergyInfo) echo '        <div class="product-page-allergy"><h6>Allergy Info:</h6><p>'.$allergyInfo.'</p></div>';

            echo '        <div class="row">';
            echo '            <div class=\'col-9 d-flex flex-column\'>';
            // If the user has the option to choose from the selection presented
            if(isset($product->dynamic_selection))
            {
                for($i = 0; $i < $product->dynamic_selection_number; $i++)
                {
                    echo '<select class="product-selections">';
                    foreach($product->selection->preview_items as $previewItem)
                    {
                        echo '<option value="'.$previewItem->id.'">'.$previewItem->name.'</option>';
                    }
                    echo '</select>';
                }
            }
            echo '            </div>';
            echo '            <div class="col-3">';
            echo '                <button type="button" class="add-to-cart-button" name="add-to-cart" data-product_id="'.$product->id.'">Add to Basket</button>';
            echo '            </div>';
            echo'         </div>';

            echo '    </div>';
            echo '  </div>';
            echo '</div>';

            // Display the what's in the box area
            if(isset($product->selection)) {
                echo '<div class="col-10 offset-1">';
                echo '  <h4 class="individual-chocs-title">What\'s in the box</h4>';
                echo '  <div class="row">';

                foreach($product->selection->preview_items as $preview) {
                    echo '<div class="p-i-container col-6 col-md-4 col-xl-3">';
                    echo '  <div class="p-i-title">'.$preview->name.'</div>';
                    echo '  <div class="p-i-image">';
                    echo '      <img width="140" height="85" class="p-image" src="/images/uploads/previews/'.$preview->image_name.'">';
                    echo '  </div>';
                    echo '  <div class="p-i-desc">';
                    echo        $preview->description;
                    echo '  </div>';
                    if($preview->allergies) {
                        $allergyString = makeAllergyString($preview->allergies);
                        if($preview->contains_alcohol) $allergyString.'. Contains alcohol';
                        echo '<div class="p-i-allergy">';
                        echo '<b><u>Allergens:</u> ';
                        echo $allergyString;
                        echo '</b></div>';
                    }
                    echo '</div>';
                }

                echo '  </div>';
                echo '</div>';
            }
        }
        ?>
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