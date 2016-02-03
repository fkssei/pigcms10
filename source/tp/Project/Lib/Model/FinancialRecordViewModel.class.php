<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class FinancialRecordViewModel extends ViewModel
{
	protected $viewFields = array(
		'FinancialRecord' => array('*'),
		'Store'           => array('name' => 'store', 'tel' => 'mobile', 0 => 'balance', '_on' => 'FinancialRecord.store_id = Store.store_id')
		);
}

?>
