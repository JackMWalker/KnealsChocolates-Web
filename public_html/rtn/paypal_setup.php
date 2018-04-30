<?php
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');

require SERVER_ROOT.'app/start.php';

if(!isset($_POST['user_id'], $_POST['price'], $_POST['product_name'], $_POST['quantity'], $_POST['shipping'], $_POST['total'])) {
	print 'Something went wrong.';
	die();
}  

$user_id = $_POST['user_id'];
$price = $_POST['price'];
$product_name = $_POST['product_name'];
$quantity = $_POST['quantity'];
$shipping = $_POST['shipping'];
$total = $_POST['total'];
$subtotal = $total - $shipping;
$basketIds = $_POST['basket_ids'];
$total_quantity = $_POST['total_quantity'];

$uniqueid = uniqid('kn');

$payer= new Payer();
$payer->setPaymentMethod ('paypal');

$item = array();

$itemList = new ItemList();

for($i = 0; $i < count($product_name); $i++)
{
	$item[$i] = new Item();
	$item[$i]->setName($product_name[$i])
		 ->setCurrency('GBP')
		 ->setQuantity($quantity[$i])
		 ->setPrice(paypal_price($price[$i]));
}

$itemList->setItems($item);
$details = new Details();
$details->setShipping(paypal_price($shipping))
		->setSubtotal(paypal_price($subtotal));

$amount = new Amount();
$amount->setCurrency('GBP')
	   ->setTotal(paypal_price($total))
	   ->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)
			->setItemList($itemList)
			->setDescription('Kneals Payment')
			->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl(SITE_URL.'rtn/pay.php?success=true&unid='.$uniqueid)
			 ->setCancelUrl(SITE_URL.'basket/');

$payment = new Payment();
$payment->setIntent('sale')
		->setPayer($payer)
		->setRedirectUrls($redirectUrls)
		->setTransactions(array($transaction));

try 
{
	$payment->create($paypal);
} 
catch (Exception $e) 
{
	$data = json_decode($e->getMessage());
	var_dump($data);
	die();
}


$url = BASE_API_URL.'/transactions/basket';

$data['price'] = paypal_price($subtotal);
$data['postage'] = paypal_price($shipping);
$data['total_price'] = paypal_price($total);
$data['status'] = 'CREATED';
$data['uniqid'] = $uniqueid;
$data['basket_items'] = $basketIds;

APIService::callAPI("POST", $url, $data);

$approvalUrl = $payment->getApprovalLink();

header("Location:{$approvalUrl}");