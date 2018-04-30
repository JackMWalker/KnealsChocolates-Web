<?php
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

require SERVER_ROOT.'app/start.php';
require $_SERVER['DOCUMENT_ROOT'].'/basket/inc/cart_functions.php';


$db_cart = EShopDB::inst();

if(!isset($_GET['success'], $_GET['paymentId'], $_GET['PayerID'], $_GET['unid']))
{
	print "Invalid Page Access.";
	die();//error page
}

if((bool)$_GET['success'] === false)
{
	print "Invalid Page Access.";
	die();
}

$paymentId = $_GET['paymentId'];
$payerId = $_GET['PayerID'];
$unid = $_GET['unid'];

$payment = Payment::get($paymentId, $paypal);

$execute = new PaymentExecution();
$execute->setPayerId($payerId);

try
{
	$result = $payment->execute($execute, $paypal);
}
catch(Exception $e)
{
	die($e);
}

if($result)
{
	$paypal_status = $payment->getState();

	$payer = $payment->getPayer();
	$payer_info = $payer->getPayerInfo();
	$email = $payer_info->getEmail();

	$shipping_address = $payer_info->getShippingAddress();
	$name = $shipping_address->getRecipientName();
	$line1 = $shipping_address->getLine1();
	$line2 = $shipping_address->getLine2();
	$city = $shipping_address->getCity();
	$postal_code = $shipping_address->getPostalCode();

	$transaction = $payment->getTransactions();
	$amount = $transaction[0]->getAmount();
	$total = $amount->getTotal();

	$details = $amount->getDetails();
	$shipping = $details->getShipping();

	// get the transaction basket by the uniqid
    $getURL = BASE_API_URL.'/transactions/basket?uniqid='.$unid;
    $result1 = APIService::callAPI("GET", $getURL);
    $jsonResult1 = json_decode($result1);
    $basketTransaction = $jsonResult1->data;

    // update the status
    $id = $basketTransaction->id;
    $data['status'] = $paypal_status;
    $updateURL = BASE_API_URL.'/transactions/basket/'.$id;
    APIService::callAPI("POST", $updateURL, $data);

	$data['payer_name'] = $name;
	$data['address_line1'] = $line1;
	$data['address_line2'] = $line2;
	$data['city'] = $city;
	$data['postal_code'] = $postal_code;
	$data['payer_id'] = $payerId;
	$data['payer_email'] = $email;
	$data['payment_status'] = $paypal_status;
	$data['transaction_id'] = $id;
	$data['payment_id'] = $paymentId;
	$data['price'] = $total;
	$data['fee'] = 0;

    $createURL = BASE_API_URL.'/transactions/paypal';
    APIService::callAPI("POST", $createURL, $data);

	setBasketPurchased();

	include SERVER_ROOT.'inc/email.php';
	
	if($paymentId)
	{
		$url = "view.php?pmt_id=$paymentId";
		header("Location:$url");
	}
	else
	{
		print 'Something went wrong. Please contact <a class="email" href="mailto:jackwalker3627@gmail.com">Kneals technical team</a>.';
	}
}

?>