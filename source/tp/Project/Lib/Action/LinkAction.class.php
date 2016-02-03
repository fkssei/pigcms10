<?php
//狗扑源码社区 www.gope.cn
class LinkAction extends BaseAction
{
	public $modules;

	public function _initialize()
	{
		parent::_initialize();
		$this->modules = array('Home' => '首页', 'Group' => '团购', 'Meal' => '订餐', 'Meal_order' => '订餐订单', 'Group_order' => '团购订单', 'Group_collect' => '团购收藏', 'Card_list' => '我的优惠券', 'Member' => '会员中心');
	}

	public function insert()
	{
		$modules = $this->modules();
		$this->assign('modules', $modules);
		$this->display();
	}

	public function modules()
	{
		$t = array(
			array('module' => 'Home', 'linkcode' => str_replace('admin.php', 'wap.php', U('Wap/Home/index', '', true, false, true)), 'name' => '微站首页', 'sub' => 0, 'canselected' => 1, 'linkurl' => '', 'keyword' => $this->modules['Home'], 'askeyword' => 1),
			array('module' => 'Group', 'linkcode' => str_replace('admin.php', 'wap.php', U('Wap/Group/index', '', true, false, true)), 'name' => $this->modules['Group'], 'sub' => 0, 'canselected' => 1, 'linkurl' => '', 'keyword' => '', 'askeyword' => 1),
			array('module' => 'Meal', 'linkcode' => str_replace('admin.php', 'wap.php', U('Wap/Meal_list/index', '', true, false, true)), 'name' => $this->modules['Meal'], 'sub' => 0, 'canselected' => 1, 'linkurl' => '', 'keyword' => '', 'askeyword' => 1),
			array('module' => 'Meal_order', 'linkcode' => str_replace('admin.php', 'wap.php', U('Wap/My/Meal_order_list', '', true, false, true)), 'name' => $this->modules['Meal_order'], 'sub' => 0, 'canselected' => 1, 'linkurl' => '', 'keyword' => '', 'askeyword' => 1),
			array('module' => 'Group_order', 'linkcode' => str_replace('admin.php', 'wap.php', U('Wap/My/group_order_list', '', true, false, true)), 'name' => $this->modules['Group_order'], 'sub' => 0, 'canselected' => 1, 'linkurl' => '', 'keyword' => '', 'askeyword' => 1),
			array('module' => 'Group_collect', 'linkcode' => str_replace('admin.php', 'wap.php', U('Wap/My/group_collect', '', true, false, true)), 'name' => $this->modules['Group_collect'], 'sub' => 0, 'canselected' => 1, 'linkurl' => '', 'keyword' => '', 'askeyword' => 1),
			array('module' => 'Card_list', 'linkcode' => str_replace('admin.php', 'wap.php', U('Wap/My/card_list', '', true, false, true)), 'name' => $this->modules['Card_list'], 'sub' => 0, 'canselected' => 1, 'linkurl' => '', 'keyword' => '', 'askeyword' => 1),
			array('module' => 'Member', 'linkcode' => str_replace('admin.php', 'wap.php', U('Wap/My/index', '', true, false, true)), 'name' => $this->modules['Member'], 'sub' => 0, 'canselected' => 1, 'linkurl' => '', 'keyword' => '', 'askeyword' => 1)
			);
		return $t;
	}
}

?>
