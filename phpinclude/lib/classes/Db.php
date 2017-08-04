<?php
/**	Base class for database classes.
 */
class Db
{
	private $_db ;
	
	
	/**	
	 */
	protected function __construct ($host, $dbname, $dbuser, $dbpassword)
	{
		try
		{
			$this->_db = new PDO ('mysql:dbname='.$dbname.';host='.$host, $dbuser, $dbpassword) ;
			$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
		}
		catch (PDOException $e)
		{
			print $e->getMessage() ;
		}
	}
	
	
	/**	Runs the given query, and returns the result which will be a PDOStatement object, or null if the query fails.
	 *	If $sql contains '?', these are replaced by the following arguments, which will be escaped as strings.
	 *	Note: query() takes a variable number of arguments.  The first argument is the SQL query, the remaining arguments are the values
	 *	to substitue for the placeholders in the query.
	 */
	public function query ($sql)
	{
		$rtn = null ;
		try
		{
			$args = func_get_args() ;
			$sql = array_shift ($args) ;
			$rtn = $this->_db->prepare ($sql) ;
			if (!$rtn->execute ($args))
			{
				print "Failed to execute: $sql\n" ;
			}
		}
		catch (PDOException $e)
		{
			print $e->getMessage() ;
		}
		return $rtn ;
	}
	
	
	/**	Inserts the given values into the given table of this database.
	 */
	public function insert ($table, $array)
	{
		$keys = '' ;
		$value_placeholders = '' ;
		$values = array() ;
		foreach ($array as $key => $value)
		{
			if ($keys !== '') $keys .= ', ' ;
			if ($value_placeholders !== '') $value_placeholders .= ', ' ;
			$keys .= $key ;
			if ($value instanceof UnquotedValue)
			{
				$value_placeholders .= $value->_string ;
			}
			else
			{
				$value_placeholders .= '?' ;
				array_push ($values, $value) ;
			}
		}
		$sql = 'INSERT INTO '.$table.' ('.$keys.') VALUES ('.$value_placeholders.')' ;
		try
		{
			$sth = $this->_db->prepare ($sql) ;
			if (!$sth->execute ($values))
			{
				print "Failed to execute: $sql\n" ;
				return false;
			}
		}
		catch (PDOException $e)
		{
			print $e->getMessage() ;
			return false;
		}
		
		return true;
	}
	
} ;

