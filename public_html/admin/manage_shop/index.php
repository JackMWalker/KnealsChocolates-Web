<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php';

$user = new User();

if($user->is_logged_in())
{
	$product_list = new BrowseProducts() ;
}
else
{
	Redirect::to(Config::get('pages/admin_login'));
}
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<title>Kneals Chocolates Admin - Manage Shop</title>
	<?php show_meta() ; ?>
</head>
<body>

<?php show_header('Manage Shop') ; ?>

<div class="container main">
	<div class="row border">
		<div class="col-xs-11">
			<h2>All</h2><br/>

			<p id="notification"></p>
			<div id="e-p-container">
				<?php
				$product_list->show_list();
				?>
			</div>
		</div>

		<div class="col-xs-1">
			<a class="logout" href="<?php echo Config::get('pages/logout'); ?>">Log out</a>
		</div>
	</div>
</div>
</body>
</html>