<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php';

$user = new User();

if($user->is_logged_in())
{
	
}
else
{
	Redirect::to(Config::get('pages/admin_login'));
}

?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<title>Kneals Chocolates Admin - Home</title>
	<?php show_meta() ; ?>
</head>
<body>

<?php show_header('Admin Panel') ; ?>

<div class="container main">
	<div class="row border">
		<div class="col-xs-10">
			<ul class="main-menu">
				<li><a href="<?php echo Config::get('pages/view_transaction'); ?>">View Transactions</a></li>
				<li><a href="<?php echo Config::get('pages/manage_shop'); ?>">Manage Shop</a></li>
			</ul>
		</div>
		<div class="col-xs-2">
			<a class="logout" href="<?php echo Config::get('pages/logout'); ?>">Log out</a>
		</div>
	</div>
</div> <!--end of container-->

</body>
</html>