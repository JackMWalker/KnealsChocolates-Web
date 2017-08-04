<?php
//delete product
if(isset($_GET['deleteid'])){
	echo 'Do you really want to delete this item with ID of '.$_GET['deleteid'].'? <a href="manage_calendar.php?yesdelete='.$_GET['deleteid'].'">Yes</a> | <a href="manage_calendar.php">No</a>';
	exit();
}
if(isset($_GET['yesdelete'])){
	//remove item from database and delete image
	$id_to_delete = $_GET['yesdelete'];
	$sql = $cdb->query("DELETE FROM events WHERE id='$id_to_delete' LIMIT 1")or die(mysqli_error());
	
	header("Location: manage_calendar.php");
	exit();
}
?>
<?php
//insert new product into database and upload image to server
if(isset($_POST['event_title'])){
	
	$event_title = mysqli_real_escape_string($cdb, $_POST['event_title']);
	$event_desc = mysqli_real_escape_string($cdb, $_POST['event_desc']);
	$event_url = mysqli_real_escape_string($cdb, $_POST['event_url']);
	$eventDate = mysqli_real_escape_string($cdb, $_POST['event_date']);
	$event_times = mysqli_real_escape_string($cdb, $_POST['event_times']);
	$event_address = mysqli_real_escape_string($cdb, $_POST['event_address']);
	
	$dateArray = explode("/",$eventDate);
	$event_date = $dateArray[2].'/'.$dateArray[1].'/'.$dateArray[0];
	
	$sql = $cdb->query("INSERT INTO events (event_title, event_desc, event_url, event_date, event_times, event_address) VALUES('$event_title','$event_desc','$event_url','$event_date','$event_times','$event_address')")or die(mysqli_error());
	header("Location: manage_calendar.php");
	exit();
}
?>
<?php
//show product list
$eventList="";
$sql = $cdb->query("SELECT * FROM events ORDER BY event_date DESC");
$productCount = mysqli_num_rows($sql);
if($productCount>0){
	while($row = mysqli_fetch_array($sql)){
		$id=$row['id'];
		$eventTitle=$row['event_title'];
		$eventDate=$row['event_date'];
		$dateArray = explode("/",$eventDate);
		$formatDate = $dateArray[2].'/'.$dateArray[1].'/'.$dateArray[0];
		$eventList .= "<p>ID-$id &nbsp;&nbsp;<b>$eventTitle</b> &nbsp;- &nbsp;<i>Date $formatDate</i>&nbsp; &nbsp; &nbsp; &nbsp; <a href='edit_calendar.php?pid=$id'>edit</a> &bull; <a href='manage_calendar.php?deleteid=$id'>delete</a></p>";
	}
}else{
	$eventList .= 'You have no events on your calendar yet';
}
?>