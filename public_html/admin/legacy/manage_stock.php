<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/inc/init.php';

if(isset($_POST['id']))
{
	$id = $_POST['id'];
	if(isset($_POST['change']))
	{
		$db_eshop = EShopDB::inst();
		$change = $_POST['change'];

		if($change == "dec")
		{
			$update_query = "UPDATE products SET stock = stock - 1 WHERE id = ?";
		}
		else if($change == "inc")
		{
			$update_query = "UPDATE products SET stock = stock + 1 WHERE id = ?";
		}
		else
		{
			$stock = "error";
		}
		
		$update_result = $db_eshop -> query($update_query, $id);

		$sql_query = "SELECT stock FROM products WHERE id = ?";
		$sql_result = $db_eshop -> query($sql_query, $id);
		if ($sql_result->rowCount() > 0){
			while($row = $sql_result->fetch(PDO::FETCH_ASSOC)){
				if(!isset($stock))
				{
					$stock = $row["stock"];
				}
			}
		}

		echo json_encode(array(
		    "stock" => "{$stock}",
		));
	}
	else if(isset($_POST['live']))
	{
		$db_eshop = EShopDB::inst();
		$live = $_POST['live'];
		if($live)
		{
			$update_query = "UPDATE products SET live = 0 WHERE id = ?";
		}
		else 
		{
			$update_query = "UPDATE products SET live = 1 WHERE id = ?";
		}

		$update_result = $db_eshop -> query($update_query, $id);

		if($live)
			$live = 0;
		else
			$live = 1;

		echo json_encode(array(
		    "live" => "{$live}"
		));
	}
	else if(isset($_POST['priority_change']))
	{
		$db_eshop = EShopDB::inst();
		$priority_change = $_POST['priority_change'];
		$orig_priority = $_POST['priority'];
		$orig_id = $id; // to make var names simple

		if($priority_change == "dec")
		{
			$priority_query = "SELECT id, priority FROM products WHERE priority < ? ORDER BY priority DESC LIMIT 1";

		}
		else if($priority_change == "inc")
		{
			$priority_query = "SELECT id, priority FROM products WHERE priority > ? ORDER BY priority ASC LIMIT 1";
		}

		$priority_result = $db_eshop -> query($priority_query, $orig_priority);

		if ($priority_result->rowCount() > 0){
			while($row = $priority_result->fetch(PDO::FETCH_ASSOC)){
				$new_priority = $row['priority'];
				$new_id = $row['id'];
			}

			$update_query1 = "UPDATE products SET priority = ? WHERE id = ?";
			$update_query2 = "UPDATE products SET priority = ? WHERE id = ?";
			$update_result1 = $db_eshop -> query($update_query1, $orig_priority, $new_id);
			$update_result2 = $db_eshop -> query($update_query2, $new_priority, $orig_id);
		}	

		$manage_shop_text = "";

		$sql_query = "SELECT * FROM products WHERE category = ? OR category = ? ORDER BY priority";
		$sql_result = $db_eshop -> query($sql_query, "luxury", "bars");

		if ($sql_result->rowCount() > 0){
			while($row = $sql_result->fetch(PDO::FETCH_ASSOC)){
				$id = $row['id'];
				$title = $row['title'];
				$price = format_price($row['price']);
				$live = $row['live'];
				$category = $row['category'];
				$priority = $row['priority'];
				$stock = $row['stock'];

				$is_live = $live ? ' active' : '';

				print '<div class="e-p-wrapper">
						<div class="e-p-title">
							<h3>'.$title.'</h3>
						</div>
						<div class="e-p-image">
							<span class="priority-mod left" data-change="inc" data-pID="'.$id.'" data-priority="'.$priority.'">+</span>
							<img src="/images/chocolates/'.$category.'/'.$id.'.png" alt="'.$title.'" width="180">
							<span class="priority-mod right" data-change="dec" data-pID="'.$id.'" data-priority="'.$priority.'">-</span>
						</div>
						<div class="e-p-info">
							<span class="e-p-price">'.$price.'</span>
							<div class="e-p-stock">
								<span class="caption">Stock</span>
								<span class="stock-mod left" data-change="dec" data-pID="'.$id.'">-</span>
								<input type="text" class="stock-value" size=1 value="'.$stock.'" readonly>
								<span class="stock-mod right" data-change="inc" data-pID="'.$id.'">+</span>
							</div>
						</div>
						<div class="e-p-functions">
							<a class="edit-product disabled" data-pID="'.$id.'">edit</a>
							<a class="toggle-live'.$is_live.'" data-pID="'.$id.'" data-isLive="'.$live.'"><span class="bullet">&#8226;</span><span class="not"> Not</span> Live</a>
						</div>
					</div>';

			}
		}

	}
	else
	{
		return false;
	}
}
else
{
	return false;
}
?>