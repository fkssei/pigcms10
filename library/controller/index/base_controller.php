<?php
/**
 * 基础类
 *
 */
class base_controller extends controller{
	public $user_session;
	public $cart_number;
	
	public function __construct(){
		parent::__construct();
		$this->user_session = $_SESSION['user'];
		$this->assign('user_session',$_SESSION['user']);
		
		// 基类已经分类过此变量
		//$config = option('config');
		//$this->assign('config', $config);
		/**
		 * 用F进行缓存时，后台更新此值，直接进行清空缓存
		 */
		//获取导航 对此值进行文件缓存
		$navList = F('pc_slider_pc_nav');
		if (empty($navList)) {
			$navList = M('Slider')->get_slider_by_key('pc_nav',7);
			F('pc_slider_pc_nav', $navList);
		}
		$this->assign('navList', $navList);					 //导航栏目
		
		//获取热门搜索 对此值进行文件缓存
		$search_hot = F('pc_search_hot');
		if (empty($search_hot)) {
			$search_hot =  D('Search_hot')->order("sort asc ,id desc")->limit(7)->select();
			F('pc_search_hot', $search_hot);
		}
		$this->assign('search_hot', $search_hot);
		

		
		//公用头部右侧广告位 对此值进行文件缓存
		$public_top_ad = F('pc_adver_pc_index_top_right');
		if (empty($public_top_ad)) {
			$public_top_ad = M('Adver')->get_adver_by_key('pc_index_top_right',1);
			F('pc_adver_pc_index_top_right', $public_top_ad);
		}
		$this->assign('public_top_ad', $public_top_ad[0]);

		// 购物内的数量
		//dump($this->user_session);
		$cart_number = 0;
		if (isset($this->user_session['uid'])) {
			$user_cart = D('User_cart')->where(array('uid' => $this->user_session['uid']))->field('sum(pro_num) as number')->find();
			$cart_number = $user_cart['number'];
		}
		
		$this->cart_number = $cart_number;
		$this->assign('cart_number', $cart_number);
		
		// 产品分类进行缓存
		$categoryList = F('pc_product_category_all');
		if (empty($categoryList)) {
			$categoryList = M('Product_category')->getAllCategory(15,true);
			F('pc_product_category_all', $categoryList);
		}
		
		$this->assign('categoryList', $categoryList);

		//cookie 地理坐标
		$WebUserInfo = show_distance();
		
		/*
		if($WebUserInfo['long']) {
		$xml_array=simplexml_load_file("http://api.map.baidu.com/geocoder?location={$WebUserInfo[lat]},{$WebUserInfo[long]}&output=xml&key=18bcdd84fae25699606ffad27f8da77b"); //将XML中的数据,读取到数组对象中 
			foreach($xml_array as $tmp){ 
				$WebUserInfo['address'] = $tmp->formatted_address; 
			} 
		}*/
		$this->assign('WebUserInfo', $WebUserInfo);
		$this->user_location = $WebUserInfo;

		// 友情链接
		$flink_list = D('Flink')->where(array('status' => 1))->order('sort desc')->limit(10)->select();
		$this->assign('flink_list', $flink_list);
		if(empty($WebUserInfo['long']) || empty($WebUserInfo['lat'])){
			if(empty($_COOKIE['Location_qrcode']) || empty($_COOKIE['Location_qrcode']['ticket']) || $_COOKIE['Location_qrcode']['status'] > 0){
				$location_return 	= M('Recognition')->get_location_qrcode();
				
				if($location_qrcode['error_code'] == false){	
					$location_data 	= D('Location_qrcode')->where(array('id'=>$location_return['id']))->find();	
					
					setcookie('Location_qrcode[id]',$location_return['id'],time()+60*60*24);
					setcookie('Location_qrcode[ticket]',$location_return['ticket'],time()+60*60*24);
					setcookie('Location_qrcode[status]',$location_data['status'],time()+60*60*24);
				};
				//dump($location_return);
				$this->assign('location_qrcode',$location_return);
			}else{
				$this->assign('location_qrcode',$_COOKIE['Location_qrcode']);
			} 
		} else {
				$location_return 	= M('Recognition')->get_location_qrcode();
				$location_data 	= D('Location_qrcode')->where(array('id'=>$location_return['id']))->find();	
				$location_qrcode['id'] = $location_return['id'];
				$location_qrcode['ticket'] = $location_return['ticket'];
				$location_qrcode['status'] = $location_data['status'];
				$this->assign('location_qrcode',$location_qrcode);
			
		}	
			if($_SERVER['REMOTE_ADDR'] == '117.65.199.0'){
				
			}	
	
	}
		
		
	protected function nav_list() {
		$categoryList = M('Product_category')->getAllCategory(15);
		return $categoryList;
	}
	

}
?>