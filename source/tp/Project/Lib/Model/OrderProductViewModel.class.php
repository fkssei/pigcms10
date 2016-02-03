<?php
/**
 * 订单商品数据视图
 * User: pigcms_21
 * Date: 2015/3/18
 * Time: 14:37
 */

class OrderProductViewModel extends ViewModel
{
    public $viewFields = array(
        'OrderProduct' => array('*'),
        'Product' => array('product_id','name', 'image', '_on' => 'OrderProduct.product_id = Product.product_id'),
    );

    public function getProducts($order_id)
    {
        return $this->field(array("Product.product_id AS product_id", "Product.name AS name", "pro_num", "pro_price", "sku_data", "comment", "is_packaged", "in_package_status", "image"))->where(array('OrderProduct.order_id' => $order_id))->select();
    }
	
    //店铺自有商品
    public function getStoreProduct($order_id) {
        $products = $this->where(array('order_id' => $order_id, 'is_fx' => 0))->select();
        return $products;
    }
	
	 //店铺自有商品金额
    public function getStoreProductAmount($order_id) {
        $amount = $this->where(array('order_id' => $order_id, 'is_fx' => 0))->sum('pro_price * pro_num');
        return !empty($amount) ? $amount : 0;
    }
	
    //店铺自有商品及总额
    public function getStoreProductDetail($order_id) {
        $products = $this->where(array('order_id' => $order_id, 'is_fx' => 0))->select();
		$amount = $this->where(array('order_id' => $order_id, 'is_fx' => 0))->sum('pro_price * pro_num');
		
		$return = array(
			'products' => $products,
			'amount' => $amount
		);
        return $return;
    }	
	
	
	/*店铺多个订单id 自有商品及总额
	 *@param: array():   order_id1, order_id2
	 */
    public function getStoreProductByorderArr($order_id_arr,$store_id) {
		if(!$order_id_arr) return false;
		
		$postage = $amount2 = $prodcuts2 = array();
		
		$order_id = array('in',$order_id_arr);

        $products = $this->where(array('order_id' => $order_id, 'is_fx' => 0))->select();
		$amount = $this->where(array('order_id' => $order_id, 'is_fx' => 0))->group('order_id')->field("sum(pro_price * pro_num) as zonge,order_id")->select();

		foreach($products as $k=>$v){	
			$prodcuts2[$v['order_id']][] = $v;
		}
		foreach($amount as $k=>$v){	
			$amount2[$v['order_id']] = $v['zonge'];
		}
		
		//运费
		$order = D('Order')->where(array('order_id' => $order_id))->field('fx_postage,order_id')->select();

		foreach($order as $k => $v) {
			$postages[$v['order_id']]['fx_postage'] = unserialize($v['fx_postage']);
			if(postages) $postages[$v['order_id']]['zysp_postage'] = $postages[$v['order_id']]['fx_postage'][$store_id];
		}
		
		$amount = 0;
		$return =  array(
			'product' => $prodcuts2,
			'amount' => $amount2,
			'fx_postage' => $postages
		);
		
        return $return;
    }
} 