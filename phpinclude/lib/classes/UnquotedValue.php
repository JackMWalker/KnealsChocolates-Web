<?php
/**	This is used with Db::query() to pass values to an SQL expression that should not be escaped, such as "NOW()".
 */
class UnquotedValue
{
	public $_string ;
	
	
	public function __construct ($string)
	{
		$this->_string = $string ;
	}
} ;