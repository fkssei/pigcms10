<?php
/**
 *  微网站首页
 */
require_once dirname(__FILE__).'/global.php';

$action = $_GET['action'];

switch($action){
	case 'get_category':
		$cat_list = M('Product_category')->getAllCategory();
		foreach($cat_list as $key=>$value){
			if(empty($value['cat_list'])){
				unset($cat_list[$key]);
			}
		}
		json_return(0,$cat_list);
		break;
	case 'get_product_list':
		$keyword = $_POST['keyword'];
		$key_id = $_POST['key_id'];
		$page = $_POST['page'];
		$prop = $_POST['prop'];
		// 筛选属性ID集合
		$prop_arr = array();
		if (!empty($prop)) {
			$prop_arr = explode('_', $prop);
		}

		// 查询属性条件
		$is_prop = false;
		$product_id_str = '';
		if (!empty($prop_arr)) {
			$product_id_str = M('System_product_to_property_value')->getProductIDByVid($prop_arr);
			$is_prop = true;
		}

		if($key_id){
			$now_category = D('Product_category')->field('`cat_id`,`cat_fid`')->where(array('cat_id'=>$key_id))->find();
		}
		$condition['status'] = '1';
		$condition['quantity'] = array('!=','0');
		if($now_category){
			if($now_category['cat_fid']){
				$condition['category_id'] = $now_category['cat_id'];
			}else{
				$condition['category_fid'] = $now_category['cat_id'];
			}
		}else{
			$condition['name'] = array('like','%'.$keyword.'%');
		}
		if($page == 1){
			if ($is_prop && $product_id_str) {
				$product_id_arr = explode(',', $product_id_str);
				$condition['product_id'] = array('in', $product_id_arr); 
				$json_return['count'] = D('Product')->where($condition)->count('product_id');
			} else if ($is_prop) {
				$json_return['count'] = 0;
			} else {
				$json_return['count'] = D('Product')->where($condition)->count('product_id');
			}
		}
		switch($_POST['sort']){
			case 'price_asc':
				$sort_by = '`price` ASC';
				break;
			case 'price_desc':
				$sort_by = '`price` DESC';
				break;
			case 'sale':
				$sort_by = '`sales` DESC';
				break;
			case 'pv':
				$sort_by = '`pv` DESC';
				break;
			default:
				$sort_by = '`product_id` DESC';
		}
		$json_return['list'] = D('Product')->field('`product_id`,`name`,`image`,`price`,`original_price`,`sales`')->where($condition)->order($sort_by)->limit((($page-1)*10).',10')->select();
		if(count($json_return['list']) < 10){
			$json_return['noNextPage'] = true;
		}
		foreach($json_return['list'] as &$value){
			// $value['price'] = floatval($value['price']);
			$value['image'] = getAttachmentUrl($value['image']);
		}
		json_return(0,$json_return);
		break;
	case 'nearshops':
		$long = $_POST['long'];
		$lat = $_POST['lat'];
		if(empty($long) || empty($lat)){
			json_return(1,'没有携带地理位置');
		}
		import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords='.$long.','.$lat.'&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback,true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			json_return(1,'地理位置解析错误，请重试！');
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}
		$database_store_contact = D('Store_contact');
		$store_list = D('')->table(array('Store_contact'=>'sc','Store'=>'s'))->field("`s`.`store_id`,`s`.`name`,`s`.`intro`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")->where("`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1'")->order("`juli` ASC")->limit(12)->select();
		foreach($store_list as $key=>$value){
			if($value['juli'] > 20000){
				unset($store_list[$key]);
			}
		}
		$database_product = D('Product');
		$condition_product['status'] = 1;
		foreach($store_list as &$value){
			$value['url'] = $config['wap_site_url'].'/home.php?id='.$value['store_id'].'&platform=1';
			$condition_product['store_id'] = $value['store_id'];
			$value['product_list'] = $database_product->field('`product_id`,`name`,`image`,`price`')->where($condition_product)->order('`product_id` DESC')->limit(3)->select();
			foreach($value['product_list'] as &$product_value){
				$product_value['price'] = floatval($product_value['price']);
				$product_value['image'] = getAttachmentUrl($product_value['image']);
				$product_value['url'] = $config['wap_site_url'].'/good.php?id='.$product_value['product_id'].'&platform=1';
			}
		}
		json_return(0,$store_list);
		break;
	case 'butt_nearshops':
		$domain = $_POST['domain'];
		$long = $_POST['long'];
		$lat = $_POST['lat'];
		if(empty($long) || empty($lat)){
			json_return(1,'没有携带地理位置');
		}
		import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords='.$long.','.$lat.'&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback,true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			json_return(1,'地理位置解析错误，请重试！');
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}
		$database_store_contact = D('Store_contact');
		$store_list = D('')->table(array('Store_contact'=>'sc','Store'=>'s','User'=>'u'))->field("`s`.`store_id`,`s`.`name`,`s`.`intro`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")->where("`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1' AND `u`.`uid`=`s`.`uid` AND `u`.`source_site_url`='$domain'")->order("`juli` ASC")->limit(20)->select();
		foreach($store_list as $key=>$value){
			if($value['juli'] > 20000){
				unset($store_list[$key]);
			}
		}
		$database_product = D('Product');
		$condition_product['status'] = 1;
		foreach($store_list as &$value){
			$value['url'] = $config['wap_site_url'].'/home.php?id='.$value['store_id'];
			$condition_product['store_id'] = $value['store_id'];
			$value['product_list'] = $database_product->field('`product_id`,`name`,`image`,`price`')->where($condition_product)->order('`product_id` DESC')->limit(3)->select();
			foreach($value['product_list'] as &$product_value){
				$product_value['price'] = floatval($product_value['price']);
				$product_value['image'] = getAttachmentUrl($product_value['image']);
				$product_value['url'] = $config['wap_site_url'].'/good.php?id='.$product_value['product_id'];
			}
		}
		json_return(0,$store_list);
		break;
	case 'butt_nearshops_search':
		$domain = $_POST['domain'];
		$keyword = $_POST['keyword'];
		$long = $_POST['long'];
		$lat = $_POST['lat'];
		if(empty($long) || empty($lat)){
			json_return(1,'没有携带地理位置');
		}
		import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords='.$long.','.$lat.'&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback,true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			json_return(1,'地理位置解析错误，请重试！');
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}
		$database_store_contact = D('Store_contact');
		$store_list = D('')->table(array('Store_contact'=>'sc','Store'=>'s','User'=>'u'))->field("`s`.`store_id`,`s`.`name`,`s`.`intro`,`sc`.`long`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")->where("`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1' AND `u`.`uid`=`s`.`uid` AND `u`.`source_site_url`='$domain' AND `s`.`name` LIKE '%$keyword%'")->order("`juli` ASC")->limit(20)->select();
		$database_product = D('Product');
		$condition_product['status'] = 1;
		foreach($store_list as &$value){
			$value['name'] = str_replace($keyword,'<font color="red">'.$keyword.'</font>',$value['name']);
			$value['url'] = $config['wap_site_url'].'/home.php?id='.$value['store_id'];
			$condition_product['store_id'] = $value['store_id'];
			$value['product_list'] = $database_product->field('`product_id`,`name`,`image`,`price`')->where($condition_product)->order('`product_id` DESC')->limit(3)->select();
			foreach($value['product_list'] as &$product_value){
				$product_value['price'] = floatval($product_value['price']);
				$product_value['image'] = getAttachmentUrl($product_value['image']);
				$product_value['url'] = $config['wap_site_url'].'/good.php?id='.$product_value['product_id'];
			}
		}
		json_return(0,$store_list);
		break;
	case 'address_add':
		if(IS_POST){
			$data_user_address['uid'] = $wap_user['uid'];
			$data_user_address['name'] = $_POST['name'];
			$data_user_address['tel'] = $_POST['tel'];
			$data_user_address['province'] = $_POST['province'];
			$data_user_address['city'] = $_POST['city'];
			$data_user_address['area'] = $_POST['area'];
			$data_user_address['address'] = $_POST['address'];
			$data_user_address['add_time'] = $_SERVER['REQUEST_TIME'];
			if(D('User_address')->data($data_user_address)->add()){
				json_return(0,'添加成功');
			}else{
				json_return(1,'添加失败，请重试。');
			}
		}else{
			json_return(1,'非法访问');
		}
		break;
	case 'address_save':
		if(IS_POST){
			$condition_user_address['address_id'] = $_POST['address_id'];
			$condition_user_address['uid'] = $wap_user['uid'];
			$data_user_address['name'] = $_POST['name'];
			$data_user_address['tel'] = $_POST['tel'];
			$data_user_address['province'] = $_POST['province'];
			$data_user_address['city'] = $_POST['city'];
			$data_user_address['area'] = $_POST['area'];
			$data_user_address['address'] = $_POST['address'];
			$data_user_address['add_time'] = $_SERVER['REQUEST_TIME'];
			if(D('User_address')->where($condition_user_address)->data($data_user_address)->save()){
				json_return(0,'保存成功');
			}else{
				json_return(1,'保存失败，请重试。');
			}
		}else{
			json_return(1,'非法访问');
		}
		break;
	case 'address_del':
		if(IS_POST){
			$condition_user_address['uid'] = $wap_user['uid'];
			$condition_user_address['address_id'] = $_POST['address_id'];
			if(D('User_address')->where($condition_user_address)->delete()){
				json_return(0,'删除成功');
			}else{
				json_return(1,'删除失败，请重试。');
			}
		}else{
			json_return(1,'非法访问');
		}
		break;
	case 'nearstore':
		$long = $_REQUEST['long'];
		$lat = $_REQUEST['lat'];
		if(empty($long) || empty($lat)) {
			json_return(1,'没有携带地理位置');
		}
		import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords='.$long.','.$lat.'&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback, true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			json_return(1,'地理位置解析错误，请重试！');
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}
		$database_store_contact = D('Store_contact');
		$store_list = D('')->table(array('Store_contact'=>'sc', 'Store'=>'s'))->field("`s`.`store_id`,`s`.`name`,`s`.`intro`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")->where("`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1'")->order("`juli` ASC")->limit(4)->select();
		foreach($store_list as $key=>$value){
			if($value['juli'] > 200000){
				unset($store_list[$key]);
			} else {
				$store_list[$key]['url'] = $config['wap_site_url'] . '/home.php?id=' . $value['store_id'] . '&platform=1';
				if(empty($value['logo'])) {
					$store_list[$key]['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
				} else {
					$store_list[$key]['logo'] = getAttachmentUrl($value['logo']);
				}
			}
		}
		json_return(0, $store_list);
		break;
	case 'nearactive':
		$long = $_REQUEST['long'];
		$lat = $_REQUEST['lat'];
		if(empty($long) || empty($lat)) {
			json_return(1,'没有携带地理位置');
		}
		import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords='.$long.','.$lat.'&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback, true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			json_return(1,'地理位置解析错误，请重试！');
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}
		$database_store_contact = D('Store_contact');
		//$goods_list = D('')->table(array('Store_contact'=>'sc', 'Store'=>'s', 'Activity_recommend' => 'ar'))->field("`ar`.*, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")->where("`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1' and `ar`.`token` = `s`.`pigcmsToken` ")->group('s.store_id')->order("`juli` ASC")->limit(4)->select();
		
		$artivce_list = D('')->table("Activity_recommend as ar")
							->join("Store as s ON s.pigcmsToken = ar.token","LEFT")
							->join("Store_contact as sc ON sc.store_id=s.store_id","LEFT")
							->field("`ar`.*, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli" )
							->where("`s`.`status`='1' and is_rec=1")
							->group ( '`ar`.`id`' )
							->order ( "`juli` asc" )
							->limit(4)
							->select();		
		
		
		$activity = M('activity');
		foreach($artivce_list as $key => &$value){
			if($value['juli'] > 200000){
				unset($store_list[$key]);
				$artivce_list[$key]['url'] = $activity->createUrl($value,$value['model'],'1');
				$artivce_list[$key]['image'] = getAttachmentUrl($value['image']);
			} else {
				$artivce_list[$key]['url'] = $activity->createUrl($value,$value['model'],'1');
				$artivce_list[$key]['image'] = getAttachmentUrl($value['image']);
			}
		}
		json_return(0, $artivce_list);
		break;	
	case 'neargoods':
		$long = $_REQUEST['long'];
		$lat = $_REQUEST['lat'];
		if(empty($long) || empty($lat)) {
			json_return(1,'没有携带地理位置');
		}

		import('Http');
		$http_class = new Http();
		$callback = $http_class->curlGet('http://api.map.baidu.com/geoconv/v1/?coords='.$long.','.$lat.'&from=1&to=5&ak=4c1bb2055e24296bbaef36574877b4e2');
		$callback_arr = json_decode($callback, true);
		if(empty($callback_arr['result']) || !empty($callback_arr['status'])){
			json_return(1,'地理位置解析错误，请重试！');
		}else{
			$long = $callback_arr['result'][0]['x'];
			$lat = $callback_arr['result'][0]['y'];
		}
		$database_store_contact = D('Store_contact');
		//$goods_list = D('')->table(array('Store_contact'=>'sc', 'Store'=>'s', 'Product' => 'p'))->field("`p`.*, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")->where("`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1' and `p`.`is_recommend` = 1 AND p.supplier_id = 0")->group('p.store_id')->order("`juli` ASC")->limit(4)->select();
		$goods_list = array();
		$goods_list = D('')->table("Product as p")
							->join('Store as s ON s.store_id=p.store_id','LEFT')
							->join('Store_contact as sc ON sc.store_id=p.store_id','LEFT')
							->field("`p`.*, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli" )
							//->where( "`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1' and `p`.`is_recommend` = 1 AND p.supplier_id = 0 and p.store_id = s.store_id" . $where )
							->where("`s`.`status`='1' and `p`.`is_recommend` = 1 AND p.supplier_id = 0")
							->group ( 'p.store_id' )
							->order ( "`juli` asc"  )
							->limit(4)
							->select();	
		
		
		
		foreach($goods_list as $key => &$value){
			/*if($value['juli'] > 200000){
				unset($store_list[$key]);
			} else {
				$goods_list[$key]['url'] = $config['wap_site_url'] . '/good.php?id=' . $value['product_id'];
				$goods_list[$key]['image'] = getAttachmentUrl($value['image']);
				
				if ($value['price'] > $value['original_price']) {
					$value['original_price'] = $value['price'];
					$value['youhui_price'] = 0;
				} else {
					$value['youhui_price'] = $value['original_price'] - $value['price'];
				}
			}
			*/
			$goods_list[$key]['url'] = $config['wap_site_url'] . '/good.php?id=' . $value['product_id'];
			$goods_list[$key]['image'] = getAttachmentUrl($value['image']);
			
			if ($value['price'] > $value['original_price']) {
				$value['original_price'] = $value['price'];
				$value['youhui_price'] = 0;
			} else {
				$value['youhui_price'] = $value['original_price'] - $value['price'];
			}
		}
		json_return(0, $goods_list);
		break;
}

echo ob_get_clean();
?>