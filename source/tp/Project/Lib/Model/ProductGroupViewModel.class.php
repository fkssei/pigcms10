<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class ProductGroupViewModel extends ViewModel
{
	public $viewFields = array(
		'ProductGroup' => array('*'),
		'Store'        => array('name' => 'store', '_on' => 'ProductGroup.store_id = Store.store_id')
		);
}

?>
