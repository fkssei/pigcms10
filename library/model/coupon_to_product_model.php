<?php
/**
 * 优惠券产品model
 */
class coupon_to_product_model extends base_model{
	/**
	 * 根据条件获到优惠券产品列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order_by)) {
			$this->db->order($order_by);
		}
		
		if (!empty($limit)) {
			$this->db->limit($offset . ',' . $limit);
		}
		
		$coupon_list = $this->db->select();
		
		return $coupon_list;
	}

	/**
	 * 根据店铺返回，所有参加活动产品ID列表
	 * 参数$couid，去除$couid的优惠券产品ID列表
	 */
	public function getProductIDList($couid = 0) {
		$time = time();
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT ctp.product_id, cou.id FROM `" . $db_prefix . "coupon_to_product` AS ctp LEFT JOIN `" . $db_prefix . "coupon` AS cou ON `ctp`.`coupon_id` = `cou`.`id` WHERE cou.store_id = '" . $_SESSION['store']['store_id'] . "' AND cou.uid = '" . $_SESSION['store']['uid'] . "' AND cou.start_time <= '" . $time . "' AND cou.end_time >= '" . $time . "' AND cou.status = '1'";
		if (!empty($couid)) {
			$sql .= " AND cou.id != '" . $couid . "'";
		}
		$product_id_list = $this->db->query($sql);

		$data = array();
		foreach ($product_id_list as $tmp) {
			$data[$tmp['id'] .'_' . $tmp['product_id']] = $tmp['product_id'];
		}
		return $data;
	}

	/**
	 * 根据优惠券ID查寻出所有相关产品
	 */
	public function getProductListByPid($coupon_id) {
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT p.* FROM `" . $db_prefix . "coupon_to_product` AS pp LEFT JOIN `" . $db_prefix . "product` AS p ON `pp`.`product_id` = p.product_id WHERE pp.coupon_id = '" . $coupon_id . "'";

		$product_list = $this->db->query($sql);
		foreach ($product_list as &$product) {
			$product['image'] = getAttachmentUrl($product['image']);
		}

		//echo $this->db->last_sql;exit;
		return $product_list;
	}

	/**
	 * 根据优惠券商品 查找对应产品信息列表
	 * @param $where is string
	 * @param $orderbyfield 排序字段
	 * @param $orderbymethod 排序方式 ASC DESC
	 * @param $offset
	 * @param $limit
	 * @return array
	 */
	public function getSellingCouponProduct($where, $order_by_field, $order_by_method, $offset, $limit){
		if (!empty($order_by_field) && !empty($order_by_method)) {
			$order = $order_by_field . ' ' . strtoupper($order_by_method);
		} else { //默认排序
			$order = 'p.sort DESC, p.product_id DESC';
		}

		$where = $where. " and p.status=1";

		$products=$this->db->table("Coupon_to_product as cp")-> join('Product as p ON cp.product_id=p.product_id','LEFT')
							-> where($where)->order($order)
							-> limit($offset . ',' . $limit)
							-> field("p.*,cp.coupon_id")
							-> select();

		foreach ($products as &$tmp) {
			$tmp['image'] = getAttachmentUrl($tmp['image']);
			$tmp['link'] = url_rewrite('goods:index', array('id' => $tmp['product_id']));
		}
		return $products;

	}


	/**
	 * 获取优惠券的出售中的商品数量
	 * @param:  is string
	 */
	public function getSellingCouponProductTotal($where){
			$where = $where. " and p.status=1";

			$products = $this->db->table("Coupon_to_product as cp")-> join('Product as p ON cp.product_id=p.product_id','LEFT')
								-> where($where)
								-> count('p.product_id');

			return $products;

		}

	/**
	 * 新增优惠券产品
	 */
	function add($data) {
		$this->db->data($data)->add();
	}
	
	/**
	 * 更改优惠券,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}
	
	/**
	 * 删除
	 */
	public function delete($where) {
		$this->db->where($where)->delete();
	}
}