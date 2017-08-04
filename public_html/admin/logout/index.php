<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php');

$user = new User();

if($user->is_logged_in())
{
	$user->logout();
}

Redirect::to(Config::get('pages/login'));