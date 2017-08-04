<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php');

$user = new User();
if($user->is_logged_in())
{
	Redirect::to(Config::get('pages/home')) ;
}
else
{
	if(Input::exists()) 
	{
		if(Token::check(Input::get('token')))
		{
			$validate = new Validation();
			$validation = $validate->check($_POST, array(
				'email' => array(
					'name' => 'Email Address',
					'required' => true,
					'valid_email' => true
				),
				'password' => array(
					'name' => 'Password',
					'required' => true,
				),
			));

			if($validation->passed())
			{
				$user->login(Input::get('email'), Input::get('password'), true);
				if($user->is_logged_in())
				{
					Redirect::to(Config::get('pages/home'));
				}
				else
				{
					$login_errors = $user->get_errors();
				}
			}
			else
			{
				$validation_errors = $validation->get_errors();
			}
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<title>Kneals Chocolates Admin - Login</title>
	<?php show_meta() ; ?>
</head>
<body>

<?php show_header('Register') ; 

if(isset($user_message))
{
	echo $user_message.'<br>' ;
}
else 
{
?>
<div class="container">
	<div class="row">
		<div class="col-sm-9">
			<h2>Login</h2>
			<form method="post" action="">
				<div class="form-group">
					<label for="email" class="sr-only">Email Address<span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo addslashes(Input::get('email')); ?>" autocomplete="off">
					<?php if(isset($validation_errors['email'])) echo '<p class="text-danger">'.$validation_errors['email'].'</p>' ?>
				</div>
				<div class="form-group">
					<label for="password" class="sr-only">Password<span class="text-danger">*</span></label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo addslashes(Input::get('password')); ?>">
					<?php if(isset($validation_errors['password'])) echo '<p class="text-danger">'.$validation_errors['password'].'</p>' ?>
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" value="Log in" class="btn btn-default">
			</form>		
		</div>
	</div>
</div> <!--end of container-->

</body>
</html>
<?php
}
?>