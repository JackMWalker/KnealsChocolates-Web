<?php
class ServerManager 
{
	// returns true if the IP address is 127.0.0.1 (localhost)
	public static function isLocal() {
		return self::getIP() == '127.0.0.1' ;
	}

	// opposite to isLocal for ease of logic
	public static function isLive() {
		return !self::isLocal();
	}

	// returns an accurate IP address
	public static function getIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
			//check ip from share internet
	    	$ip = $_SERVER['HTTP_CLIENT_IP'];
	    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   
	    	//to check ip is pass from proxy
	    	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    } else {
	    	$ip = $_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

	// returns true if using HTTPS
	public static function isHTTPS() {
		return ($_SERVER['HTTPS']);
	}

	// redirect to the same url with http
	public static function forceHTTP() {
		Redirect::to('http://'.self::getURL());
	}

	// redirect to the same url with https
	public static function forceHTTPS() {
		Redirect::to('https://'.self::getURL());
	}

	// returns the current url
	public static function getURL() {
		$host = $_SERVER['SERVER_NAME'];
		$uri = $_SERVER['REQUEST_URI'];
		return $host.$uri;
	}
}