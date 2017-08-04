<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php';

$user = new User();

if($user->is_logged_in())
{
	$transactions = new ViewTransactions() ;
}
else
{
	Redirect::to(Config::get('pages/admin_login'));
}

?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<title>Kneals Chocolates Admin - View Transactions</title>
	<?php show_meta() ; ?>
</head>
<body>

<?php show_header('View Transactions') ; ?>

<a class="logout" href="<?php echo Config::get('pages/logout'); ?>">Log out</a>

<div class="container">

	<div class="row">
		<div class="col-xs-12">
			<h2>Transactions</h2><br/>
			<?php 
			$transactions->show_list(); 
			?>
		</div>
	</div>

</div> <!--end of container-->
</body>
</html>