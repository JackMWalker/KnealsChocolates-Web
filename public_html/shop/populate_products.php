<?php
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');

$db_eshop = EShopDB::inst(); 

$id = (int)$_GET['id'];
$productDisplay = "";
$optionTitle = array();
$optionDesc = array();
$optionId = array();
$optionAllergy = array();

$sql_query = "SELECT * FROM products WHERE id=? LIMIT 1";
$sql_result = $db_eshop->query($sql_query, $id);

if ($sql_result->rowCount() > 0)
{
	while($row = $sql_result->fetch(PDO::FETCH_ASSOC))
	{
		$title = $row['title'];
		$price = $row['price'];
		$weight = $row['weight'];
		$allergyinfo = $row['allergyinfo'];
		$description = $row['description'];
		$category = $row['category'];
		$live = $row['live'];
		$option = $row['options'];
		$dateadded = $row['dateadded'];
		$extraimg = $row['extraimg'];
		$prevchoc = $row['preview_chocs'];
		$prevchocarray = explode(';', $prevchoc);
		
		//check for extra image and create preview image
		$previewImg = '<div class="extra-product-image"><img width="62" height="47" alt="'.$title.'" class="thumb" src="/images/chocolates/'.$category.'/'.$id.'.png">';

		if($extraimg == 1)
			$previewImg .= '<img width="62" height="47" alt="'.$title.'" class="thumb" src="/images/chocolates/'.$category.'/'.$id.'_'.$id.'.png"></div>';
		else
			$previewImg .= "</div>";
		
		if($live == 1) 
		{
			$productDisplay .=
			'<div class="product-container col-xs-10 col-xs-offset-1">
				<div class="product-title-container col-xs-12">
					<div class="product-page-title col-xs-10">'.$title .' ('. $weight.'g)</div>
					<div class="product-page-price col-xs-2">'.format_price($price).' <a href="/post_packaging/" class="tiny-link">(P&P Terms)</a></div>
				</div>
				<div class="images-container col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-0">
					<div class="main-product-image"><span><a class="mainimg1" id="singleimg" href="/images/chocolates/'.$category.'/'.$id.'.png"><img width="300" height="210" alt="'.$title.'" class="mainimg img-responsive" src="/images/chocolates/'.$category.'/'.$id.'.png"></a></span></div>
					<div class="thumbnail-product-images">'.$previewImg.'</div>
				</div>
				<div class="product-info-container col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-0">
					<div class="product-page-desc"><h6>Description:</h6><p>'.$description.'</p></div>
					<div class="product-page-allergy"><h6>Allergy Info:</h6><p>'.$allergyinfo.'</p></div>';

				if($category == 'bars')
				{
					$sql1_query = "SELECT * FROM individual_chocs WHERE category = ?";
					$sql1_result = $db_eshop -> query($sql1_query, $category);
					if ($sql1_result->rowCount() > 0)
					{
						while($row1 = $sql1_result->fetch(PDO::FETCH_ASSOC)){
							array_push($optionId, $row1['id']);
							array_push($optionTitle, $row1['title']);
							array_push($optionDesc, $row1['description']);
							array_push($optionAllergy, $row1['allergens']);
						}
					}
					$productDisplay .= "<div class='bar-selection-container'>";

					for($i=0; $i<$option; $i++)
					{
						$productDisplay .= "<select class='bar-menu'>";
						
						for($j=0; $j<count($optionTitle); $j++)
						{
							$productDisplay .= "<option value='{$optionId[$j]}'>{$optionTitle[$j]}</option>";
						}

						$productDisplay .= "</select>";
					}

					$productDisplay .= "</div>";
				}

				$productDisplay .= '</div><div class="product-buy-now"><button type="button" class="add-to-cart-button" name="add-to-cart" data-product_id="'.$id.'">Add to Basket</button></div>
			</div>';	
		}

		if(strlen($prevchoc) > 0) 
		{
			foreach($prevchocarray as $chocID)
			{
				$sql2_query = "SELECT * FROM individual_chocs WHERE id = ?";
				$sql2_result = $db_eshop -> query($sql2_query, $chocID);
				if ($sql2_result->rowCount() > 0){
					while($row2 = $sql2_result->fetch(PDO::FETCH_ASSOC)){
						array_push($optionId, $row2['id']);
						array_push($optionTitle, $row2['title']);
						array_push($optionDesc, $row2['description']);
						array_push($optionAllergy, $row2['allergens']);
					}
				}
			}
			
			$prevChocDisplay = '<div class="col-xs-10 col-xs-offset-1"><h4 class="individual-chocs-title">What&#39;s in the box</h4>';
			for ($i = 0; $i < count($optionId); ++$i) 
			{
				$prevChocDisplay .= 
				'<div class="p-i-container col-xs-6 col-sm-4 col-md-3">
					<div class="p-i-title">'.$optionTitle[$i].'</div>
					<div class="p-i-image"><img width="140" height="85" alt="'.$optionId[$i].'" class="p-image" src="/images/chocolates/preview_chocs/'.$optionId[$i].'.jpg"></div>
					<div class="p-i-desc">'.$optionDesc[$i].'</div>';
					if($optionAllergy[$i] != '')
					{
						$prevChocDisplay .= '<div class="p-i-allergy"><b><u>Allergens</u>: '.$optionAllergy[$i].'</b></div>';
					}
				$prevChocDisplay .=  '</div>
				';
   			}
   			$prevChocDisplay .= '</div>';
		}
		elseif($option != '' && isset($optionAllergy))
		{
			$prevChocDisplay = '<div class="col-xs-10 col-xs-offset-1"><h4 class="individual-chocs-title">What&#39;s in the box</h4>';

			for($j = 0; $j < count($optionId); ++$j)
			{
 					$prevChocDisplay .= 
 					'<div class="p-i-container col-xs-6 col-sm-4 col-md-3">
 						<div class="p-i-title">'.$optionTitle[$j].'</div>
 						<div class="p-i-image">
 							<a href="/images/chocolates/preview_chocs/'.$optionId[$j].'.png" rel="gallery">
 								<img width="140" height="85" alt="'.$optionTitle[$j].'" class="p-image" src="/images/chocolates/preview_chocs/'.$optionId[$j].'.png">
 							</a>
 						</div>
 						<div class="p-i-desc">'.$optionDesc[$j].'</div>
 						<div class="p-i-allergy"><b><u>Allergens</u>: '.$optionAllergy[$j].'</b></div>
 					</div>
 					';
 			}
   			$prevChocDisplay .= '</div>';
		}
		else
		{
			$prevChocDisplay = '';
		}
	}
}
else
{
	$productDisplay .= 'A product with this product ID does not exist, go back and try again.';
}
?>