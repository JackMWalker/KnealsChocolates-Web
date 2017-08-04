<?php
require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/init.php');
$form_sent = false;

if(Input::exists()) 
{
	if(Token::check(Input::get('token')))
	{
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
			'uname' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 2,
				'max' => 32
			),
			'email' => array(
				'name' => 'Email Address',
				'required' => true,
				'max' => 64,
				'valid_email' => true
			),
			'subject' => array(
				'name' => 'Subject',
				'required' => true,
			),
			'message' => array(
				'name' => 'Message',
				'required' => true,
				'min' => 2,
				'max' => 256
			)
		));

		if($validation->passed())
		{
			$details = array(
				'uname' => Input::get('uname'),
				'email' => Input::get('email'),
				'subject' => Input::get('subject'),
				'message' => Input::get('message')
			);

			$form = new ContactForm($details);

			$form_sent = true;
		}
		else
		{
			$validation_errors = $validation->getErrors();
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<title>Kneals Chocolates - Contact</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="Keywords" content="Kneals, Chocolates, Handmade, Luxury, Confectionery, Wedding, Favours, Gifts">
	<meta name="Description" content="Kneals Chocolates is all about quality, locally produced handmade chocolates. We are constantly aiming to create new and interesting flavours for you to taste. Our traditional methods and craftsmanship enable us to provide you with a unique tasting experience every time.">
	
	<?php include SERVER_ROOT.'inc/meta.html' ; ?>	
</head>
<body>
<?php include SERVER_ROOT.'inc/header.php'; ?>

		<section class="container"> <!-- Start of center -->
			<div class="row standard-row">
				<div class='col-xs-12 col-sm-9 col-sm-offset-1 bottom-margin'>

				<?php if($form_sent) { ?>
				<h2 class="page-title">Thank you for your message</h2>

				<p class="bottom-margin">Your message has successfully been sent to us. We will do our best to get back to your within the next 48 working hours.</p>
				<?php } else { ?>

				<h2 class="page-title">Get in Touch</h2>

				<p class="bottom-margin">If you want to get in touch about any Wedding Favour requests, Corporate Gifts, questions or simply any (lovely) feedback, please fill out the simple form below and start a conversion with us!</p>

				<form method="post" action="">
					<div class="form-group">
						<label for="uname">Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="uname" id="uname" placeholder="Name" value="<?php echo addslashes(Input::get('uname')); ?>" autocomplete="off">
						<?php if(isset($validation_errors['uname'])) echo '<p class="text-danger">'.$validation_errors['uname'].'</p>' ?>
					</div>
					<div class="form-group">
						<label for="email">Email Address <span class="text-danger">*</span></label>
						<input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="<?php echo addslashes(Input::get('email')); ?>">
						<?php if(isset($validation_errors['email'])) echo '<p class="text-danger">'.$validation_errors['email'].'</p>' ?>
					</div>
					<div class="form-group">
						<label for="subject">Subject</label>
						<select class="form-control" id="subject" name="subject">
							<option value="1" <?php if(Input::get('subject') == 1) echo 'selected'; ?>>Wedding Favours</option>
							<option value="2" <?php if(Input::get('subject') == 2) echo 'selected'; ?>>Corporate Gifts</option>
							<option value="3" <?php if(Input::get('subject') == 3) echo 'selected'; ?>>General Message</option>
							<option value="4" <?php if(Input::get('subject') == 4) echo 'selected'; ?>>Issues</option>
						</select>
						<?php if(isset($validation_errors['subject'])) echo '<p class="text-danger">'.$validation_errors['subject'].'</p>' ?>
					</div>
					<div class="form-group">
						<label for="message">Message <span class="text-danger">*</span></label>
						<textarea id="message" class="form-control" name="message" rows=4 placeholder="Type your message here..." value=""><?php echo addslashes(Input::get('message')); ?></textarea> 
						<?php if(isset($validation_errors['message'])) echo '<p class="text-danger">'.$validation_errors['message'].'</p>' ?>
					</div>
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					<input type="submit" value="Send" class="btn btn-default">
				</form>		
				<?php } ?>
			</div>
		</section> <!-- End of center side -->	

<?php include SERVER_ROOT.'inc/footer.php'; ?>