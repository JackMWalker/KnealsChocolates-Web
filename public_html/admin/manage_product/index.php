<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php';

$user = new User();

if($user->is_logged_in())
{
	if(Input::exists('get'))
	{
		$product = new Product(Input::get('id')) ;
	}
	
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

<?php show_header('Manage Product') ; ?>

<div class="container main">
	<div class="row border">
		<div class="col-xs-11">
		<?php
		$product->display_edit_product();
		?>
		</div>

		<div class="col-xs-1">
			<a class="logout" href="<?php echo Config::get('pages/logout'); ?>">Log out</a>
		</div>
	</div>
</div>
</body>
</html>