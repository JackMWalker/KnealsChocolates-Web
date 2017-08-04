<?php
class Input 
{
	public static function exists($type = 'post')
	{
		switch ($type) 
		{
			case 'post' :
				return (!empty($_POST)) ;
				break;
			case 'get' :
				return (!empty($_GET)) ;
				break;
			default:
				return false;
				break;
		}
	}

	public static function get($name)
	{
		if(isset($_POST[$name]))
		{
			return $_POST[$name] ;
		}
		else if (isset($_GET[$name]))
		{
			return $_GET[$name] ;
		}
		else
		{
			return "" ;
		}
	}

}