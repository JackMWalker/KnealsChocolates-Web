<?php
//
function makeAddress($line1, $line2 = '', $city, $postal_code, $email = false) {
	$addr = "{$line1}<br>";
	if($line2){
		$addr .= "{$line2}<br>";
	}
	$addr .= "{$city}<br>";
	$addr .= $postal_code;
	return $addr;
}


function makeAllergyString($allergies) {
    $output = '';
    $i = 0;
    $len = sizeof($allergies) - 2;

    foreach($allergies as $allergy) {
        $output .= $allergy->name;
        $output .= $i == $len ? ' and ' : ($i < $len ? ', ' : '');
        $i++;
    }
    $output = ucfirst($output);

    return $output;
}



// Display price functions
function view_price($price)
{
    $decimal_price = number_format($price ,2);
    $format_price = '£'.$decimal_price;
    return $format_price;
}

function paypal_price($price)
{
    return number_format($price ,2);
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