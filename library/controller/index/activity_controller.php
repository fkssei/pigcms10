<?php
class activity_controller extends base_controller{

	public function index() {
		//热门活动
		$this->assign('hot_kanjia',M('Activity')->getHotActivity(10,'bargain'));
		$this->assign('hot_miaosha',M('Activity')->getHotActivity(8,'seckill'));
		$this->assign('hot_zhongchou',M('Activity')->getHotActivity(8,'crowdfunding'));
		$this->assign('hot_duobao',M('Activity')->getHotActivity(8,'unitary'));
		$this->assign('hot_jiangjia',M('Activity')->getHotActivity(8,'cutprice'));

		//附近活动

		$this->assign('kanjia',M('Activity')->getActivity('bargain',10));
		$this->assign('miaosha',M('Activity')->getActivity('seckill',8));
		$this->assign('zhongchou',M('Activity')->getActivity('crowdfunding',8));
		$this->assign('duobao',M('Activity')->getActivity('unitary',8));
		$this->assign('jiangjia',M('Activity')->getActivity('cutprice',8));

		$recommend	= M('Activity')->getHotActivity(1,'',1); //人气推荐
		//幻灯片
		$slider 	= M('Adver')->get_adver_by_key('pc_activity_slider',6);
		//热门活动
		$hot 		= M('Adver')->get_adver_by_key('pc_activity_hot',4);
		//附近活动
		$nearby 	= M('Adver')->get_adver_by_key('pc_activity_nearby',4);

		$this->assign('slider',$slider);
		$this->assign('recommend',$recommend[0]);
		$this->assign('hot',$hot);
		$this->assign('nearby',$nearby);

		$this->display();
	}
}