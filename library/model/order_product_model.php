<?php
/**
 * 订单商品数据模型
 */
class order_product_model extends base_model{
	/*得到一个订单的商品信息*/
	public function orderProduct($order_id,$getPro=true){
		if($getPro){
			$orderProduct = D('')->table(array('Product'=>'p','Order_product'=>'op'))->where("`op`.`order_id`='$order_id' AND `op`.`product_id`=`p`.`product_id`")->order('`op`.`pigcms_id` ASC')->select();
		}else{
			$orderProduct = $this->db->where(array('order_id'=>$order_id))->order('`pigcms_id` ASC')->select();
		}
		foreach($orderProduct as &$value){
			if($value['sku_id']){
				$value['sku_data_arr'] = unserialize($value['sku_data']);
			}
			if($value['comment']){
				$value['comment_arr'] = unserialize($value['comment']);
			}

			$value['image'] = getAttachmentUrl($value['image']);
		}
		return $orderProduct;
	}

	/**
	 * 获取一个产品，用户购买此产品的历史数量
	 * 主要用于限购
	 */
	public function getProductPronum($product_id, $uid) {
		if (empty($product_id) || empty($uid)) {
			return 0;
		}

		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT SUM(op.pro_num) as pro_num FROM " . $db_prefix . "order_product as op left join " . $db_prefix . "order AS o ON op.order_id = o.order_id WHERE o.uid = '" . $uid . "' AND op.product_id = '" . $product_id . "' AND o.status < 5";
		$pro_num = $this->db->query($sql);

		return $pro_num[0]['pro_num'];
	}

	public function getProducts($order_id) {
		$products = $this->db->query("SELECT p.product_id,p.name,p.image,op.pro_num,op.pro_price,op.sku_id,op.sku_data,op.comment,op.is_packaged,op.in_package_status,op.is_fx,op.original_product_id,op.is_present FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "product p WHERE op.product_id = p.product_id AND op.order_id = '" . $order_id . "'");

		foreach($products as &$value){
			$value['image'] = getAttachmentUrl($value['image']);
		}

		return $products;
	}

	/**
	 * 查看用户对产品是否未评论
	 */
	public function isComment($product_id) {
		if (empty($product_id)) {
			return false;
		}

		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT op.* FROM " . $db_prefix . "order_product op, " . $db_prefix . "order o WHERE op.order_id = o.order_id AND o.uid = '" . $_SESSION['user']['uid'] . "' AND op.product_id = '" . $product_id . "' AND o.status = 4 AND op.is_comment = 0 LIMIT 1";
		$order_product = $this->db->query($sql);

		if (empty($order_product)) {
			return false;
		} else {
			return $order_product[0];
		}
	}

    //主订单分销商品
    public function getFxProducts($order_id, $fx_order_id, $supplier = false)
    {
        $sql = "SELECT op.*,fop.cost_price AS price FROM " . option('system.DB_PREFIX') . "order_product op," . option('system.DB_PREFIX') . "fx_order_product fop WHERE op.product_id = fop.source_product_id AND op.order_id = '" . $order_id . "' AND fop.fx_order_id = '" . $fx_order_id . "'";
        if (!$supplier) {
            $sql .= ' AND op.is_fx = 1';
        }
        $products = $this->db->query($sql);
        return $products;
    }

    //设置包裹信息
    public function setPackageInfo($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }

    //未打包的商品(不包括分销商品)
    public function getUnPackageProducts($order_id)
    {
        $products = $this->db->query("SELECT p.product_id,p.name,p.image,op.pro_num,op.pro_price,op.sku_data,op.comment,op.is_packaged,op.in_package_status FROM " . option('system.DB_PREFIX') . "order_product op, " . option('system.DB_PREFIX') . "product p WHERE op.product_id = p.product_id AND op.order_id = '" . $order_id . "' AND op.is_packaged = 0 AND op.is_fx = 0");
        return $products;
    }

    //未打包的商品（）
    public function getUnPackageProductCount($where)
    {
        $count = $this->db->where($where)->count('product_id');
        return $count;;
    }

    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    //店铺自有商品
    public function getStoreProduct($order_id)
    {
        $products = $this->db->where(array('order_id' => $order_id, 'is_fx' => 0))->select();
        return $products;
    }

    //店铺自有商品金额
    public function getStoreProductAmount($order_id)
    {
        $amount = $this->db->where(array('order_id' => $order_id, 'is_fx' => 0))->sum('pro_price * pro_num');
        return !empty($amount) ? $amount : 0;
    }
}
?>