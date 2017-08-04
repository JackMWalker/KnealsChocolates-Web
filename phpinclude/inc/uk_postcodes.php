<?php
require_once ('/lib/ECalendarDb.php');

$zipone = $_POST['fromPC'];
$ziptwo = 'B29';
$unit = 'M';
$error_message = 'Enter the first part of your postcode.';

function distance_between_postcodes($zipone, $ziptwo, $unit){
  if($zipone == null){
  	die();
  }

  $db_ecalendar = ECalendarDb::inst();

  $sql_query = "SELECT * FROM uk_postcodes WHERE postcode=?";
  $sql_result1 = $db_ecalendar->query($sql_query, $zipone);
  if (!$sql_result1) {
      die('Could not query1:');
  }
  $ziponedata = $sql_result1->fetch(PDO::FETCH_GROUP);  

  $sql_query = "SELECT * FROM uk_postcodes WHERE postcode=?";
  $sql_result2 = $db_ecalendar->query($sql_query, $ziptwo);
  if (!$sql_result2) {
      die('Could not query1:');
  }
  $ziptwodata = $sql_result2->fetch(PDO::FETCH_GROUP);  

  $distancebetween = distance55($ziponedata[3],$ziponedata[4],$ziptwodata[3],$ziptwodata[4],$unit);
  return $distancebetween;
} // end function


///////////////////////////////////////////////////////sss//////////////////////////////////////////////////////////////////
function distance55($lat1, $lon1, $lat2, $lon2, $unit9) { 

  $theta = $lon1 - $lon2; 
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
  $dist = acos($dist); 
  $dist = rad2deg($dist); 
  $miles = $dist * 60 * 1.1515;
  $unit9 = strtoupper($unit9);

  if ($unit9 == "K") {
    return ($miles * 1.609344); 
  } else if ($unit9 == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$distance = distance_between_postcodes($zipone, $ziptwo, $unit);
$distanceFormat = number_format($distance, 2, '.', '');

if($distanceFormat > 12){
	echo '<img height="18px" width="16px" src="/images/page-images/misc/incorrect.gif">';
	echo '   You live too far for us at this time.';
}else if($distanceFormat <= 12){
	echo '<img height="18px" width="16px" src="/images/page-images/misc/correct.gif">';
	echo '   You live close enough.';
}

?>