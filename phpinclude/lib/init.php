<?php 
session_start();
define('SERVER_ROOT', dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/');
require_once (SERVER_ROOT.'inc/standard_functions.php');
require_once (SERVER_ROOT.'app/params.php');

spl_autoload_register(function($class) {
	require_once SERVER_ROOT.'lib/classes/'.$class.'.php' ;
});

// define base API URL
$baseUrl = ServerManager::isLocal() ? 'http://localhost:8000' : 'http://cms.knealschocolates.com';
define('BASE_URL', $baseUrl);
define('BASE_API_URL', $baseUrl.'/api');

// if not on https, force it
if(!ServerManager::isHTTPS() && ServerManager::isLive()) {
	ServerManager::forceHTTPS();
}

// DEBUG if local
if(ServerManager::isLocal()) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}