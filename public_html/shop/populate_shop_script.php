<?php
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');

$db_eshop = EShopDB::inst();
$category1Display="";

$category='luxury';
$category2='bars';

$sql_query = "SELECT * FROM products WHERE category=? OR category = ? ORDER BY priority";
$sql_result = $db_eshop -> query($sql_query, $category, $category2);

if ($sql_result->rowCount() > 0) {
	while($row = $sql_result->fetch(PDO::FETCH_ASSOC)) {
		$id = $row['id'];
		$title = $row['title'];
		$price = $row['price'];
		$weight = $row['weight'];
		$allergyinfo = $row['allergyinfo'];
		$description = $row['description'];
		$live = $row['live'];
		$category = $row['category'];
		
		if($live == 1) {
			$category1Display .=
			'<div class="product col-xs-10 col-xs-offset-1 col-sm-offset-0 col-sm-6 col-md-4">
				<a href="/shop/product.php?id='.$id.'">
					<span class="shop-links"></span>
				</a>
				<div class="product-title">'.$title.'</div>
				<div class="product-image"><img width="175" height="128" alt="'.$title.'" class="outer" src="/images/chocolates/'.$category.'/'.$id.'.png"></div>
				<div class="product-desc"><a href="/shop/product.php?id='.$id.'"  class="bf_button"><span>See More</span></a></div>
				<div class="product-price">'.format_price($price).'</div>
			</div>';
		}
	}
} else {
	$category1Display .= 'We have no products listed in our store yet';
}
?>