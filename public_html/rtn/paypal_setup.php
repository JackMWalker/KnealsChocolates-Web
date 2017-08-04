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

$db_cart = EShopDB::inst();

$user_id = $_POST['user_id'];
$price = $_POST['price'];
$product_name = $_POST['product_name'];
$quantity = $_POST['quantity'];
$shipping = $_POST['shipping'];
$total = $_POST['total'];
$subtotal = $total - $shipping;
$trans_prod_id = $_POST['transids'];
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

$trans_prod_ids = implode(';', $trans_prod_id);
$quantities = implode(';', $quantity);

$query_array['user_id'] = $user_id;
$query_array['product_id_list'] = $trans_prod_ids;
$query_array['quantity_list'] = $quantities;
$query_array['price'] = paypal_price($total);
$query_array['postage'] = paypal_price($shipping);
$query_array['number_of_items'] = $total_quantity;
$query_array['status'] = 'created';
$query_array['delivered'] = 0;
$query_array['uniqid'] = $uniqueid;

$db_cart -> insert('cart_transactions', $query_array);

$approvalUrl = $payment->getApprovalLink();

header("Location:{$approvalUrl}");