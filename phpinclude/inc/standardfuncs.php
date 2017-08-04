<?php
//
function makeAddress($line1, $line2 = '', $city, $postal_code, $email = false){
	$lb = '<br>';
	$addr = "{$line1}<br>";
	if($line2){
		$addr .= "{$line2}<br>";
	}
	$addr .= "{$city}<br>";
	$addr .= $postal_code;
	return $addr;
}


?>