<?php
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');

$id = (int)$_GET['id'];

$result = APIService::callAPI('GET', BASE_API_URL.'/products/'.$id);

$jsonResult = json_decode($result);
$product = $jsonResult->data;

$allergyInfo = makeAllergyString($product->allergies);
if($product->contains_alcohol) {
    $allergyInfo .= $allergyInfo ? '<br>Also contains alcohol' : 'Contains alcohol';
}

?>