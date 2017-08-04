<?php
class Config 
{
	public static function get($string)
	{
		$sub_cats = explode('/', $string);

		$config = $GLOBALS['config'];

		foreach($sub_cats as $key) 
		{
			if(isset($config[$key]))
				$config = $config[$key];
			else
				return false;
		}

		return $config;
	}
}