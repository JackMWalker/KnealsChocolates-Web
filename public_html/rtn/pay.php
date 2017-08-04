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

	$query = "SELECT id, status FROM cart_transactions WHERE uniqid = ?";
	$result = $db_cart -> query($query, $unid);

	while($row = $result->fetch(PDO::FETCH_ASSOC)) 
	{
			$id = $row['id'];
			$status = $row['status'];
	}

	if($status !== $paypal_status)
	{
		$update_query_master = "UPDATE cart_transactions SET status = ? WHERE id = ?";
		$result_master = $db_cart -> query($update_query_master, $paypal_status, $id);
	}

	$query_array['payer_name'] = $name;
	$query_array['line1'] = $line1;
	$query_array['line2'] = $line2;
	$query_array['city'] = $city;
	$query_array['postal_code'] = $postal_code;
	$query_array['payer_id'] = $payerId;
	$query_array['payer_email'] = $email;
	$query_array['payment_status'] = $status;
	$query_array['transaction_id'] = $id;
	$query_array['payment_id'] = $paymentId;
	$query_array['price'] = $total;
	$query_array['fee'] = 0;

	$db_cart -> insert('paypal_transaction', $query_array);

	delete_cart();

	include SERVER_ROOT.'inc/email.php';
	
	if($paymentId)
	{
		$url = "view.php?pmt_id=$paymentId";
		header("Location:$url");
	}
	else
	{
		print 'Something went wrong. Please contact <a class="email" href="mailto:developer@knealschocolates.com">Kneals technical team</a>.';
	}
}

?>