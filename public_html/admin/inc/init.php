<?php
session_start();

$GLOBALS['config'] = array(
		'session' => array(
				'admin_login' => 'adlogin',
				'token_name' => 'unitoken',
			),
		'cookie' => array(
				'remember_me' => 'rememberme',
			),
		'pages' => array(
				'manage_shop' => '/admin/manage_shop/',
				'view_transaction' => '/admin/view_transactions/',
				'logout' => '/admin/logout/',
				'login' => '/admin/admin_login/',
				'home' => '/admin/',
				'register' => '/admin/admin_register/',
			),
		'example' => array(

			),

	);

require_once $_SERVER['DOCUMENT_ROOT'].'/admin/inc/standardfunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/inc/display_price.php';

spl_autoload_register(function($class) {
	require_once $_SERVER['DOCUMENT_ROOT'].'/lib/classes/'.$class.'.php' ;
});