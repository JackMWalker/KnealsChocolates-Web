<?php
require_once(dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');

// Ids to show on the main page
if(ServerManager::isLocal()) {
    $ids = [6, 7];
} else {
    $ids = [13, 2];
}

$title_arr = array();
$image_arr = array();
$price_arr = array();

foreach ($ids as $id) {
    $result = APIService::callAPI('GET', BASE_API_URL.'/products/'.$id);

    $jsonResult = json_decode($result);
    $product = $jsonResult->data;

    array_push($title_arr, $product->name);
    array_push($price_arr, $product->price);
    array_push($image_arr, $product->images[0]->image_name);
}

?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>Kneals Chocolates - Luxury Handmade Chocolates</title>
	<meta name="Keywords" content="Kneals, Chocolates, Handmade, Luxury, Confectionery, Wedding, Favours, Gifts">
	<meta name="Description" content="Kneals Chocolates is all about quality, locally produced handmade chocolates. We are constantly aiming to create new and interesting flavours for you to taste. Our traditional methods and craftsmanship enable us to provide you with a unique tasting experience every time.">
	
	<?php include SERVER_ROOT.'inc/meta.html' ; ?>

    <script type="text/javascript" src="/js/s3Slider.js"></script>

    <script type="text/javascript">
	    $("document").ready(function() {
			$('#slider2').s3Slider({
			    timeOut: 5000 
			});
	    });
	</script>
</head>
<body>
<?php include SERVER_ROOT.'inc/header.php'; ?>

		<div class="container"> 
			<div class="row">
				<div class="col-12">
					<section id="slider2">
						<ul id="slider2Content">
							<li class="slider2Image">
								<img src="/images/page-images/home-banner/banner-5.jpg" alt="luxury_box" />
								<span class="right"><br><br><strong>Award Winning</strong><br /><br />Multiple great taste award winning flavours, including our famous Cornish Sea Salt Caramels</span>
							</li>

							<li class="slider2Image">
								<img src="/images/page-images/home-banner/banner-4.jpg" alt="marc_de_champagne" />
								<span class="left"><br><br><strong>Wedding Favours</strong><br /><br />Bespoke wedding favours to add something special to your big day</span>
							</li>
							
							<li class="slider2Image">
								<img src="/images/page-images/home-banner/banner-1.jpg" alt="alcohol_truffles" />
								<span class="right offset"><br><br><strong>Luxury Selections</strong><br /><br />Handmade in Birmingham using locally sourced ingredients</span>
							</li>
							
							<li class="slider2Image">
								<img src="/images/page-images/home-banner/banner-2.jpg" alt="marc_de_champagne" />
								<span class="left"><br><br><strong>Exceptional Designs and Flavours</strong><br /><br />Boasting a range of exciting palate teasers from our Chilli infused chocolate to the award winning Salty Butterscotch</span>
							</li>

							<li class="slider2Image">
								<img src="/images/page-images/home-banner/banner-3.jpg" alt="marc_de_champagne"  />
								<span class="right"><br><br><strong>Handcrafted Chocolates</strong><br /><br />Small production ensuring the highest quality for each individual chocolate</span>
							</li>
							
							<div class="clear slider2Image"></div>
						</ul>
					</section>
				</div>
			</div>
		
			<div class="row home-title">
				<h1 class="col-12">Handmade Luxury Chocolate Gifts &amp; Favours</h1>
			</div>

			<div class="row bottom-margin">
				<section class="col-12 col-md-8">
					<div class='instore-container'>
						<?php 
						$i = 0;
						foreach($ids as $id)
						{
							print " <div class='product-container'>
										<a href='/shop/product.php?id={$id}'>
											<h5>{$title_arr[$i]}</h5>
											<img src='/images/uploads/products/".$image_arr[$i]."' height=130 alt=''>
										</a>
										<a class='long-button' href='/shop/product.php?id={$id}'>See More</a>
									</div>";
							$i++;
						}
						?>
					</div>
				</section>
				
				<section class="col-10 offset-1 col-sm-8 offset-sm-2 offset-md-0 col-md-4 home-wedding-poster">
					<a href='/corporate_weddings/'>
						<img src='/images/page-images/home-banner/wedding-sepia-text.jpg' width=100% height=100% alt="wedding favours">
					</a>
				</section>
			</div>

		</div> <!-- End of container -->	

<?php include SERVER_ROOT.'inc/footer.php'; ?>