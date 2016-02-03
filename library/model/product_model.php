<?php
/**
 * 商品数据模型
 * User: pigcms_21
 * Date: 2015/2/9
 * Time: 13:15
 */
class product_model extends base_model {
	public function add($data) {
		if (! empty ( $data ['image'] )) {
			$data ['image'] = getAttachment ( $data ['image'] );
		}
		$product_id = $this->db->data ( $data )->add ();
		return $product_id;
	}
	public function edit($where, $data) {
		if (! empty ( $data ['image'] )) {
			$data ['image'] = getAttachment ( $data ['image'] );
		}
		return $this->db->where ( $where )->data ( $data )->save ();
	}
	
	// 优质分销商品
	public function getExcellentFx($offset = 0, $limit = 10) {
		$where = array (
				'status' => 1,
				'is_fx' => 1,
				'source_product_id'=>0
		);
		$order = "is_hot desc,drp_profit desc";
		$fxlist = $this->db->where ( $where )->order ( $order )->limit ( $offset . ',' . $limit )->select ();
		foreach ( $fxlist as &$v ) {
			$v ['image'] = getAttachmentUrl ( $v ['image'] );
			$v ['link'] = url_rewrite ( 'goods:index', array (
					'id' => $v ['product_id'] 
			) );
			$v ['wx_image'] = option ( 'config.site_url' ) . '/source/qrcode.php?type=good&id=' . $v ['product_id'];
		}
		return $fxlist;
	}
	
	/**
	 *
	 * @param
	 *        	$where
	 * @param $orderbyfield 排序字段        	
	 * @param $orderbymethod 排序方式
	 *        	ASC DESC
	 * @param
	 *        	$offset
	 * @param
	 *        	$limit
	 * @param $is_show_distance (0:
	 *        	不调取距离，1，调取距离，)
	 * @return array
	 */
	public function getSelling($where, $order_by_field, $order_by_method, $offset, $limit, $is_show_distance = "") {
		if (! empty ( $order_by_field ) && ! empty ( $order_by_method )) {
			$order = $order_by_field . ' ' . strtoupper ( $order_by_method );
			if ($order_by_field == 'sort') {
				$order .= ', product_id DESC';
			}
		} else { // 默认排序
			$order = 'sort DESC, product_id DESC';
		}
		
		if (is_array ( $where )) {
			$where ['status'] = 1;
		}
		$products = $this->db->field ( '*' )->where ( $where )->order ( $order )->limit ( $offset . ',' . $limit )->select ();
		
		foreach ( $products as &$tmp ) {
			$tmp ['image'] = getAttachmentUrl ( $tmp ['image'] );
			$tmp ['link'] = url_rewrite ( 'goods:index', array (
					'id' => $tmp ['product_id'] 
			) );
		}
		
		return $products;
	}
	

	
	// 根据距离降序 统计商铺的单商品个数
	public function getSellingBydistanceCount($where = "") {

		//不出现分销
		if(!is_array($where)) {
			$where = $where . " and p.supplier_id=0 and p.status=1 and p.is_recommend=1 and sc.long>0";
		}

		$count = $this->db->table("Product as p")
		->join('Store as s ON s.store_id=p.store_id','LEFT')
		->join('Store_contact as sc ON sc.store_id=p.store_id','LEFT')
		->where( $where )
		->field ( "count(DISTINCT p.store_id) as counts" )
		->find();

		return $count ['counts'];
	}	
	
	
	/**
	 * 根据距离 升降序商品
	 * @param	$where string
	 * @param	$orderbyfield 排序字段
	 * @param	$orderbymethod 排序方式	ASC DESC
	 * @param	$offset
	 * @param	$limit
	 * @param	$is_show_distance (0:不调取距离，1，调取距离，)
	 * @return	array
	 */
	public function getSellingBydistance($where="", $order_by_field, $order_by_method, $offset, $limit, $is_show_distance = "") {
		$db_prefix = option ( 'system.DB_PREFIX' );
		if (! empty ( $order_by_field ) && ! empty ( $order_by_method )) {
			$order = $order_by_field . ' ' . strtoupper ( $order_by_method );
			if ($order_by_field == 'sort') {
				$order .= ', product_id DESC';
			}
		} else { // 默认排序
			$order = 'sort DESC, product_id DESC';
		}

		$julis = "";
		$WebUserInfo = show_distance ();
		$long = $WebUserInfo ['long'];
		$lat = $WebUserInfo ['lat'];
		
		//不出现分销
			if(is_array($where)) $where = implode(" and " ,$where);
		    $where = $where ? ($where ."and"):"";
			$where = $where . "  p.supplier_id=0 and p.status=1 and p.is_recommend=1 and sc.long>0";
			

		$products = $this->db->table("Product as p")
							->join('Store as s ON s.store_id=p.store_id','LEFT')
							->join('Store_contact as sc ON sc.store_id=p.store_id','LEFT')
							->field("`p`.*, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli" )
							//->where( "`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1' and `p`.`is_recommend` = 1 AND p.supplier_id = 0 and p.store_id = s.store_id" . $where )
							->where($where)
							->group ( 'p.store_id' )
							->order ( "`juli` " . $order_by_method )
							->limit($offset . ',' . $limit)
							->select();		
		
	
		foreach ( $products as &$tmp ) {
			$tmp ['image'] = getAttachmentUrl ( $tmp ['image'] );
			$tmp ['link'] = url_rewrite ( 'goods:index', array (
				'id' => $tmp ['product_id']
			) );
		}
	
		return $products;
	}	
	
	
	/**
	 *
	 * @param
	 *        	$where
	 * @param $orderbyfield 排序字段        	
	 * @param $orderbymethod 排序方式
	 *        	ASC DESC
	 * @param
	 *        	$offset
	 * @param
	 *        	$limit
	 * @return array
	 */
	public function getSellingAndDistance($where, $order_by_field, $order_by_method, $offset, $limit) {
		if (! empty ( $order_by_field ) && ! empty ( $order_by_method )) {
			$order = $order_by_field . ' ' . strtoupper ( $order_by_method );
		} else { // 默认排序
			$order = 'sort DESC, p.product_id DESC';
		}
		
		if (is_array ( $where )) {
			$where ['status'] = 1;
		} else {
			$where = $where . " and `sc`.`store_id`=`p`.`store_id` AND `p`.`store_id`=`s`.`store_id` AND `s`.`status`='1' ";
		}
		// $products = D('')->table(array('Store_contact'=>'sc','Product'=>'p','Store'=>'s'))->field("p.*,`sc`.`long`,`sc`.`lat`")->where($where)->order($order)->limit($limit)->select();
		$products = array();
		$products = $this->db->table("Product as p")
							->join('Store as s ON s.store_id=p.store_id','LEFT')
							->join('Store_contact as sc ON sc.store_id=p.store_id','LEFT')
							->field("p.*,`sc`.`long`,`sc`.`lat`")
							->where($where)
							->limit($limit)
							->select();

			
			foreach ( $products as &$tmp ) {
			$tmp ['image'] = getAttachmentUrl ( $tmp ['image'] );
			$tmp ['link'] = url_rewrite ( 'goods:index', array (
					'id' => $tmp ['product_id'] 
			) );
		}
		
		return $products;
	}
	
	// 出售中的商品数量
	public function getSellingTotal($where) {
		$where ['status'] = 1;
		return $this->db->where ( $where )->order ( 'product_id DESC' )->count ( 'product_id' );
	}
	
	// 商品下架
	public function soldout($store_id, $product_ids) {
		if (! empty ( $product_ids ) && ! empty ( $store_id )) {
			$where = array ();
			$where ['store_id'] = $store_id;
			$where ['product_id'] = array (
					'in',
					$product_ids 
			);
			return $result = $this->db->where ( $where )->data ( array (
					'status' => 0 
			) )->save ();
		}
	}
	
	// 商品上架
	public function putaway($store_id, $product_ids) {
		if (! empty ( $product_ids ) && ! empty ( $store_id )) {
			$where = array ();
			$where ['store_id'] = $store_id;
			$where ['product_id'] = array (
					'in',
					$product_ids 
			);
			return $result = $this->db->where ( $where )->data ( array (
					'status' => 1 
			) )->save ();
		}
	}
	
	// 参与会员折扣
	public function allowDiscount($store_id, $discount, $product_ids) {
		if (! empty ( $product_ids ) && ! empty ( $store_id )) {
			$where = array ();
			$where ['store_id'] = $store_id;
			$where ['product_id'] = array (
					'in',
					$product_ids 
			);
			return $result = $this->db->where ( $where )->data ( array (
					'allow_discount' => $discount 
			) )->save ();
		}
	}
	
	/**
	 * 获取单个商品
	 * 
	 * @param
	 *        	$where
	 * @param string $fields        	
	 */
	public function get($where, $fields = '*') {
		$product = $this->db->field ( $fields )->where ( $where )->find ();
		
		if (empty ( $product )) {
			return array ();
		}
		$product ['image'] = getAttachmentUrl ( $product ['image'] );
		// $product['wx_image'] = option('config.site_url').'/source/qrcode.php?type=good&id='.$product['product_id'];
		return $product;
	}
	
	// 已售罄的商品
	public function getStockout($where, $order_by_field, $order_by_method, $limit, $offset) {
		if (! empty ( $order_by_field ) && ! empty ( $order_by_method )) {
			$order = $order_by_field . ' ' . strtoupper ( $order_by_method );
			if ($order_by_field == 'sort') {
				$order .= ', product_id DESC';
			}
		} else { // 默认排序
			$order = 'sort DESC, product_id DESC';
		}
		$where ['quantity'] = 0;
		$where ['status'] = 1;
		$products = $this->db->field ( '*' )->where ( $where )->order ( $order )->limit ( $limit . ',' . $offset )->select ();
		
		foreach ( $products as &$product ) {
			$product ['image'] = getAttachmentUrl ( $product ['image'] );
		}
		return $products;
	}
	
	// 已售罄的商品数量
	public function getStockoutTotal($where) {
		$where ['quantity'] = 0;
		$where ['status'] = 1;
		return $this->db->where ( $where )->count ( 'product_id' );
	}
	
	// 仓库中的商品
	public function getSoldout($where, $order_by_field, $order_by_method, $limit, $offset) {
		if (! empty ( $order_by_field ) && ! empty ( $order_by_method )) {
			$order = $order_by_field . ' ' . strtoupper ( $order_by_method );
			if ($order_by_field == 'sort') {
				$order .= ', product_id DESC';
			}
		} else { // 默认排序
			$order = 'sort DESC, product_id DESC';
		}
		$where ['status'] = 0;
		$products = $this->db->field ( '*' )->where ( $where )->order ( $order )->limit ( $limit . ',' . $offset )->select ();
		
		foreach ( $products as &$product ) {
			$product ['image'] = getAttachmentUrl ( $product ['image'] );
		}
		return $products;
	}
	
	// 仓库中的商品数量
	public function getSoldoutTotal($where) {
		$where ['status'] = 0;
		return $this->db->where ( $where )->count ( 'product_id' );
	}
	
	// 店铺商品数量
	public function getTotalByStoreId($store_id) {
		$product_total = $this->db->where ( array (
				'store_id' => $store_id,
				'status' => array (
						'<',
						2 
				) 
		) )->count ( 'product_id' );
		return $product_total;
	}
	
	/* 得到分组下的商品列表 */
	public function getGroupGoodList($group_id, $first_sort = '0', $second_sort = '0') {
		switch ($first_sort) {
			case '0' :
				$order .= ' `p`.`sort` DESC, `p`.`product_id` DESC';
				break;
			case '1' :
				$order .= ' `p`.`pv` DESC';
		}
		switch ($second_sort) {
			case '0' :
				$order .= ',`p`.`date_added` DESC';
				break;
			case '1' :
				$order .= ',`p`.`date_added` ASC';
			case '2' :
				if ($first_sort != '1') {
					$order .= ',`p`.`pv` DESC';
				}
		}
		$database = D ( '' );
		$product_list = $database->table ( array (
				'Product_to_group' => 'ptg',
				'Product' => 'p' 
		) )->where ( "`ptg`.`group_id`='$group_id' AND `ptg`.`product_id`=`p`.`product_id` AND `p`.`status` = 1 AND `p`.`quantity` > 0" )->order ( $order )->select ();
		
		foreach ( $product_list as &$product ) {
			$product ['image'] = getAttachmentUrl ( $product ['image'] );
		}
		return $product_list;
	}
	/* 得到分组下指定数据的商品列表 */
	public function getGroupGoodNumberList($group_id, $number) {
		$database = D ( '' );
		$product_list = $database->table ( array (
				'Product_to_group' => 'ptg',
				'Product' => 'p' 
		) )->where ( "`ptg`.`group_id`='$group_id' AND `ptg`.`product_id`=`p`.`product_id` AND `p`.status = 1 AND `p`.`quantity` > 0" )->order ( '`p`.`product_id` DESC' )->limit ( $number )->select ();
		foreach ( $product_list as &$product ) {
			$product ['image'] = getAttachmentUrl ( $product ['image'] );
		}
		return $product_list;
	}
	/* 得到搜索的商品列表 */
	public function getSearchGroupGoodList($key, $page, $store_id) {
		$database_product = D ( 'Product' );
		$condition_product ['store_id'] = $store_id;
		$condition_product ['name'] = array (
				'like',
				'%' . $key . '%' 
		);
		$condition_product ['status'] = 1;
		$count = $database_product->where ( $condition_product )->count ( 'product_id' );
		$pageCount = ceil ( $count / 18 );
		if ($page > $pageCount)
			$page = $pageCount;
		if ($count > 0) {
			$product_list = $database_product->where ( $condition_product )->order ( '`product_id` DESC' )->limit ( (($page - 1) * 18) . ',18' )->select ();
			foreach ( $product_list as &$value ) {
				$value ['image'] = getAttachmentUrl ( $value ['image'] );
			}
			$return ['product_list'] = $product_list;
			
			$pageCount = ceil ( $count / 18 );
			if ($pageCount > 1) {
				if ($page == 1) {
					$pagebar = '<a href="javascript:void(0);" class="custom-paginations-prev disabled">上一页</a>';
				} else {
					$pagebar = '<a href="./search.php?store_id=' . $store_id . '&q=' . urlencode ( $key ) . '&page=' . ($page - 1) . '" class="custom-paginations-prev">下一页</a>';
				}
				if ($page >= $pageCount) {
					$pagebar .= '<a href="javascript:void(0);" class="custom-paginations-next disabled">下一页</a>';
				} else {
					$pagebar .= '<a href="./search.php?store_id=' . $store_id . '&q=' . urlencode ( $key ) . '&page=' . ($page + 1) . '" class="custom-paginations-next">下一页</a>';
				}
				$return ['pagebar'] = $pagebar;
			}
			return $return;
		} else {
			return array ();
		}
	}
	public function delete($store_id, $product_id) {
		$where = array ();
		$where ['store_id'] = $store_id;
		if (is_array ( $product_id )) {
			$where ['product_id'] = array (
					'in',
					$product_id 
			);
		} else {
			$where ['product_id'] = $product_id;
		}
		return $this->db->where ( $where )->data ( array (
				'status' => 2 
		) )->save ();
	}
	public function fxEdit($product_id, $product) {
		$product_info = M ( 'Product' )->get ( array (
				'product_id' => $product_id,
				'store_id' => $_SESSION ['store'] ['store_id'] 
		) );
		// 分销级别
		if (! empty ( $_SESSION ['store'] ['drp_level'] )) {
			$drp_level = $_SESSION ['store'] ['drp_level'] + 1;
		} else {
			$drp_level = 1;
		}
		if (empty ( $product_info ['source_product_id'] ) && (! empty ( $product_info ['unified_price_setting'] ) || $_POST ['unified_price_setting'])) {
			$data = array (
					'drp_level_1_cost_price' => ! empty ( $product ['drp_level_1_cost_price'] ) ? $product ['drp_level_1_cost_price'] : 0,
					'drp_level_2_cost_price' => ! empty ( $product ['drp_level_2_cost_price'] ) ? $product ['drp_level_2_cost_price'] : 0,
					'drp_level_3_cost_price' => ! empty ( $product ['drp_level_3_cost_price'] ) ? $product ['drp_level_3_cost_price'] : 0,
					'drp_level_1_price' => ! empty ( $product ['drp_level_1_price'] ) ? $product ['drp_level_1_price'] : 0,
					'drp_level_2_price' => ! empty ( $product ['drp_level_2_price'] ) ? $product ['drp_level_2_price'] : 0,
					'drp_level_3_price' => ! empty ( $product ['drp_level_3_price'] ) ? $product ['drp_level_3_price'] : 0,
					'is_recommend' => $product ['is_recommend'],
					'is_fx' => $product ['is_fx'],
					'fx_type' => $product ['fx_type'],
					'is_fx_setting' => $product ['is_fx_setting'],
					'last_edit_time' => time (),
					'unified_price_setting' => $product ['unified_price_setting'] 
			);
			if (! empty ( $product ['drp_level_' . $drp_level . '_price'] )) {
				$data ['min_fx_price'] = $product ['drp_level_' . $drp_level . '_price'];
				$data ['max_fx_price'] = $product ['drp_level_' . $drp_level . '_price'];
			} else {
				$data ['min_fx_price'] = ! empty ( $product ['min_fx_price'] ) ? $product ['min_fx_price'] : 0;
				$data ['max_fx_price'] = ! empty ( $product ['max_fx_price'] ) ? $product ['max_fx_price'] : 0;
			}
			if (! empty ( $product ['drp_level_' . $drp_level . '_cost_price'] )) {
				$data ['cost_price'] = $product ['drp_level_' . $drp_level . '_cost_price'];
			} else {
				$data ['cost_price'] = ! empty ( $product ['cost_price'] ) ? $product ['cost_price'] : 0;
			}
		} else if (! empty ( $product_info ['unified_price_setting'] )) {
			$data = array (
					'is_recommend' => $product ['is_recommend'],
					'is_fx' => $product ['is_fx'],
					'fx_type' => $product ['fx_type'],
					'is_fx_setting' => $product ['is_fx_setting'],
					'last_edit_time' => time (),
					'min_fx_price' => $product_info ['drp_level_' . $drp_level . '_price'],
					'max_fx_price' => $product_info ['drp_level_' . $drp_level . '_price'],
					'cost_price' => $product_info ['drp_level_' . $drp_level . '_cost_price'] 
			);
		} else {
			$data = array (
					'is_recommend' => $product ['is_recommend'],
					'is_fx' => $product ['is_fx'],
					'fx_type' => $product ['fx_type'],
					'is_fx_setting' => $product ['is_fx_setting'],
					'last_edit_time' => time (),
					'min_fx_price' => ! empty ( $product ['min_fx_price'] ) ? $product ['min_fx_price'] : 0,
					'max_fx_price' => ! empty ( $product ['max_fx_price'] ) ? $product ['max_fx_price'] : 0,
					'cost_price' => ! empty ( $product ['cost_price'] ) ? $product ['cost_price'] : 0 
			);
		}
		return $this->db->where ( array (
				'product_id' => $product_id 
		) )->data ( $data )->save ();
	}
	public function fxCancel($where) {
		return $this->db->where ( $where )->data ( array (
				'is_fx' => 0,
				'is_fx_setting' => 0 
		) )->save ();
	}
	
	// 商品浏览量统计
	public function analytics($where) {
		return $this->db->where ( $where )->setInc ( 'pv', 1 );
	}
	// 我分销的商品
	public function fxProducts($store_id, $offset = 0, $limit = 0) {
		if ($limit > 0) {
			$products = $this->db->where ( array (
					'store_id' => $store_id,
					'supplier_id' => array (
							'>',
							0 
					),
					'status' => array (
							'<',
							2 
					) 
			) )->limit ( $offset . ',' . $limit )->select ();
		} else {
			$products = $this->db->where ( array (
					'store_id' => $store_id,
					'supplier_id' => array (
							'>',
							0 
					),
					'status' => array (
							'<',
							2 
					) 
			) )->select ();
		}
		return $products;
	}
	
	// 可用的分销商品（不含删除状态）
	public function availableFxProducts($store_id, $offset = 0, $limit = 0) {
		if ($limit > 0) {
			$products = $this->db->where ( array (
					'store_id' => $store_id,
					'status' => array (
							'<',
							2 
					),
					'supplier_id' => array (
							'>',
							0 
					) 
			) )->limit ( $offset . ',' . $limit )->select ();
		} else {
			$products = $this->db->where ( array (
					'store_id' => $store_id,
					'status' => array (
							'<',
							2 
					),
					'supplier_id' => array (
							'>',
							0 
					) 
			) )->select ();
		}
		return $products;
	}
	public function fxProductCount($where) {
		return $this->db->where ( $where )->count ( 'product_id' );
	}
	
	// 供货商分销的商品
	public function supplierFxProducts($where, $offset = 0, $limit = 0) {
		if ($limit > 0) {
			$products = $this->db->where ( $where )->order ( 'is_recommend DESC, product_id DESC' )->order ( 'product_id DESC' )->limit ( $offset . ',' . $limit )->select ();
		} else {
			$products = $this->db->where ( $where )->order ( 'is_recommend DESC, product_id DESC' )->order ( 'product_id DESC' )->select ();
		}
		
		foreach ( $products as &$product ) {
			$product ['image'] = getAttachmentUrl ( $product ['image'] );
		}
		return $products;
	}
	public function supplierFxProductCount($where) {
		return $this->db->where ( $where )->count ( 'product_id' );
	}
	public function getFxProducts($where) {
		$products = $this->db->where ( $where )->select ();
		return $products;
	}
	public function delFxProduct($where) {
		return $this->db->where ( $where )->data ( array (
				'status' => 2 
		) )->save ();
	}
	
	// 设置商品分销商数量
	public function setDrpSellerQty($product_id, $qty = 1) {
		return $this->db->where ( array (
				'product_id' => $product_id 
		) )->setInc ( 'drp_seller_qty', $qty );
	}
	
	// 获取商品分销总利润
	public function getDrpProfit($product_id) {
		$profit = $this->db->field ( 'drp_profit' )->where ( array (
				'product_id' => $product_id 
		) )->find ();
		return ! empty ( $profit ['drp_profit'] ) ? $profit ['drp_profit'] : 0;
	}
}
