<?php
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');

$results = APIService::callAPI('GET', BASE_API_URL.'/products');

$jsonResults = json_decode($results);
$products = $jsonResults->data;
?>