<?php
class ContactForm 
{
	private $_db ;
	private $_name ;
	private $_email ;
	private $_cc ;
	private $_subject ;
	private $_message ;
	private $_receiver ;
	private $_subject_keys ;
	private $_email_subject ;
	private $_sent = false ;

	public function __construct($details)
	{
		date_default_timezone_set('UTC') ;
		$this->_db = EShopDB::inst();
		$this->_subject_keys = array(
			1 => 'Wedding Favours',
			2 => 'Corporate Gifts',
			3 => 'General Message',
			4 => 'Issue'
		);
		$this->_email_subject = 'Contact Form Message' ;
		$this->_receiver = ServerManager::isLive() ? KNEALS_EMAIL : ADMIN_EMAIL;
		$this->_cc = $details['subject'] == 4 ? ADMIN_EMAIL : false;
		$this->_name = $details['uname'] ;
		$this->_email = $details['email'] ;
		$this->_subject = $this->_subject_keys[$details['subject']] ;
		$this->_message = $details['message'] ;

		$this->addToDB();
	}

	public function send()
	{
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: {$this->_email}" . "\r\n";
		if($this->_cc) {
			$headers .= "Cc: {$this->_cc}" . "\r\n";
		}
		
		$message = "<html>
					<head>
						<title>Contact Form Message</title>
					</head>
					<body style='width:700px; margin:10px auto; font-family:helvetica;'>
						<header style='width:100%; height:60px; line-height:60px;'>
						<h2>New message received</h2>
					</header>

					<table style='width:100%'>
						<tr>
						    <th style='padding:10px 20px 10px; width:20%; text-align: right;'>Name</th>
						    <td style='padding:10px 2px; width:70%;'>{$this->_name}</td>
						</tr>
						<tr>
						    <th style='padding:10px 20px 10px; width:20%; text-align: right;'>Email</th>
						    <td style='padding:10px 2px; width:70%;'>{$this->_email}</td>
						</tr>

						<tr>
						    <th style='padding:10px 20px 10px; width:20%; text-align: right;'>Subject</th>
						    <td style='padding:10px 2px; width:70%;'>{$this->_subject}</td>
						</tr>

						<tr>
						    <th style='padding:10px 20px 10px; width:20%; text-align: right;'>Message</th>
						    <td style='padding:10px 2px; width:70%;'>{$this->_message}</td>
						</tr>

					</table> 
					</body>
					</html>";

		mail($this->_receiver, $this->_email_subject, $message, $headers);
		$this->_sent = true;
		return $this->_sent;
	}

	private function addToDB() 
	{
		$query_array['email'] = $this->_email;
		$query_array['name'] = $this->_name;
		$query_array['subject'] = $this->_subject;
		$query_array['message'] = $this->_message;
		$date = new DateTime();
		$query_array['date_sent'] = $date->format('Y-m-d H:i:s');

		return $this->_db->insert('contact_requests', $query_array);
	}

	public function sent()
	{
		return $this->_sent;
	}
}