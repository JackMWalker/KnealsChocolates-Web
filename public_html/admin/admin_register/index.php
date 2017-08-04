<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php');

$user = new User();

if($user->is_logged_in())
{
	Redirect::to(Config::get('pages/home'));
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
					'min' => 2,
					'max' => 64,
					'valid_email' => true
				),
				'password' => array(
					'name' => 'Password',
					'required' => true,
					'min' => 6,
					'max' => 64
				),
				're-password' => array(
					'name' => 'Re-type Password',
					'required' => true,
					'matches' => 'password'
				),
			));

			if($validation->passed())
			{
				try
				{
					$user->register(array('username' => Input::get('email'), 'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT) ) );
					$user_message = 'User registered successfully!' ;
				} 
				catch(Exception $e)
				{
					$user_message = $e;
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
	<title>Kneals Chocolates Admin - Register</title>
	<?php show_meta() ; ?>
</head>
<body>

<?php show_header('Register') ; 

if(isset($user_message))
{
	echo $user_message.'<br>' ;
	echo '<a href="'.Config::get('pages/login').'">Log in</a>';
}
else 
{
?>
<div class="container">
	<div class="row">
		<div class="col-sm-9">
			<h2>Register a new Admin</h2>
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
				<div class="form-group">
					<label for="re-password" class="sr-only">Re-type Password<span class="text-danger">*</span></label>
					<input type="password" class="form-control" name="re-password" id="re-password" placeholder="Re-type Password" value="<?php echo addslashes(Input::get('re-password')); ?>">
					<?php if(isset($validation_errors['re-password'])) echo '<p class="text-danger">'.$validation_errors['re-password'].'</p>' ?>
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" value="Register" class="btn btn-default">
			</form>		
		</div>
	</div>
</div> <!--end of container-->

</body>
</html>
<?php
}
?>