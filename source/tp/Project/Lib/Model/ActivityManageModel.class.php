<?php
class ActivityManageModel extends Model{
	//数据转换
	public function bargainData($data){
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['pigcms_id'];
			$return[$key]['title'] = $val['name'];
			$return[$key]['info'] = $val['wxinfo'];
			$return[$key]['image'] = $val['wxpic'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['addtime'];
		}
		return $return;
	}
	public function crowdfundingData($data){
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['name'];
			$return[$key]['info'] = $val['intro'];
			$return[$key]['image'] = $val['pic'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['start'];
		}
		return $return;
	}
	public function cutpriceData($data){
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['pigcms_id'];
			$return[$key]['title'] = $val['name'];
			$return[$key]['info'] = $val['wxinfo'];
			$return[$key]['image'] = $val['wxpic'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['addtime'];			
		}
		return $return;
	}
	public function red_packetData($data){
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['title'];
			$return[$key]['info'] = $val['desc'];
			$return[$key]['image'] = $val['msg_pic'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['start_time'];
		}
		return $return;
	}
	public function seckillData($data){
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['action_id'];
			$return[$key]['title'] = $val['action_name'];
			$return[$key]['info'] = $val['reply_content'];
			$return[$key]['image'] = $val['action_header_img'];
			$return[$key]['token'] = $val['action_token'];
			$return[$key]['time'] = $val['action_sdate'];
		}
		return $return;
	}
	public function unitaryData($data){
		$return = array();
		foreach($data as $key=>$val){
			$return[$key]['modelId'] = $val['id'];
			$return[$key]['title'] = $val['name'];
			$return[$key]['info'] = $val['wxinfo'];
			$return[$key]['image'] = $val['logopic'];
			$return[$key]['token'] = $val['token'];
			$return[$key]['time'] = $val['addtime'];
		}
		return $return;
	}
}

?>