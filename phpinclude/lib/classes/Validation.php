<?php
class Validation 
{
	private $_passed = false;
	private $_errors = array();

	public function __construct() 
	{

	}

	public function check($source, $items = array())
	{
		$curr_name = '';
		foreach ($items as $item => $rules) 
		{
			$value = trim($source[$item]);

			foreach ($rules as $rule => $rule_value) 
			{
				if($rule === 'name')
				{
					$curr_name = $rule_value;
					continue;
				}

				if($rule === 'required' && empty($value))
				{
					$this->addError($item, "{$curr_name} is required") ;
				}
				else if(!empty($value))
				{
					switch ($rule)
					{
						case 'min' :
							if(strlen($value) < $rule_value)
							{
								$this->addError($item, "{$curr_name} must be more than {$rule_value} characters long.");
							}
							break;
						case 'max' :
							if(strlen($value) > $rule_value)
							{
								$this->addError($item, "{$curr_name} must be less than {$rule_value} characters long.");
							}
							break;
						case 'matches' :
							if($value != $source[$rule_value])
							{
								$this->addError($item, "{$curr_name} must match {$rule_value}.");
							}
							break;
 						case 'valid_email' :
 							if (!filter_var($value, FILTER_VALIDATE_EMAIL)) 
 							{
 								$this->addError($item, "{$value} is not a valid email.");
 							}
							break;
					}
				}
			}
		}

		if(empty($this->_errors))
		{
			$this->_passed = true;
		}

		return $this;
	}

	private function add_error($name, $error)
	{
		if(!isset($this->_errors[$name]))
		{
			$this->_errors[$name] = $error;
		}
	}

	public function get_errors()
	{
		return $this->_errors;
	}

	public function passed()
	{
		return $this->_passed;
	}
}