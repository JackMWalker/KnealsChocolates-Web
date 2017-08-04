<?php
error_reporting(E_ALL); ini_set('display_errors', 'On'); 
session_save_path('tempsessions');
ini_set('session.gc_probabilit­y', 1);
session_start();
if(!isset($_SESSION['manager'])){
	header("Location: admin_login.php");
	exit();
}
//Be sure to check this manager SESSION value is in the database
include 'inc/check_login.php';

$docRoot = $_SERVER['DOCUMENT_ROOT'];
?>
<?php
include 'connect_ecalendar.php';
include "inc/manage_calendar_script.php";
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
	<link rel="stylesheet" type="text/css" href="admin.css?id=<?php echo rand(1,1000); ?>"> <!-- Page Style CSS -->
	<link rel="icon" type="image/x-icon" href="/images/housestyle/Favicon.ico">
	<title>Admin Panel</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
	<script type="text/javascript" src="form_validation.js?id=<?php echo rand(1,1000); ?>"></script>
</head>
<body>
<div id="container">
<div id="title-container">
	<h1 id="admin-title"><a href="index.php">Admin Panel</a> - Manage Calendar</h1>
	<a href="http://www.knealschocolates.com/" title="Kneals home">
		<img id="title" src="http://www.knealschocolates.com/images/housestyle/title404.gif" alt="Kneals home" width="340" height="70">
	</a>
</div>
	<div id="content">
		<div id="product-list"><a class="logout" href="inc/logout.php">Log out</a>
			<h2>Upcoming Events</h2><a class="add-new-button" href="manage_calendar.php#inventoryForm">+ Add New Item</a><br/>
			<?php echo $eventList?>
		</div>
		<div id="add-new-product-form">
		<a name="inventoryForm" id="inventoryForm"></a>
			<h2>Add New Item Form</h2>
			<form onsubmit="return submit_calendar_form();" action="manage_calendar.php" name="myForm" id="myForm" method="post">
			<table width="80%" border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td width="15%">Event Title</td>
					<td width="85%"><input type="text" name="event_title" id="event_title" size="60"/><span class="required">*</span>
					<span class="hidden" id="title_error">This field is required.</span></td>
				</tr>
				<tr>
					<td width="15%">Description</td>
					<td width="85%"><textarea name="event_desc" id="event_desc" rows="5" cols="60"></textarea><span class="required">*</span>
					<span class="hidden" id="desc_error">This field is required.</span></td>
				</tr>
				<tr>
					<td width="15%">Event Address</td>
					<td width="85%"><textarea name="event_address" id="event_address" rows="5" cols="60"></textarea><span class="required">*</span>
					<span class="hidden" id="address_error">This field is required.</span></td>
				</tr>
				<tr>
					<td width="15%">Event Date</td>
					<td width="85%"><input type="text" name="event_date" id="event_date" placeholder="dd/mm/yyyy"size="12"/><span>Use Leading 0's and forward slashes eg. 01/05/2013</span><span class="required">*</span>
					<span class="hidden" id="date_error">This field is required.</span></td>
				</tr>
				<tr>
					<td width="15%">Event URL</td>
					<td width="85%"><input type="text" name="event_url" id="event_url" size="60"/></td>
				</tr>
				<tr>
					<td width="15%">Event Times</td>
					<td width="85%"><input type="text" name="event_times" id="event_times" size="60"/></td>
				</tr>
				
				<tr>
					<td width="15%">&nbsp;</td>
					<td width="85%"><input type="submit" name="button" id="button" value="Add new event"/></td>
				</tr>
			</table>	
			</form>
		</div>
	</div>
	
</div> <!--end of container-->
</body>
</html>