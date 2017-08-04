<?php 
session_start();
define('SERVER_ROOT', dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/');
require_once (SERVER_ROOT.'inc/display_price.php');
require_once (SERVER_ROOT.'inc/standardfuncs.php');

spl_autoload_register(function($class) {
	require_once SERVER_ROOT.'lib/classes/'.$class.'.php' ;
});

// if not on https, force it
if(!ServerManager::isHTTPS()) {
	ServerManager::forceHTTPS();
}