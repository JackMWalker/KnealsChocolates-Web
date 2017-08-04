<?php
//delete product
if(isset($_GET['deleteid'])){
	echo 'Do you really want to delete this item with ID of '.$_GET['deleteid'].'? <a href="manage_'.$category.'.php?yesdelete='.$_GET['deleteid'].'">Yes</a> | <a href="manage_'.$category.'.php">No</a>';
	exit();
}
if(isset($_GET['yesdelete'])){
	//remove item from database and delete image
	$id_to_delete = $_GET['yesdelete'];
	$sql = $link->query("DELETE FROM products WHERE id='$id_to_delete' LIMIT 1")or die(mysqli_error());
	
	$imgName = $category.'/'.$id_to_delete.'.jpg';
	$eImgName = $category.'/'.$id_to_delete.'_'.$id_to_delete.'.jpg';
	$pictodelete = ("$docRoot/images/chocolates/$imgName");
	$extrapictodelete = ("$docRoot/images/chocolates/$eImgName");
	
	if(file_exists($pictodelete)){
		unlink($pictodelete);
	}
	if(file_exists($extrapictodelete)){
		unlink($extrapictodelete);
	}
	header("Location: manage_$category.php");
	exit();
}
?>
<?php
//insert new product into database and upload image to server
if(isset($_POST['ptitle'])){
	
	$productTitle = mysqli_real_escape_string($link, $_POST['ptitle']);
	$productPrice = mysqli_real_escape_string($link, $_POST['pprice']);
	$subcategory = mysqli_real_escape_string($link, $_POST['subcategory']);
	$weight = mysqli_real_escape_string($link, $_POST['weight']);
	$allergy = mysqli_real_escape_string($link, $_POST['allergy']);
	$description = mysqli_real_escape_string($link, $_POST['description']);
	$paypalurl = mysqli_real_escape_string($link, $_POST['paypalurl']);
	$postageCost = mysqli_real_escape_string($link, $_POST['postage']);
	$prevchocarray = implode( ';' , $_POST['prevchoc']);

	$sql = $link->query("SELECT id FROM products WHERE title='$productTitle' LIMIT 1");
	$productMatch = mysqli_num_rows($sql);
	if($productMatch>0){
		echo 'Sorry you tried to place a duplicate product name. <a href="manage_'.$category.'.php">Try Again.</a>';
		exit();
	}
	if($_FILES['fileField2']['name'] == null){
		$extraImage = false;
	}else{
		$extraImage = true;
	}
	
	$sql = $link->query("INSERT INTO products (title, price, weight, allergyinfo, description, category, subcategory, extraimg, dateadded, paypal_URL, postage_cost, preview_chocs) VALUES('$productTitle','$productPrice','$weight','$allergy','$description','$category','$subcategory','$extraImage',now(),'$paypalurl','$postageCost','$prevchocarray')")or die(mysql_error());
	$pid = mysqli_insert_id($link);
	$newName = $category.'/'.$pid.'.jpg';
	move_uploaded_file($_FILES['fileField']['tmp_name'],"$docRoot/images/chocolates/$newName");
	if($extraImage){
		$extraImgName = $category.'/'.$pid.'_'.$pid.'.jpg';
		move_uploaded_file($_FILES['fileField2']['tmp_name'],"$docRoot/images/chocolates/$extraImgName");
	}
	header("Location: manage_$category.php");
	exit();
}
?>
<?php
//show product list
$productList="";
$sql = $link->query("SELECT * FROM products WHERE category='$category'");
$productCount = mysqli_num_rows($sql);
if($productCount>0){
	while($row = mysqli_fetch_array($sql)){
		$id=$row['id'];
		$title=$row['title'];
		$price=$row['price'];
		$dateadded=$row['dateadded'];
		$productList .= "<p>ID-$id &nbsp;&nbsp;<b>$title</b> - $price &nbsp;- &nbsp;<i>Date added $dateadded</i>&nbsp; &nbsp; &nbsp; &nbsp; <a href='edit_$category.php?pid=$id'>edit</a> &bull; <a href='manage_$category.php?deleteid=$id'>delete</a></p>";
	}
}else{
	$productList .= 'You have no products listed in your store yet';
}
?>