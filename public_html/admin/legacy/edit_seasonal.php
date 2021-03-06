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

$category = "seasonal";                  ////////////  CHANGE THIS!
$docRoot = $_SERVER['DOCUMENT_ROOT'];
?>
<?php
include 'inc/edit_products_script.php';
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
	<h1 id="admin-title"><a href="index.php">Admin Panel</a> - Manage Seasonal</h1>
	<a href="http://www.knealschocolates.com/" title="Kneals home">
		<img id="title" src="http://www.knealschocolates.com/images/housestyle/title404.gif" alt="Kneals home" width="340" height="70">
	</a>
</div>
	<div id="content">
		<div id="product-list"><a class="logout" href="inc/logout.php">Log out</a>
			<a class="cancel-button" href="manage_<?php echo $category; ?>.php#inventoryForm">Cancel and Add New Item</a><br/>
		</div>
		<div id="add-new-product-form">
		<a name="inventoryForm" id="inventoryForm"></a>
			<h2>Add New Item Form</h2>
			<form enctype="multipart/form-data" onsubmit="return edit_submit_form();" action="edit_<?php echo $category; ?>.php" name="myForm" id="myForm" method="post">
			<table width="80%" border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td width="15%">Product Title</td>
					<td width="85%"><input type="text" name="ptitle" id="ptitle" value="<?php echo $title; ?>" size="60"/><span class="required">*</span>
					<span class="hidden" id="title_error">This field is required.</span></td>
				</tr>
				<tr>
					<td width="15%">Product Price</td>
					<td width="85%"><input type="text" name="pprice" id="pprice" value="<?php echo $price; ?>" size="12"/><span class="required">*</span>
					<span class="hidden" id="price_error">This field is required.</span></td>
				</tr>
				<tr>
					<td width="15%">Subcategory</td>
					<td width="85%">
					<select name="subcategory" id="subcategory">
					<option value="<?php echo $subcategory; ?>"><?php echo $subcategory; ?></option>
					<option value="selections">Selections</option>
					<option value="truffles">Truffles</option>
					</select><span class="required">*</span>
					<span class="hidden" id="type_error">This field is required.</span>
					</td>
				</tr>
				<tr>
					<td width="15%">Weight</td>
					<td width="85%"><input type="text" value="<?php echo $weight; ?>" name="weight" id="weight" size="12"/><span> grams</span><span class="required">*</span>
					<span class="hidden" id="weight_error">This field is required.</span></td>
				</tr>
				<tr>
					<td width="15%">Allergy Info</td>
					<td width="85%"><input type="text" value="<?php echo $allergy; ?>" name="allergy" id="allergy" size="60"/><span class="required">*</span>
					<span class="hidden" id="allergy_error">This field is required.</span></td>
				</tr>
				<tr>
					<td width="15%">Description</td>
					<td width="85%"><textarea name="description" id="description" rows="5" cols="60"><?php echo $desc; ?></textarea><span class="required">*</span>
					<span class="hidden" id="desc_error">This field is required.</span></td>
				</tr>
				<tr>
					<td width="15%">Paypal Url</td>
					<td width="85%"><textarea name="paypalurl" id="paypalurl" rows="5" cols="60"><?php echo $paypalURL; ?></textarea></td>
				</tr>
				<tr>
					<td width="15%">Postage Cost</td>
					<td width="85%"><input type="text" name="postage" id="postage" value="<?php echo $postage; ?>" size="12"/></td>
				</tr>
				<tr>
					<td width="15%">Product Image</td>
					<td width="85%"><input type="file" name="fileField" id="fileField"/></td>
				</tr>
				<tr style="height: 40px;">
					<td width="15%">Extra Image</td>
					<td width="85%"><input type="file" name="fileField2" id="fileField2"/></td>
				</tr>
				<tr>
					<td width="15%">&nbsp;</td>
					<td width="85%"><input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
					<input type="submit" name="button" id="button" value="Update item"/></td>
				</tr>
			</table>	
			</form>
		</div>
	</div>
	
</div> <!--end of container-->
</body>
</html>