<?php
class Token
{
	public static function generate()
	{
		return Session::put('csrf_token', md5(uniqid()));
	}

	public static function check($token)
	{
		$tokenName = 'csrf_token' ;

		if(Session::exists($tokenName) && $token === Session::get($tokenName))
		{
			Session::delete($tokenName);
			return true;
		}

		return false;
	}
	
}