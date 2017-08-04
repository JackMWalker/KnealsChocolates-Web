<?php
$vatno = $_POST['vatno'] ;
$company = $_POST['vatcompany'] ;
$address = $_POST['vataddress'] ;

if (isset ($vatno) && isset ($company) && isset ($address))
{
	$vatno = trim ($vatno) ;
	$company = trim ($company) ;
	$address = trim ($address) ;

	$vatno_sl = addslashes ($vatno) ;
	$company_sl = addslashes ($company) ;
	$address_sl = addslashes ($address) ;

	if (strlen($vatno) > 20)
	{
		$vat_status = VAT_INVALID ;
		$vatno_sl = addslashes (substr ($vatno, 0, 20)) ;
	}
	else if (!$vatno)
	{
		$vat_status = VAT_NO_NUMBER ;
	}
	else if (!preg_match ('/^[a-zA-Z][a-zA-Z]/', $vatno))
	{
		$vat_status = VAT_NO_CC ;
	}
	else if (!$company)
	{
		$vat_status = VAT_NO_COMPANY ;
	}
	else if (!$address)
	{
		$vat_status = VAT_NO_ADDRESS ;
	}
	else
	{
		$vat_status = check_vat_number ($vatno) ;
	}

	$db = bprocessor_connect();

	$vid = 0 ;
	if (isset ($vatcode))
	{
		// Updating existing vatsession record.
		$vatcode = preg_replace ('/\D/', '', $vatcode) ;
		if ($vatcode)
		{
			$result = bprocessor_run_query ("SELECT id FROM vatsession WHERE accessCode='$vatcode'", $db) ;
			if (mysql_num_rows ($result) > 0)
			{
				$row = mysql_fetch_array ($result) ;
				$vid = $row['id'] ;
				bprocessor_run_query ("UPDATE vatsession SET vatNumber='$vatno_sl',companyName='$company_sl',address='$address_sl',vatStatus=$vat_status WHERE id=".$vid, $db) ;
			}
		}
	}

	if ($vid == 0)
	{
		// New vatsession record.
		bprocessor_run_query ("INSERT INTO vatsession (vatNumber,companyName,address,vatStatus) VALUES ('$vatno_sl','$company_sl','$address_sl',$vat_status)", $db) ;
		$result = bprocessor_run_query ("SELECT LAST_INSERT_ID()", $db) ;
		$row = mysql_fetch_array ($result) ;
		$vid = $row[0] ;
		$vatcode = sprintf ("%04d", mt_rand(0,10000)).sprintf ("%08d", (($vid * 387425615) & 0x7FFFFFFF) % 100000000) ;
		bprocessor_run_query ("UPDATE vatsession SET accessCode='$vatcode' WHERE id=$vid", $db) ;
	}
}


?>
