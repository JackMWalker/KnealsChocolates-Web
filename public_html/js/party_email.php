<?php
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "kneals-info@knealschocolates.com";
    $email_subject = "Chocolate Party Request Form";
	
    $name = $_POST['name']; // required
    $postcode = $_POST['form_postcode']; // required
    $email_from = $_POST['email']; // required
    $phone = $_POST['phone']; // not required
	$date = $_POST['doe'];// required
	$address1 = $_POST['address1'];// required
	$address2 = $_POST['address2'];// not required
	$city = $_POST['city'];// required
    $comments = $_POST['comments']; // not required
	 
	$error_message;
	//if name is empty
	if(empty($name)){
		$error_message .= 'You need to enter a name.';
	}
	//postcode empty
	if(empty($postcode)){
		$error_message .= 'You need to enter a postcode.';
	}
	//email empty
	if(empty($email_from)){
		$error_message .= 'You need to enter an email.';
	}
	//invalid email
	if(!filter_var($email_from, FILTER_VALIDATE_EMAIL)){
		$error_message .= 'Enter a valid email.';
	}
	//invalid phone
	if(!ctype_digit($phone)){
		$error_message .= 'Phone number must be digits only.';
	}
	//empty date
	if(empty($date)){
		$error_message .= 'You need to enter a date.';
	}
	//empty address
	if(empty($address1)){
		$error_message .= 'You need to enter an address.';
	}	
	//empty address
	if(empty($city)){
		$error_message .= 'You need to enter a city/town.';
	}
  
    $email_message = "Form details below.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
	if(!empty($address2)){
		$aLine2 = clean_string($address2)."\n";
	}else{
		$aLine2 = "";
	}
      
    $email_message .= "Name/Company: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($phone)."\n";
    $email_message .= "Date: ".clean_string($date)."    NOTE: Read Backwords e.g.(yyyy-mm-dd)\n";
    $email_message .= "Address: ".clean_string($address1)."\n".$aLine2.clean_string($city)."\n".clean_string($postcode)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
	
// create email headers
if(empty($error_message)){
	$headers = 'From: '.$email_from."\r\n".
	'Reply-To: '.$email_from."\r\n" .
	'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers);  
	include '/inc/form_success.php';
}else{
	echo '<fieldset class="success_field">';
	echo '<legend class="success_title">Request Form</legend>';
	echo '<h3 class="successh3">Errors with request form</h3>';
	echo '<p>'.$error_message.'</p><br />';
	echo '<p>Hit refresh on the browser and fix the problems stated.</p>';
	echo '</fieldset>';
}
?>