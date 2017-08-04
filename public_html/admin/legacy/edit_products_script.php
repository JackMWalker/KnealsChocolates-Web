<?php
if(isset($_GET['pid'])){
$targetID = $_GET['pid'];
$sql = $link->query("SELECT * FROM products WHERE id='$targetID'");
$productCount = mysqli_num_rows($sql);
if($productCount>0){
	while($row = mysqli_fetch_array($sql)){
		$title=$row['title'];
		$price=$row['price'];
		$subcategory=$row['subcategory'];
		$weight=$row['weight'];
		$allergy=$row['allergyinfo'];
		$desc=$row['description'];
		$paypalURL=$row['paypal_URL'];
		$postage=$row['postage_cost'];
	}
}else{
	echo 'This product doesn\'t exist. <a href="manage_'.$category.'.php">Try Again.</a>';
	exit();
}
}
?>
<?php
//insert new product into database and upload image to server
if(isset($_POST['ptitle'])){

	$pid = mysqli_real_escape_string($link, $_POST['thisID']);
	$productTitle = mysqli_real_escape_string($link, $_POST['ptitle']);
	$productPrice = mysqli_real_escape_string($link, $_POST['pprice']);
	$subcategory = mysqli_real_escape_string($link, $_POST['subcategory']);
	$productWeight = mysqli_real_escape_string($link, $_POST['weight']);
	$allergy = mysqli_real_escape_string($link, $_POST['allergy']);
	$paypal_URL = mysqli_real_escape_string($link, $_POST['paypalurl']);
	$description = mysqli_real_escape_string($link, $_POST['description']);
	$postageCost = mysqli_real_escape_string($link, $_POST['postage']);
	if(isset($_POST['prevchoc'])){
		$prevchocarray = implode( ';' , $_POST['prevchoc']);
		$sql = $link->query("UPDATE products SET title='$productTitle',price='$productPrice',weight='$productWeight',allergyinfo='$allergy',description='$description',subcategory='$subcategory',paypal_URL='$paypal_URL',postage_cost='$postageCost',preview_chocs='$prevchocarray' WHERE id='$pid'");
	} else {
		$sql = $link->query("UPDATE products SET title='$productTitle',price='$productPrice',weight='$productWeight',allergyinfo='$allergy',description='$description',subcategory='$subcategory',paypal_URL='$paypal_URL',postage_cost='$postageCost' WHERE id='$pid'");
	}

	if($_FILES['fileField']['tmp_name']!=""){
		$newName = $category.'/'.$pid.'.jpg';
		move_uploaded_file($_FILES['fileField']['tmp_name'],"$docRoot/images/chocolates/$newName");
	}
	if($_FILES['fileField2']['tmp_name']!=""){
		$extraImgName = $category.'/'.$pid.'_'.$pid.'.jpg';
		move_uploaded_file($_FILES['fileField2']['tmp_name'],"$docRoot/images/chocolates/$extraImgName");
	}
header("Location: manage_$category.php");
exit();
}
?>