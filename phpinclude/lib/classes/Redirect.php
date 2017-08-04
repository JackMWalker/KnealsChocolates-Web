<?php
class Redirect
{
	public static function to($string = null)
	{
		if($string != null)
		{
			header("Location: {$string}");
			exit();
		}
		
	}
}
