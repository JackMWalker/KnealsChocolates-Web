<?php
class User 
{
	private $_data ;
	private $_db ;
	private $_session_name ;
	private $_logged_in = false ;
	private $_errors = array();

	public function __construct($user = null)
	{
		$this->_db = EShopDB::inst();
		$this->_session_name = Config::get('session/admin_login');
		if(!$user)
		{
			if(Session::exists($this->_session_name))
			{
				$user_id = Session::get($this->_session_name);
				if($this->find($user_id))
				{
					$this->_logged_in = true;
				}
			}
		}
		else
		{
			$this->find($user) ;
		}
	}

	public function register($details)
	{
		if($this->_id = $this->_db->insert('admin', $details))
		{
			return true ;
		}
		else
		{
			throw new Exception("User could not be registered.") ;
		}
		
	}

	public function login($username, $password, $admin = false)
	{
		$user = $this->find($username);
		if($user)
		{
			if($admin)
			{
				$this->_logged_in = ($this->_data['admin'] == 1 && password_verify($password, $this->_data['password'])) ;
			}
			else
			{
				$this->_logged_in = password_verify($password, $this->_data['password']);
			}

			if($this->is_logged_in())
			{
				Session::put($this->_session_name, $this->_data['id']);
			}
		}

		return $this->is_logged_in() ;
	}

	public function logout()
	{
		Session::delete($this->_session_name);
		$this->_logged_in = false ;
	}

	public function is_logged_in()
	{
		return $this->_logged_in ;
	}

	public function get_errors()
	{
		return $this->_errors;
	}

	private function find($user = null)
	{
		if($user)
		{
			$field = is_numeric($user) ? 'id' : 'username' ;
			$result = $this->_db->query("SELECT * FROM `admin` WHERE {$field} = ? LIMIT 1", $user);
			if($result->rowCount())
			{
				$row = $result->fetch(PDO::FETCH_ASSOC);
				$this->_data = $row ;
				return true;
			}
			else
			{
				$this->add_error('Could not find user: '.$user);
			}
		}
		
		return false;
	}

	private function add_error($error)
	{
		array_push($this->_errors, $error) ;
		
	}

}