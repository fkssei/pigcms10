<?php
class activity_model extends base_model{

	public function getActivity($type,$num=10){
		$data 	= D('Activity_recommend')->where("model='$type'")->order('id DESC')->limit($num)->select();

		$res  	= array();
		
		foreach ($data as $key => $value) {
			$res[$key]['name'] 		= $value['title'];
			$res[$key]['intro'] 	= $value['info'];
			$res[$key]['token'] 	= $value['token'];
			$res[$key]['image'] 	= $value['image'];
			$res[$key]['count'] 	= $value['ucount'];
			$res[$key]['appurl'] 	= $this->createUrl($value,$type);
			$res[$key]['time'] 	= $value['time'];
		}

		return $res;

	}

	public function getHotActivity($num,$type="",$rank=""){
		$where 	= "is_rec=1";
		if($type != ''){
			$where	 .= " AND model='$type'";
			$order  = 'id DESC';
		}
		if($rank){
			$order 	= 'ucount DESC';
		}else{
			$order  = 'id DESC';
		}
		$data 	= D('Activity_recommend')->where($where)->order($order)->limit($num)->select();

		$res  	= array();
		
		foreach ($data as $key => $value) {
			$res[$key]['name'] 		= $value['title'];
			$res[$key]['intro'] 	= $value['info'];
			$res[$key]['token'] 	= $value['token'];
			$res[$key]['image'] 	= $value['image'];
			$res[$key]['count'] 	= $value['ucount'];
			$res[$key]['appurl'] 	= $this->createUrl($value,$type);
			$res[$key]['time'] 	= $value['time'];
		}

		return $res;
	}

	public function createUrl($val,$type,$trueurl=0){
		$activity_url 	= option('config.syn_domain') ? rtrim(option('config.syn_domain'),'/').'/' : 'http://demo.pigcms.cn/';

		if($type == 'unitary'){
			$url 	= $activity_url.'/index.php?g=Wap&m='.ucfirst($val['model']).'&a=goods&token='.$val['token'].'&unitaryid='.$val['modelId'];
		}else if($type == 'cutprice'){
			$url 	= $activity_url.'/index.php?g=Wap&m='.ucfirst($val['model']).'&a=goods&token='.$val['token'].'&id='.$val['modelId'];
		}else{
			$url 	= $activity_url.'/index.php?g=Wap&m='.ucfirst($val['model']).'&a=index&token='.$val['token'].'&id='.$val['modelId'];
		}

		if($trueurl){
			return $url;
		}else{
			return urlencode($url);
		}
	}


}