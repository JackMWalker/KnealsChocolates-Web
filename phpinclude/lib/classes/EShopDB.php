<?php
require_once dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/lib/db_settings_eshop.php' ;

class EShopDB extends Db
{
	public function __construct()
	{
		parent::__construct (ESHOP_DBHOST, ESHOP_DBNAME, ESHOP_DBUSER, ESHOP_DBPASSWORD) ;
	}
	
	public static function inst()
	{
		static $db ;
		if (!$db)
		{
			$db = new EShopDB ;
		}
		return $db ;
	}
} ;