<?php
class AdminEditProduct
{
	private $_db ; // Database Connection
	private $_details = array() ; // product details
	private $_next_product = null ; // next highest priority Product()
	private $_prev_product = null ; // previous lowest priority Product()
	private $_errors = array() ; // Array of errors

	public function __construct($product_id = null)
	{
		$this->_db = EShopDB::inst() ;
		$this->find($product_id) ; 
	}

	public function display_edit_product()
	{
		$productDisplay = "";
		$optionTitle = array();
		$optionDesc = array();
		$optionId = array();
		$optionAllergy = array();

		$prevchocarray = explode(';', $this->_details['preview_chocs']);

		$productDisplay .= '<form action="" method="post">';		
		//check for extra image and create preview image
		$previewImg = '<div class="extra-product-image"><img width="62" height="47" alt="'.$this->_details['title'].'" class="thumb" src="/images/chocolates/'.$this->_details['category'].'/'.$this->_details['id'].'.png">';

		if($this->_details['extraimg'] == 1)
			$previewImg .= '<img width="62" height="47" alt="'.$this->_details['title'].'" class="thumb" src="/images/chocolates/'.$this->_details['category'].'/'.$this->_details['id'].'_'.$this->_details['id'].'.png"></div>';
		else
			$previewImg .= "</div>";
		
		if($this->_details['live'] == 1 || $edit == true) 
		{
			$productDisplay .=
			'<div class="product-container col-xs-10 col-xs-offset-1">
				<div class="product-title-container col-xs-12">
					<div class="product-page-title col-xs-10"><input type"text" name="title" value="'.$this->_details['title'] .'"> (<input type"text" name="weight" size=4 value="'. $this->_details['weight'].'">g)</div>
					<div class="product-page-price col-xs-2">
						<input type"text" name="price" size=4 value="'.($this->_details['price']/100).'">
						<a href="/post_packaging/" class="tiny-link">(P&P Terms)</a></div>
				</div>
				<div class="images-container col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-0">
					<div class="main-product-image"><span><a class="mainimg1" id="singleimg" href="/images/chocolates/'.$this->_details['category'].'/'.$this->_details['id'].'.png"><img width="300" height="210" alt="'.$title.'" class="mainimg img-responsive" src="/images/chocolates/'.$this->_details['category'].'/'.$this->_details['id'].'.png"></a></span></div>
					<div class="thumbnail-product-images">'.$previewImg.'</div>
				</div>
				<div class="product-info-container col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-0">
					<div class="product-page-desc"><h6>Description:</h6><p><textarea row="3" cols="20" name="description">'.$this->_details['description'].'</textarea></p></div>
					<div class="product-page-allergy"><h6>Allergy Info:</h6><p><textarea row="3" cols="20" name="allergyinfo">'.$this->_details['allergyinfo'].'</textarea></p></div>';

				if($this->_details['category'] == 'bars')
				{
					$sql1_query = "SELECT * FROM individual_chocs WHERE category = ?";
					$sql1_result = $db_eshop -> query($sql1_query, $this->_details['category']);
					if ($sql1_result->rowCount() > 0)
					{
						while($row1 = $sql1_result->fetch(PDO::FETCH_ASSOC)){
							array_push($optionId, $row1['id']);
							array_push($optionTitle, $row1['title']);
							array_push($optionDesc, $row1['description']);
							array_push($optionAllergy, $row1['allergens']);
						}
					}
					$productDisplay .= "<div class='bar-selection-container'>";

					for($i = 0; $i < $this->_details['options']; $i++)
					{
						$productDisplay .= "<select class='bar-menu'>";
						
						for($j=0; $j<count($optionTitle); $j++)
						{
							$productDisplay .= "<option value='{$optionId[$j]}'>{$itb}{$optionTitle[$j]}{$ic}</option>";
						}

						$productDisplay .= "</select>";
					}

					$productDisplay .= "</div>";
				}

				$productDisplay .= '</div><div class="product-buy-now">';
				
				$productDisplay .= '<input type="hidden" name="token" value="'.Token::generate().'">
									<input type="submit" value="Save Changes" class="btn btn-default">' ;

				$productDisplay .= '</form>
									</div>
								</div>';	
		}

		if(strlen($this->_details['preview_chocs']) > 0) 
		{
			foreach($prevchocarray as $chocID)
			{
				$sql2_query = "SELECT * FROM individual_chocs WHERE id = ?";
				$sql2_result = $this->_db->query($sql2_query, $chocID);
				if ($sql2_result->rowCount() > 0)
				{
					while($row2 = $sql2_result->fetch(PDO::FETCH_ASSOC))
					{
						array_push($optionId, $row2['id']);
						array_push($optionTitle, $row2['title']);
						array_push($optionDesc, $row2['description']);
						array_push($optionAllergy, $row2['allergens']);
					}
				}
			}
			
			$prevChocDisplay = '<div class="col-xs-10 col-xs-offset-1"><h4 class="individual-chocs-title">What&#39;s in the box</h4>';
			for ($i = 0; $i < count($optionId); ++$i) 
			{
				$prevChocDisplay .= 
				'<div class="p-i-container col-xs-6 col-sm-4 col-md-3">
					<div class="p-i-title">'.$optionTitle[$i].'</div>
					<div class="p-i-image"><img width="140" height="85" alt="'.$optionId[$i].'" class="p-image" src="/images/chocolates/preview_chocs/'.$optionId[$i].'.jpg"></div>
					<div class="p-i-desc">'.$optionDesc[$i].'</div>';
					if($optionAllergy[$i] != '')
					{
						$prevChocDisplay .= '<div class="p-i-allergy"><b><u>Allergens</u>: '.$optionAllergy[$i].'</b></div>';
					}
				$prevChocDisplay .=  '</div>
				';
   			}
   			$prevChocDisplay .= '</div>';
		}
		elseif($this->_details['options'] != '' && isset($optionAllergy))
		{
			$prevChocDisplay = '<div class="col-xs-10 col-xs-offset-1"><h4 class="individual-chocs-title">What&#39;s in the box</h4>';

			for($j = 0; $j < count($optionId); ++$j)
			{
 					$prevChocDisplay .= 
 					'<div class="p-i-container col-xs-6 col-sm-4 col-md-3">
 						<div class="p-i-title">'.$optionTitle[$j].'</div>
 						<div class="p-i-image">
 							<a href="/images/chocolates/preview_chocs/'.$optionId[$j].'.png" rel="gallery">
 								<img width="140" height="85" alt="'.$optionTitle[$j].'" class="p-image" src="/images/chocolates/preview_chocs/'.$optionId[$j].'.png">
 							</a>
 						</div>
 						<div class="p-i-desc">'.$optionDesc[$j].'</div>
 						<div class="p-i-allergy"><b><u>Allergens</u>: '.$optionAllergy[$j].'</b></div>
 					</div>
 					';
 			}
   			$prevChocDisplay .= '</div>';
		}
		else
		{
			$prevChocDisplay = '';
		}

		echo $productDisplay . "<br>";
		echo $prevChocDisplay;
	}


	public function display_view_product()
	{

	}


	/**
	 *  Takes a string of either 'inc' or 'dec' and @return returns whether it managed to successfully change the priority,
	 *  else an error is given.
	 */
	public function priority_change($change)
	{
		if($change == 'inc')
		{
			return $this->priority_up() ;
		}
		elseif($change == 'dec')
		{
			return $this->priority_down() ;
		}
		else
		{
			$this->add_error('Unrecognised change value') ;
		}

		return false ;
	}

	/**
	 * @return Returns the new live state after changing it in the db
	 */
	public function toggle_live()
	{
		if(!$this->_details['live'])
			$new_live = 1;
		else 
			$new_live = 0;

		$update_query = "UPDATE products SET live = ? WHERE id = ?";
		$this->_db->query($update_query, $new_live, $this->_details['id']);
		$this->_details['live'] = $new_live ;
		return $this->_details['live'] ; 
	}

	public function change_stock($dir, $val = null)
	{
		$update_query = "";
		$stock_value = $this->_details['stock'];

		if(!is_null($val) && $val >= 0)
		{
			$stock_value = $val ;
		}
		elseif($dir == 'inc')
		{
			$stock_value++ ;
		}
		elseif($dir == 'dec')
		{
			if($stock_value > 0)
				$stock_value-- ;
		}
		else
		{
			$this->add_error('No direction or value given.');
		}

		$update_query = "UPDATE products SET stock = ? WHERE id = ?";
		$this->_db->query($update_query, $stock_value, $this->_details['id']);
		$this->_details['stock'] = $stock_value ;
		return $this->_details['stock'] ;
	}


	public function get_data()
	{
		return $this->_details ;
	}


	public function get_errors()
	{
		return $this->_errors;
	}


	private function priority_up()
	{
		if(!is_null($this->next_priority()))
		{
			$next_data = $this->_next_product->get_data() ;

			$update_query = "UPDATE products SET priority = ? WHERE id = ?";
			$update_result = $this->_db->query($update_query, $this->_details['priority'], $next_data['id']);
			$update_result2 = $this->_db->query($update_query, $next_data['priority'], $this->_details['id']);

			$this->_details['priority'] = $next_data['priority'] ;
			return true ;
		}
		else
		{
			$this->add_error('No one is higher than you') ;
		}

		return false ;	
	}

	private function priority_down()
	{
		if(!is_null($this->previous_priority()))
		{
			$prev_data = $this->_prev_product->get_data() ;

			$update_query = "UPDATE products SET priority = ? WHERE id = ?";
			$update_result = $this->_db->query($update_query, $this->_details['priority'], $prev_data['id']);
			$update_result2 = $this->_db->query($update_query, $prev_data['priority'], $this->_details['id']);

			$this->_details['priority'] = $next_data['priority'] ;
			return true ;
		}
		else
		{
			$this->add_error('No one is worse than you') ;
		}

		return false ;
	}

	/**
	 * @return Returns the next priority Product
	 */
	private function next_priority()
	{
		$priority_query = "SELECT id FROM products WHERE priority > ? ORDER BY priority ASC LIMIT 1";
		$result = $this->_db->query($priority_query, $this->_details['priority']);
		$this->add_error($this->_details['priority']);

		if($result->rowCount() > 0)
		{
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$this->_next_product = new Product($row['id']) ;
		}
		else
		{
			$this->add_error('You are the best.');
		}

		return $this->_next_product ;
	}

	/**
	 * @return Returns the previous priority Product
	 */
	private function previous_priority()
	{
		$priority_query = "SELECT id FROM products WHERE priority < ? ORDER BY priority DESC LIMIT 1";
		$result = $this->_db->query($priority_query, $this->_details['priority']);

		if($result->rowCount() > 0)
		{
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$this->_prev_product = new Product($row['id']) ;
		}
		else
		{
			$this->add_error('You are the worst.');
		}

		return $this->_prev_product ;
	}

	/** 
	 *  @return Returns true if we find a product relating to the id given in the constructor
	 */
	private function find($id)
	{
		if(isset($id))
		{
			$result = $this->_db->query('SELECT * FROM products WHERE id = ? LIMIT 1', $id) ;
			if($result->rowCount() > 0)
			{
				$row = $result->fetch(PDO::FETCH_ASSOC);
				$this->_details = $row ;
				return true;
			}
			else
			{
				$this->add_error('Could not find user: '.$user);
			}
		}
		return false;
	}

	private function add_error($error)
	{
		array_push($this->_errors, $error) ;
		
	}

} 