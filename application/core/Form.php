<?php

class Form
{
	
	public static function init($action, $method, array $params = null)
	{
		return '<form action"' .$action. '" method="' .$method. '">';

	}
	
	public static function input($name, $type, array $params = null, $outer = null) {
		//stop undefined variable
		$param = null;
		foreach($params as $arg => $key)
		{
			$param .= ' '.$arg.'="'.$key.'"';
		}
		return '<input name="'.$name.'" type="'.$type.'"'.$param.'>'.$outer;;
	}
	
	public static function validator(array $inputs = null)
	{
		$validators = array(
			'min:chars' => 'You have not put enough characters. Minimum :chars',
			'max:chars' => 'You have put more than :chars ',
			'required'  => 'This input is required',
			//'passrepeat' => '',
			);
			
		foreach($inputs as $input => $key):
			
		endforeach;
	}
		public static function categories()
	{
		echo '<select name="categories" class="form-control col-sm-12">';
		echo '<option>'.System::translate('Choose an option').'</option>';
		
			$i = 0;
		    $mainCatName = '';
			foreach(ProductModel::categories() as $category): 
				if($category->main_category != $mainCatName) {
					$mainCatName = $category->main_category;
					if($i = 0) { 
						echo '<optgroup label="'.$category->main_category.'">';
					} else {
						echo '';
						echo '<optgroup label="'.$category->main_category.'">';
					}
				}
				
			    echo '<option value="'.System::escape($category->sub_category).'">'.System::escape($category->sub_category).'</option>'; 
				$i++;
			    endforeach;
		echo '</select>';
	
	}
	
	
	public static function Linkcategories()
	{
			$i = 0;
		    $mainCatName = '';
			foreach(ProductModel::categories() as $category): 
				if($category->main_category != $mainCatName) {
					$mainCatName = $category->main_category;
					if($i = 0) { 
						echo '<b>'.$category->main_category.'</b>';
					} else {
						echo '<b>'.$category->main_category.'</b>';
					}
				}
				
			    echo '<a href="'.Config::get('URL').'products/search?categories='.System::escape($category->sub_category).'">'.System::escape($category->sub_category).'</a>'; 
				$i++;
			    endforeach;
	
	}

}