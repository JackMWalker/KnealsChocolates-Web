<?php

function format_price($price)
{
	$decimal_price = number_format($price/100 ,2);
	$format_price = '£'.$decimal_price;
	return $format_price;
}

function paypal_price($price)
{
	return number_format($price/100 ,2);
}

// called only from view.php page
function format_view_price($price)
{
	if(strpos((string)$price, '.') === false)
	{
		$format_price = '£'.$price.'.00';
	} else {
		$price_part = explode('.', (string)$price);
		$decimal = (int)$price_part[1];

		$decimal *= 10;
		$decimal = substr((string)$decimal, 0, 2);
		$format_price = '£'.$price_part[0].'.'.$decimal;
	}
	return $format_price;
}

?>