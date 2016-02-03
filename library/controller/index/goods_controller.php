<?php

class goods_controller extends base_controller{
	var $id;
	var $product;
	public function __construct(){
		parent::__construct();
		$id = $_GET['id'] + 0;
		
		if (empty($id)) {
			pigcms_tips('非法访问！', 'none');
		}
		
		$this->id = $id;
		$this->assign('id', $id);
	}

	public function index() {
		$product_model = M('Product');
		$this->product = $product_model->get(array('product_id' => $this->id, 'status' => 1));
		
		
		
		if (empty($this->product) || $this->product['status'] != 1) {
			pigcms_tips('未找到相应产品', 'none');
		}
		$this->product['wx_image'] = option('config.site_url').'/source/qrcode.php?type=good&id='.$this->product['product_id'];
		$is_preview = $_GET['is_preview'];
		
		if (!is_mobile() && $this->user_session && $this->product['uid'] == $this->user_session['uid']) {
			$this->assign('is_preview', $is_preview);
		}
		// 猜你喜欢，抽取方法为同类型的热销产品
		$condition_arr = array();
		//$condition_arr['category_id'] = $this->product['category_id'];
		$condition_arr['status'] = 1;
		$condition_arr['product_id'] = array('!=', $this->product['product_id']);
		$condition_arr['store_id'] = $this->product['store_id'];
		
		$similar_product_list = $product_model->getSelling($condition_arr, 'sort', 'desc', 0, 6);//->where($condition_arr)->order('sort desc')->limit('0, 6')->select();
		
		// 本店铺热卖产品，抽取方法本店铺同类型热买
		//$hot_product_list = $product_model->getSelling($condition_arr, 'sales', 'desc', 0, 6);
		
		// 检查商品库存情况
		$product_sku_list = array();
		$property_new_list = array();
		if ($this->product['has_property']) {
			//$product_sku_list = D('Product_sku')->field('`sku_id`, `properties`, `quantity`, `price`')->where(array('product_id' => $this->id, 'quantity'=>array('!=', '0')))->order('`sku_id` ASC')->select();
			$product_sku_list = D('Product_sku')->field('`sku_id`, `properties`, `quantity`, `price`')->where(array('product_id' => $this->id))->order('`sku_id` ASC')->select();
			
			$sku_price_arr = $sku_property_arr = array();
			foreach($product_sku_list as $value){
				$sku_price_arr[] = $value['price'];
				$sku_property_arr[$value['properties']] = true;
			}
			
			
			$property_list = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property'=>'ptp','Product_property'=>'pp'))->where("`ptp`.`product_id`='" . $this->id . "' AND `pp`.`pid`=`ptp`.`pid`")->order('`ptp`.`pigcms_id` ASC')->select();
			if(!empty($property_list)){
				$property_value_list = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`, `ppv`.`image`')->table(array('Product_to_property_value'=>'ptpv','Product_property_value'=>'ppv'))->where("`ptpv`.`product_id`='" . $this->id . "' AND `ppv`.`vid`=`ptpv`.`vid`")->order('`ptpv`.`pigcms_id` ASC')->select();
				if(!empty($property_value_list)){
					foreach($property_value_list as $value){
						$propertyValueList[$value['pid']][] = array(
								'vid'=>$value['vid'],
								'value'=>$value['value'],
								'image' => getAttachmentUrl($value['image']),
						);
					}
					foreach($property_list as $value){
						$property_new_list[] = array(
								'pid'=>$value['pid'],
								'name'=>$value['name'],
								'image' => getAttachmentUrl($value['image']),
								'values'=>$propertyValueList[$value['pid']],
						);
					}
					if(count($property_new_list) == 1){
						foreach($property_new_list[0]['values'] as $key=>$value){
							$tmpKey = $property_new_list[0]['pid'].':'.$value['vid'];
							if(empty($sku_property_arr[$tmpKey])){
								unset($property_new_list[0]['values'][$key]);
							}
						}
					}
					$returnArr['sku_list'] = $product_sku_list;
					$returnArr['property_list'] = $property_new_list;
				}
			}
			
		}
		
		// 抽出店铺
		$store = M('Store')->getStore($this->product['store_id']);
		
		if (empty($store) || $store['status'] != 1) {
			pigcms_tips('未找到相应的店铺或已关闭', 'none');
		}
		
		$store_contact = array();
		if ($this->product['supplier_id']) {
			$store_contact = M('Store_contact')->get($this->product['supplier_id']);
		} else {
			$store_contact = M('Store_contact')->get($this->product['store_id']);
		}
		
		// 设置浏览记录，只记录产品的product_id,只记录最近5条记录
		$history_product_list = $_COOKIE['history_product_list'];
		if (empty($history_product_list)) {
			setcookie('history_product_list', $this->id, $_SERVER['REQUEST_TIME']+86400*365,'/');
		} else {
			$tmp_product_list = explode(',', $history_product_list);
			array_unshift($tmp_product_list, $this->id);
			
			$tmp_product_list = array_slice($tmp_product_list, 0, 6);
			$tmp_product_list = array_unique($tmp_product_list);
			
			$tmp_product_list = array_slice($tmp_product_list, 0, 5);
			
			$product_id_str = join(',', $tmp_product_list);
			setcookie('history_product_list', $product_id_str, $_SERVER['REQUEST_TIME']+86400*365, '/');
		}
		
		// 更改浏览次数
		M('Product')->analytics(array('product_id' => $this->id));
		
		// 主营分类
		$sale_category = M('Store')->getSaleCategory($this->product['store_id'], $this->product['uid']);
		
		// 检查是否已经收藏
		$user_collect = array('click' => 'userCollect', 'title' => '收藏');
		if (!empty($this->user_session)) {
			$collect = D('User_collect')->where(array('type' => 1, 'user_id' => $this->user_session['uid'], 'dataid' => $this->id))->find();
			
			if (!empty($collect)) {
				$user_collect = array('click' => 'cancelCollect', 'title' => '取消收藏');
			}
		}
		
		// 查看本产品是否参与活动
		$reward = '';
		if ($this->product['source_product_id'] == 0) {
			$reward = M('Reward')->getRewardByProduct($this->product);
		}
		
		// 查找产品的图片
		$product_image_list = M('Product_image')->getImages($this->id);
		
		// 查找评论TAG数量
		$where = array();
		$where['type'] = 'PRODUCT';
		$where['relation_id'] = $this->id;
		$comment_tag_count_list = M('Comment_tag')->getCountList($where);
		
		// 评论满意，一般，不满意数量，以及满意百分比
		$comment_type_count = M('Comment')->getCountList($where);
		$satisfaction_pre = '100%';
		if ($comment_type_count['total'] > 0) {
			$satisfaction_pre = round($comment_type_count['t3'] / $comment_type_count['total'] * 100) . '%';
		}
		$comment_type_count['satisfaction_pre'] = $satisfaction_pre;
		
		// 查找系统评论TAG
		$product_category_tag_list = array();
		$product_category = M('Product_category')->getCategory($this->product['category_id']);
		if (!empty($product_category['tag_str'])) {
			$where = array();
			$where['id'] = array('in', explode(',', $product_category['tag_str']));
			$product_category_tag_list = M('System_tag')->geNameList($where);
		}
		
		// 店铺信息下面的评论
		$where = array();
		$where = array();
		$where['type'] = 'PRODUCT';
		$where['relation_id'] = $this->id;
		$where['status'] = 1;
		$where['delete_flg'] = 0;
		$comment_list = M('Comment')->getSimiplyList($where);
		
		// 最新动态
		$sns_list = M('Financial_record')->sns();
		
		$this->assign('imUrl',getImUrl($_SESSION['user']['uid'],$store['store_id']));
		$this->assign('product', $this->product);
		$this->assign('product_image_list', $product_image_list);
		$this->assign('similar_product_list', $similar_product_list);
		$this->assign('comment_type_count', $comment_type_count);
		$this->assign('comment_tag_count_list', $comment_tag_count_list);
		$this->assign('product_category_tag_list', $product_category_tag_list);
		$this->assign('store', $store);
		$this->assign('store_contact', $store_contact);
		$this->assign('property_list', $property_new_list);
		$this->assign('product_sku_list', $product_sku_list);
		$this->assign('sale_category', $sale_category);
		$this->assign('user_collect', $user_collect);
		$this->assign('reward', $reward);
		$this->assign('sns_list', $sns_list);
		$this->assign('comment_list', $comment_list);
		$this->display();
	}
	
}