<?php
class ViewTransactions
{
	private $_db ;
	private $_data = array() ; 
	private $_errors = array() ;


	public function __construct()
	{
		$this->_db = EShopDB::inst();

		$query = 'SELECT ct.product_id_list, ct.quantity_list, ct.price, pt.created, pt.payer_name, pt.line1, pt.line2, pt.postal_code, pt.city FROM cart_transactions AS ct INNER JOIN paypal_transaction AS pt ON ct.id = pt.transaction_id ORDER BY pt.created DESC' ;

		$result = $this->_db->query($query) ;	
		if($result->rowCount() > 0)
		{
			while($row = $result->fetch(PDO::FETCH_ASSOC))
			{
				array_push($this->_data, $row) ;
			}
		}	
	}

	public function show_list()
	{
		$rtn = "<table>
				<thead>
					<tr>
						<th style='width:80px;'>Created</th>
						<th>Products</th>
						<th style='width:150px;'>Address</th>
						<th style='width:100px;'>Price</th>
					</tr>
				</thead>
				<tbody>";

		foreach ($this->_data as $data) 
		{
			$rtn .= '<tr>';
			$product_ids_list = $data['product_id_list'];
			$quantity_list = $data['quantity_list'];
		    $price = format_view_price($data['price']);
		    $payer_name = $data['payer_name'];
			$line1 = $data['line1'];
		    $line2 = $data['line2'];
		    $postal_code = $data['postal_code'];
		    $city = $data['city'];
		    $created = $data['created'];

		    $product_ids = explode(';', $product_ids_list);
			$quantities = explode(';', $quantity_list);

			$i = 0;

			$rtn .= '<td>'.$created.'</td>';
			$rtn .= '<td>';

			foreach ($product_ids as $product_id) 
			{
			    $extra_deets = false;
			    
			    if(strpos($product_id, ':') !== false)
			    {
			        $product_id_parts = explode(':', $product_id);
			        $product_id = $product_id_parts[0];
			        $choc_id_string = $product_id_parts[1];
			        $extra_deets = true;
			    }
			    
			   
				$query = "SELECT title, price FROM products WHERE id = ?";
				$result = $db_eshop -> query($query, $product_id);

				while($row = $result->fetch(PDO::FETCH_ASSOC)) 
			    {
			        $temp_title = $row['title'];
			        if($extra_deets)
			        {
			            $temp_title .= '<span style="font-size:12px;"> - ';
			            $chocIDs = explode(',', $choc_id_string);
			            foreach ($chocIDs as $chocID) 
			            {
			                $query2 = "SELECT title FROM individual_chocs WHERE id = ?";
			                $result2 = $this->_db->query($query2, $chocID);
			                if($result2->rowCount() > 0)
			                {
			                    while($row2 = $result2->fetch(PDO::FETCH_ASSOC))
			                    {
			                        $substr = $row2['title'];
			                        $temp_title .= $substr.', ';
			                    }
			                }
			            }
			            $temp_title = rtrim($temp_title, ', ');
			            $temp_title .= '</span>';
			        }

					$rtn .= '<b>'.$quantities[$i].'x</b> '.$temp_title.'<br>';
					
				}

				$address_f = makeAddress($line1, $line2, $city, $postal_code, true);
				$i++;

				$rtn .= '</td>';
				$rtn .= '<td><u>'. $payer_name.'</u><br>'.$address_f.'</td>';
				$rtn .= '<td>'.$price.'</td>';
				$rtn .= '</tr>';
			}
		}
		$rtn .= "</tr>
				</tbody>
			</table>";

		print $rtn;

	}


}