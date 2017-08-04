<?php
//show product list
if(isset($_GET['pid'])){
$targetID = $_GET['pid'];
$sql = $cdb->query("SELECT * FROM events WHERE id='$targetID'");
$productCount = mysqli_num_rows($sql);
if($productCount>0){
	while($row = mysqli_fetch_array($sql)){
		$eventTitle=$row['event_title'];
		$eventDesc=$row['event_desc'];
		$eventTimes=$row['event_times'];
		$eventURL=$row['event_url'];
		$eventAddress=$row['event_address'];
		$eventDate=$row['event_date'];
		$dateArray = explode("/",$eventDate);
		$formatDate = $dateArray[2].'/'.$dateArray[1].'/'.$dateArray[0];
	}
}else{
	echo 'This event doesn\'t exist. <a href="manage_calendar.php">Try Again.</a>';
	exit();
}
}
?>
<?php
//insert new product into database and upload image to server
if(isset($_POST['event_title'])){
	$pid = mysqli_real_escape_string($cdb, $_POST['thisID']);
	$event_title = mysqli_real_escape_string($cdb, $_POST['event_title']);
	$event_desc = mysqli_real_escape_string($cdb, $_POST['event_desc']);
	$event_url = mysqli_real_escape_string($cdb, $_POST['event_url']);
	$eventDate = mysqli_real_escape_string($cdb, $_POST['event_date']);
	$event_times = mysqli_real_escape_string($cdb, $_POST['event_times']);
	$event_address = mysqli_real_escape_string($cdb, $_POST['event_address']);
	
	$dateArray = explode("/",$eventDate);
	$event_date = $dateArray[2].'/'.$dateArray[1].'/'.$dateArray[0];
	
	$sql = $cdb->query("UPDATE events SET event_title='$event_title', event_desc='$event_desc', event_url='$event_url', event_date='$event_date', event_times='$event_times', event_address='$event_address' WHERE id='$pid'");
	header("Location: manage_calendar.php");
	exit();
}
?>