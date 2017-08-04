<?php
class AdminBrowseProducts
{
	private $_db ;
	private $_data = array();
	private $_errors = array();

	public function __construct($query_terms = array())
	{
		$this->_db = EShopDB::inst();

		$query = 'SELECT * FROM products ' ;
		if(count($query_terms))
		{
			$query .= 'WHERE ';
			foreach ($query_terms as $term) 
			{
				$query .= $term.' ';
			}
		}
		$query .= 'ORDER BY priority ';
		
		$result = $this->_db->query($query); 

		if($result->rowCount())
		{
			while($row = $result->fetch(PDO::FETCH_ASSOC))
			{
				array_push($this->_data, $row) ;
			}
		}
		else
		{
			$this->add_error('Could not find any products.') ;
		}

	}

	public function show_list()
	{
		$rtn = '' ;

		if(isset($this->_data))
		{
			foreach ($this->_data as $data) 
			{
				$rtn .= $this->create_preview($data) ;
			}
		}
		else
		{
			$this->add_error('Could not find any products.') ;
			$rtn .= 'No results.' ;
		}

		print $rtn ;
	}

	private function create_preview($data)
	{
		$is_live = $data['live'] ? ' active' : '';
		$priority_min_max_ids = $this->find_highest_lowest_priority();
		$rtn  = '<div class="e-p-wrapper">
				<div class="e-p-title">
					<h3>'.$data['title'].'</h3>
				</div>
				<div class="e-p-image">';
					if($priority_min_max_ids[0] != $data['id'])
					{
						$rtn .= '<span class="priority-mod left" data-change="dec" data-pID="'.$data['id'].'" data-priority="'.$data['priority'].'">+</span>';
					}

					$rtn .=	'<img src="/images/chocolates/'.$data['category'].'/'.$data['id'].'.png" alt="'.$data['title'].'" width="180">';

					if($priority_min_max_ids[1] != $data['id'])
					{
						$rtn .= '<span class="priority-mod right" data-change="inc" data-pID="'.$data['id'].'" data-priority="'.$data['priority'].'">-</span>';
					}
		$rtn .=	'</div>
				<div class="e-p-info">
					<span class="e-p-price">'.format_price($data['price']).'</span>
					<div class="e-p-stock">
						<span class="caption">Stock</span>
						<span class="stock-mod left" data-change="dec" data-pID="'.$data['id'].'">-</span>
						<input type="text" class="stock-value" size=1 value="'.$data['stock'].'" readonly>
						<span class="stock-mod right" data-change="inc" data-pID="'.$data['id'].'">+</span>
					</div>
				</div>
				<div class="e-p-functions">
					<a class="edit-product" href="/admin/manage_product/?id='.$data['id'].'">edit</a>
					<a class="toggle-live'.$is_live.'" data-pID="'.$data['id'].'" data-isLive="'.$data['live'].'"><span class="bullet">&#8226;</span><span class="not"> Not</span> Live</a>
				</div>
			</div>' ;

		return $rtn ;

	}

	private function find_highest_lowest_priority()
	{
		$highest = null;
		$lowest = null;
		$lowest_id = null;
		$highest_id = null;

		foreach ($this->_data as $data) 
		{
			if(is_null($highest) && is_null($lowest))
			{
				$highest = $data['priority'];
				$lowest = $highest;
				$lowest_id = $data['id'];
				$highest_id = $lowest_id;

			}

			if($data['priority'] > $highest)
			{
				$highest = $data['priority'];
				$highest_id = $data['id'];
			}
			if($data['priority'] < $lowest)
			{
				$lowest = $data['priority'];
				$lowest_id = $data['id'];
			}
		}

		return array($lowest_id, $highest_id) ;
	}

	public function get_errors()
	{
		return $this->_errors;
	}

	private function add_error($error)
	{
		array_push($this->_errors, $error) ;
		
	}
}