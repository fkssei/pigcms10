<?php
//狗扑源码社区 www.gope.cn
class StoreWithdrawalViewModel extends ViewModel
{
	protected $viewFields = array(
		'StoreWithdrawal' => array('*'),
		'Store'           => array('name' => 'store', 'tel' => 'mobile', 0 => 'balance', '_on' => 'StoreWithdrawal.store_id = Store.store_id'),
		'User'            => array(0 => 'nickname', 'phone' => 'tel', '_on' => 'StoreWithdrawal.uid = User.uid'),
		'Bank'            => array('name' => 'bank', '_on' => 'StoreWithdrawal.bank_id = Bank.bank_id')
		);

	public function getWithdrawalStatus()
	{
		return array(1 => '申请中', 2 => '银行处理中', 3 => '提现成功', 4 => '提现失败');
	}
}

?>
