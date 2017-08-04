<?php
define('COOKIE_EXPIRY', 60*60*24*365);

function track_visit(){

	if(isset($_COOKIE['UserUniqueID'])){
		$user_id = $_COOKIE['UserUniqueID'];
	}else{
		//creates a unique ID with a random number as a prefix
		$c = uniqid (rand(), true);

		$md5c = md5($c);

		setcookie("UserUniqueID", $md5c, time() + COOKIE_EXPIRY, '/', '.knealschocolates.com'); //set the cookie with a one year expiry date

		$user_id = $md5c;
	}

	return $user_id;
}

?>