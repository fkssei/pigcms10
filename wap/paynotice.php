<?php
/**
 *  支付异步通知
 */
require_once dirname(__FILE__).'/global.php';

// $html = '';
// foreach($_POST as $key=>$value){
	// $html .= $key.'=>'.$value.PHP_EOL;
// }
//file_put_contents('post.txt',$html);

// $html = '';
// foreach($_GET as $key=>$value){
	// $html .= $key.'=>'.$value.PHP_EOL;
// }
//file_put_contents('get.txt',$_SERVER['REQUEST_URI'].PHP_EOL.$html);

// $array_data = json_decode(json_encode(simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);
// $html = '';
// foreach($array_data as $key=>$value){
	// $html .= $key.'=>'.$value.PHP_EOL;
// }
// file_put_contents('postget.txt',$GLOBALS['HTTP_RAW_POST_DATA'].PHP_EOL.$_SERVER['REQUEST_URI'].PHP_EOL.$html);



$payType = isset($_REQUEST['pay_type']) ? $_REQUEST['pay_type'] : (isset($_REQUEST['attach']) ? $_REQUEST['attach'] : 'weixin');
$payMethodList = M('Config')->get_pay_method();
if(empty($payMethodList[$payType])){
	json_return(1009,'您选择的支付方式不存在<br/>请更新支付方式');
}
if($payType == 'yeepay'){
	import('source.class.pay.Yeepay');
	$payClass = new Yeepay(array(),$payMethodList[$payType]['config'],$wap_user);
	$payInfo = $payClass->notice();
	pay_notice_call($payInfo);
}else if($payType == 'tenpay'){
	import('source.class.pay.Tenpay');
	$payClass = new Tenpay(array(),$payMethodList[$payType]['config'],$wap_user);
	$payInfo = $payClass->notice();
	pay_notice_call($payInfo);
}else if(!empty($GLOBALS['HTTP_RAW_POST_DATA'])){
	import('source.class.pay.Weixin');
	$payClass = new Weixin(array(),$payMethodList[$payType]['config'],$wap_user,'');
	$payInfo = $payClass->notice();
	if($payInfo['err_code'] === 0){
		pay_notice_call($payInfo,$payInfo['echo_content']);
	}else{
		pay_notice_call($payInfo);
	}
}
function getSign($data,$salt) {
	foreach ($data as $key => $value) {
		if (is_array($value)) {
			$validate[$key] = getSign($value,$salt);
		} else {
			$validate[$key] = $value;
		}
		
	}
	$validate['salt'] = $salt;
	sort($validate, SORT_STRING);
	return sha1(implode($validate));
}
function pay_notice_call($payInfo,$ok_msg='success',$err_msg='fail'){
	if($payInfo['err_code'] === 0){
		$database_order = D('Order');
        $product_model = M('Product');
        $product_sku = M('Product_sku');

		$condition_order['trade_no'] = $payInfo['order_param']['trade_no'];
		$nowOrder = $database_order->where($condition_order)->find();
		if($nowOrder && $nowOrder['status'] == 1){
			$data_order['third_id'] = $payInfo['order_param']['third_id'];
			$data_order['payment_method'] = $payInfo['order_param']['pay_type'];
			$data_order['pay_money'] = $payInfo['order_param']['pay_money'];
			$data_order['paid_time'] = $_SERVER['REQUEST_TIME'];
			$data_order['status'] = 2;
			if(D('Order')->where($condition_order)->data($data_order)->save()){
				if(is_array($payInfo['order_param']['third_data'])){
					$data_order_trade['order_id'] = $nowOrder['order_id'];
					$data_order_trade['third_data'] = serialize($payInfo['order_param']['third_data']);
					D('Order_trade')->data($data_order_trade)->add();
					
					/*如果是活动的订单 将返回订单状态*/
					if($nowOrder['bak'] != ''){
						$bak = unserialize($nowOrder['bak']);
						if($bak && isset($bak['from'])){
							if(strpos($bak['from'],'pigcms') !== false){
								$apiUrl = rtrim(option('config.syn_domain'),'/').'/';
								$salt = option('config.encryption') ? option('config.encryption') : 'pigcms';
								
								$postData = array(
									'option'=>array(
										'where' => array('orderid' => $bak['orderid']),
									),
									'data' => array(
										'paid' => '1',
										'paytype' => $data_order['payment_method'],
									),
									'model' => str_replace('pigcms_','',$bak['from']),
									'toOrder' => '1',
									'token' => $bak['token'],
								);
								$postData['sign'] 	= getSign($postData,$salt);
								$url = $apiUrl.'/index.php?g=Home&m=Auth&a=update';
								api_curl_post($url,$postData);
							}
						}
					}
				}

				$nowStore = D('Store')->field('`income`,`unbalance`')->where(array('store_id'=>$nowOrder['store_id']))->find();
				if(empty($nowOrder['useStorePay'])){
					$data_store['income'] = $nowStore['income'] + $payInfo['order_param']['pay_money'];
					$data_store['unbalance'] = $nowStore['unbalance'] + $payInfo['order_param']['pay_money'];
				}
                $data_store['last_edit_time'] = time();
				//店铺收入
				if(D('Store')->where(array('store_id'=>$nowOrder['store_id']))->data($data_store)->save()){
					//收入记录
					$data_financial_record['store_id']		 = $nowOrder['store_id'];
					$data_financial_record['order_id'] 		 = $nowOrder['order_id'];
					$data_financial_record['order_no'] 		 = $nowOrder['order_no'];
					$data_financial_record['income']  		 = $payInfo['order_param']['pay_money'];
					$data_financial_record['type']    		 = '1';
					$data_financial_record['balance']     	 = $nowStore['income'];
					$data_financial_record['payment_method'] = $payInfo['order_param']['pay_type'];
					$data_financial_record['trade_no']       = $nowOrder['trade_no'];
					$data_financial_record['add_time']       = $_SERVER['REQUEST_TIME'];
                    $data_financial_record['user_order_id']  = $nowOrder['order_id'];
                    $data_financial_record['storeOwnPay']    = $nowOrder['useStorePay'];
                    $financial_record_id = D('Financial_record')->data($data_financial_record)->add();
				}
				
				if(!empty($nowOrder['uid'])){
					M('Store_user_data')->upUserData($nowOrder['store_id'],$nowOrder['uid'],'unsend');
				}
				
				//减少库存 因为支付的特殊性，不处理是否有过修改
				$database_order_product = D('Order_product');
				$condition_order_product['order_id'] = $nowOrder['order_id'];
				$orderProductList = $database_order_product->where($condition_order_product)->select();
				$database_product = D('Product');
				$database_product_sku = D('Product_sku');
                //分销商品
                $fx_product = array();
				foreach($orderProductList as $value){

                    //分销订单处理
                    $product = M('Product')->get(array('product_id' => $value['product_id']));
                    if (!empty($product['supplier_id'])) { //分销商品
                        $fx_product[$product['supplier_id']][] = array(
                            'product_id'          => $value['product_id'],
                            'sku_id'              => $value['sku_id'],
                            'sku_data'            => $value['sku_data'],
                            'quantity'            => $value['pro_num'],
                            'price'               => $value['pro_price'],
                            'cost_price'          => $product['cost_price'],
                            'postage_type'        => $product['postage_type'],
                            'postage'             => $product['postage'],
                            'postage_template_id' => $product['postage_template_id'],
                            'source_product_id'   => $product['source_product_id'], //分销商品来源
                            'original_product_id' => $product['original_product_id'], //分销商品原始id
                            'comment'             => $value['comment']
                        );
                        //获取分销商品(同步库存)
                        if (!empty($product['original_product_id'])) {
                            $where = array();
                            $where['_string'] = "product_id = '" . $product['original_product_id'] . "' OR original_product_id = '" . $product['original_product_id'] . "'";
                            $tmp_fx_products = M('Product')->getFxProducts($where);
                            $tmp_properties = '';
                            if (!empty($value['sku_data'])) {
                                $sku_data = unserialize($value['sku_data']);
                                $skus = array();
                                foreach($sku_data as $sku) {
                                    $skus[] = $sku['pid'] . ':' . $sku['vid'];
                                }
                                $tmp_properties = implode(';', $skus);
                            }
                            if (!empty($tmp_fx_products)) {
                                foreach ($tmp_fx_products as $tmp_fx_product) {
                                    $database_product->where(array('product_id' => $tmp_fx_product['product_id']))->setDec('quantity',$value['pro_num']);
                                    if (!empty($tmp_properties)) { //更新商品属性库存
                                        $database_product_sku->where(array('product_id' => $tmp_fx_product['product_id'], 'properties' => $tmp_properties))->setDec('quantity',$value['pro_num']);
                                    }
                                    if ($tmp_fx_product['product_id'] == $product['original_product_id'] || $tmp_fx_product['product_id'] == $value['product_id']) { //源商品或当前购买的商品
                                        $database_product->where(array('product_id' => $tmp_fx_product['product_id']))->setInc('sales',$value['pro_num']); //更新销量
                                        if (!empty($tmp_properties)) { //更新商品属性库存
                                            $database_product_sku->where(array('product_id' => $tmp_fx_product['product_id'], 'properties' => $tmp_properties))->setInc('sales',$value['pro_num']);
                                        }
                                    }
                                }
                            }
                        }
                    } else { //普通商品
                        if($value['sku_id']){
                            $condition_product_sku['sku_id'] = $value['sku_id'];
                            $database_product_sku->where($condition_product_sku)->setInc('sales',$value['pro_num']);
                            $database_product_sku->where($condition_product_sku)->setDec('quantity',$value['pro_num']);
                        }
                        $condition_product['product_id'] = $value['product_id'];
                        $database_product->where($condition_product)->setInc('sales',$value['pro_num']);
                        $database_product->where($condition_product)->setDec('quantity',$value['pro_num']);

                        if (!empty($product['is_fx'])) { //允许分销商品
                            $where = array();
                            $where['_string'] = "original_product_id = '" . $product['product_id'] . "'";
                            $tmp_fx_products = M('Product')->getFxProducts($where);
                            $tmp_properties = '';
                            if (!empty($value['sku_data'])) {
                                $sku_data = unserialize($value['sku_data']);
                                $skus = array();
                                foreach($sku_data as $sku) {
                                    $skus[] = $sku['pid'] . ':' . $sku['vid'];
                                }
                                $tmp_properties = implode(';', $skus);
                            }
                            if (!empty($tmp_fx_products)) {
                                foreach ($tmp_fx_products as $tmp_fx_product) {
                                    $database_product->where(array('product_id' => $tmp_fx_product['product_id']))->setDec('quantity',$value['pro_num']);
                                    if (!empty($tmp_properties)) { //更新商品属性库存
                                        $database_product_sku->where(array('product_id' => $tmp_fx_product['product_id'], 'properties' => $tmp_properties))->setDec('quantity',$value['pro_num']);
                                    }
                                }
                            }
                        }
                    }
				}

                if (!empty($fx_product)) { //订单中有分销商品
                    $fx_order = M('Fx_order');
                    $fx_order_product = M('Fx_order_product');
                    $nowAddress = unserialize($nowOrder['address']); //默认使用用户收货地址
                    foreach ($fx_product as $key => $products) {
                        $supplier_id = $key; //供货商id
                        $fx_order_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999); //分销订单号
                        $sub_total = 0;
                        $cost_sub_total = 0;
                        $postage = 0;
                        $total = 0;
                        $cost_total = 0;
                        $quantity = 0;
                        $hasTplPostage = false;
                        $postage_arr = array();
                        foreach ($products as $key => $product) {//订单商品
                            $properties = '';
                            if (!empty($product['sku_data'])) {
                                $sku_data = unserialize($product['sku_data']);
                                $skus = array();
                                foreach($sku_data as $sku) {
                                    $skus[] = $sku['pid'] . ':' . $sku['vid'];
                                }
                                $properties = implode(';', $skus);
                            }
                            $source_product_id = $product['source_product_id']; //分销来源商品
                            if (!empty($properties)) { //有属性
                                $sku = $product_sku->getSku($source_product_id, $properties);
                                $cost_price = $sku['cost_price']; //分销来源商品的成本价格
                            } else { //无属性
                                $source_product_info = $product_model->get(array('product_id' => $source_product_id), 'cost_price');
                                $cost_price = $source_product_info['cost_price']; //分销来源商品的成本价格
                            }
                            $price = $product['price'];
                            $products[$key]['cost_price'] = $cost_price;

                            $sub_total += ($price * $product['quantity']); //订单商品总金额
                            $cost_sub_total += ($cost_price * $product['quantity']); //订单商品成本总金额
                            $quantity += $product['quantity']; //订单商品总数量

                            //来源商品供货商
                            $product_info = $product_model->get(array('product_id' => $source_product_id), 'store_id');
                            $original_supplier_id = $product_info['store_id'];
                        }
                        //订单运费
                        $fx_postages = array();
                        if (!empty($nowOrder['fx_postage'])) {
                            $fx_postages = unserialize($nowOrder['fx_postage']);
                        }
                        $postage = !empty($fx_postages[$supplier_id]) ? $fx_postages[$supplier_id] : 0; //供货商运费
                        //订单总金额
                        $total = $sub_total + $postage;
                        //订单成本总金额
                        $cost_total = $cost_sub_total + $postage;

                        $data = array(
                            'fx_order_no'      => $fx_order_no,
                            'uid'              => $nowOrder['uid'],
                            'session_id'       => $nowOrder['session_id'],
                            'order_id'         => $nowOrder['order_id'],
                            'order_no'         => $nowOrder['order_no'],
                            'fx_trade_no'      => date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999),
                            'supplier_id'      => $supplier_id,
                            'store_id'         => $nowOrder['store_id'],
                            'quantity'         => $quantity,
                            'sub_total'        => $sub_total,
                            'cost_sub_total'   => $cost_sub_total,
                            'postage'          => $postage, //分销订单运费
                            'total'            => $total,
                            'cost_total'       => $cost_total,
                            'delivery_user'    => $nowOrder['address_user'],
                            'delivery_tel'     => $nowOrder['address_tel'],
                            'delivery_address' => $nowOrder['address'],
                            'add_time'         => time(),
                            'user_order_id'    => $nowOrder['order_id'],
                            'fx_postage'       => $nowOrder['fx_postage'],
                            'status'           => 2
                        );
                        if ($fx_order_id = $fx_order->add($data)) { //添加分销商订单
                            //标识订单为分销订单（包含分销商品）
                            M('Order')->setFxOrder($nowOrder['store_id'], $nowOrder['order_id']);
                            $suppliers = array();
                            //添加订单商品
                            foreach ($products as $product) {
                                if (!empty($product['original_product_id'])) {
                                    $product_info = $database_product->field('store_id, original_product_id')->where(array('product_id' => $product['original_product_id']))->find();
                                    $tmp_supplier_id = $product_info['store_id'];
                                } else {
                                    $product_info = $database_product->field('store_id')->where(array('product_id' => $product['product_id']))->find();
                                    $tmp_supplier_id = $product_info['store_id'];
                                }
                                $suppliers[] = $tmp_supplier_id;
                                $fx_order_product->add(array('fx_order_id' => $fx_order_id, 'product_id' => $product['product_id'], 'source_product_id' => $product['product_id'], 'price' => $product['price'], 'cost_price' => $product['cost_price'], 'quantity' => $product['quantity'], 'sku_id' => $product['sku_id'], 'sku_data' => $product['sku_data'], 'comment' => $product['comment']));
                            }
                            $suppliers = array_unique($suppliers); //分销商
                            $suppliers = implode(',', $suppliers);
                            if (!empty($suppliers)) { //修改订单，设置分销商
                                D('Fx_order')->where(array('fx_order_id' => $fx_order_id))->data(array('suppliers' => $suppliers))->save();
                            }
                        }
                    }
                    //获取分销利润
                    if (!empty($financial_record_id) && !empty($cost_total)) {
                        $profit = $total - $cost_total;
                        if ($profit > 0) {
                            D('Financial_record')->where(array('pigcms_id' => $financial_record_id))->data(array('profit' => $profit))->save();
                        }
                    }
                    //逐级提交订单
                    $drp_level = $nowStore['drp_level']; //当前分销等级
                    $supplier_chain = D('Store_supplier')->where(array('seller_id' => $nowOrder['store_id']))->find();
                    $supply_chain = $supplier_chain['supply_chain'];
                    if ($supplier_chain['type'] == 1) { //排他分销
                        $suppliers = explode(',', $supply_chain);
                        sort($suppliers);
                        $suppliers = array_reverse($suppliers);
                        array_pop($suppliers);
                        if (!empty($suppliers)) {
                            foreach ($suppliers as $supplier) {
                                $fx_order_info = D('Fx_order')->where(array('supplier_id' => $supplier, 'user_order_id' => $nowOrder['order_id']))->find();
                                if (!empty($fx_order_info)) {
                                    $tmp_data['trade_no']    = date('YmdHis', $_SERVER['REQUEST_TIME']) . mt_rand(100000, 999999);
                                    $tmp_data['total']       = $fx_order_info['cost_total'];
                                    $tmp_data['postage']     = $fx_order_info['postage'];
                                    $tmp_data['order_id']    = $fx_order_info['fx_order_id'];
                                    $tmp_data['supplier_id'] = $supplier;
                                    $tmp_data['seller_id']   = $fx_order_info['store_id'];
                                    pay($tmp_data);
                                }
                            }
                        }
                    }
                }
				// 更改赠送的优惠券为可用
				M('User_coupon')->save(array('is_valid' => 1), array('give_order_id' => $nowOrder['order_id']));
				exit($ok_msg);
			}else{
				exit($err_msg);
			}
		}else{
			exit($err_msg);
		}
	}else{
		exit($ok_msg);
	}
}

function pay($data)
{
    $order = M('Order');
    $order_product = M('Order_product');
    $fx_order = M('Fx_order');
    $fx_order_product = M('Fx_order_product');
    $store = M('Store');
    $financial_record = M('Financial_record');
    $store_supplier = M('Store_supplier');
    $product_model = M('Product');
    $product_sku = M('Product_sku');

    $total = $data['total']; //付款总金额

    //付款给供货商
    $fx_order_id = explode(',', $data['order_id']); //合并支付会出现多个订单ID
    $supplier = $store->getStore($data['supplier_id']); //供货商
    //如果store_supplier中的seller_id字段值中有当前供货商并且type分销类型为1，则表示当前供货商同时也是分销商，则为其供货商添加分销订单
    $seller_info = $store_supplier->getSeller(array('seller_id' => $data['supplier_id'], 'type' => 1));
    if (!empty($seller_info)) {
        $is_supplier = false;
    } else {
        $is_supplier = true;
    }
    $seller = $store->getStore($data['seller_id']); //分销商
    if ($total > 0) {
        //供货商不可用余额和收入加商品成本
        if ($store->setUnBalanceInc($data['supplier_id'], $total) && $store->setIncomeInc($data['supplier_id'], $total)) {
            foreach ($fx_order_id as $id) {
                //修改分销订单状态为等待供货商发货并且关联供货商订单id
                $fx_order->edit(array('fx_order_id' => $id), array('status' => 2, 'paid_time' => time()));
                $fx_order_info = $fx_order->getOrder($data['seller_id'], $id); //分销订单详细
                $order_id = $fx_order_info['order_id']; //主订单ID
                //主订单分销商品
                $fx_products = $order_product->getFxProducts($order_id, $id, $is_supplier);
                $order_info = $order->getOrder($data['seller_id'], $order_id);
                $order_trade_no = $order_info['trade_no']; //主订单交易号
                unset($order_info['order_id']);
                $order_info['order_no']       = date('YmdHis',time()).mt_rand(100000,999999);
                $order_info['store_id']       = $data['supplier_id'];
                $order_info['trade_no']       = date('YmdHis',time()).mt_rand(100000,999999);
                $order_info['third_id']       = '';
                $order_info['uid']            = $seller['uid']; //下单用户（分销商）
                $order_info['session_id']     = '';
                $order_info['postage']        = $fx_order_info['postage'];
                $order_info['sub_total']      = $fx_order_info['cost_sub_total'];
                $order_info['total']          = $fx_order_info['cost_total'];
                $order_info['status']         = 2; //未发货
                $order_info['pro_count']      = 0; //商品种类数量
                $order_info['pro_num']        = $fx_order_info['quantity']; //商品件数
                $order_info['payment_method'] = 'balance';
                $order_info['type']           = 3; //分销订单
                $order_info['add_time']       = time();
                $order_info['paid_time']      = time();
                $order_info['sent_time']      = 0;
                $order_info['cancel_time']    = 0;
                $order_info['complate_time']  = 0;
                $order_info['refund_time']    = 0;
                $order_info['star']           = 0;
                $order_info['pay_money']      = $fx_order_info['cost_total'];
                $order_info['cancel_method']  = 0;
                $order_info['float_amount']   = 0;
                $order_info['is_fx']          = 0;
                $order_info['fx_order_id']    = $id; //关联分销商订单id（fx_order）
                $order_info['user_order_id']  = $fx_order_info['user_order_id'];
                if ($new_order_id = $order->add($order_info)) { //向供货商提交一个新订单
                    $suppliers = array();
                    foreach ($fx_products as $key => $fx_product) {
                        unset($fx_product['pigcms_id']);
                        //获取分销商品的来源
                        $product_info = $product_model->get(array('product_id' => $fx_product['product_id']), 'source_product_id,original_product_id');
                        if (!empty($product_info['source_product_id'])) {
                            $fx_product['product_id'] = $product_info['source_product_id'];

                            $properties = ''; //商品属性字符串
                            if (!empty($fx_product['sku_data'])) {
                                $sku_data = unserialize($fx_product['sku_data']);
                                $skus = array();
                                foreach($sku_data as $sku) {
                                    $skus[] = $sku['pid'] . ':' . $sku['vid'];
                                }
                                $properties = implode(';', $skus);
                            }
                            if (!empty($properties)) { //有属性
                                $sku = $product_sku->getSku($fx_product['product_id'], $properties);
                                $fx_product['pro_price'] = $sku['cost_price']; //分销来源商品的成本价格
                                $fx_product['sku_id'] = $sku['sku_id'];
                            } else { //无属性
                                $source_product_info = $product_model->get(array('product_id' => $fx_product['product_id']), 'price,cost_price');
                                $fx_product['pro_price'] = $source_product_info['cost_price']; //分销来源商品的成本价格
                            }
                        }

                        $fx_product['order_id']          = $new_order_id;
                        $fx_product['pro_price']         = $fx_product['price'];
                        $fx_product['is_packaged']       = 0;
                        $fx_product['in_package_status'] = 0;
                        //判断是否是店铺自有商品
                        $super_product_info = $product_model->get(array('product_id' => $product_info['source_product_id']), 'source_product_id,original_product_id');
                        if (empty($seller_info) || empty($super_product_info['source_product_id'])) { //供货商或商品供货商
                            $fx_product['is_fx']             = 0;
                        } else {
                            $fx_product['is_fx']             = 1;
                        }
                        unset($fx_product['price']);
                        $order_product->add($fx_product); //添加新订单商
                        $fx_products[$key]['pro_price'] = $fx_product['pro_price'];
                        $fx_products[$key]['source_product_id'] = $fx_product['product_id'];
                        $suppliers[] = $fx_product['supplier_id'];
                    }
                    //修改订单供货商
                    $suppliers = array_unique($suppliers);
                    $suppliers = implode(',', $suppliers);
                    D('Order')->where(array('order_id' => $new_order_id))->data(array('suppliers' => $suppliers))->save();

                    //添加供货商财务记录（收入）
                    $data_record = array();
                    $data_record['store_id']         = $data['supplier_id'];
                    $data_record['order_id'] 		 = $new_order_id;
                    $data_record['order_no'] 		 = $order_info['order_no'];
                    $data_record['income']  		 = $fx_order_info['cost_total'];
                    $data_record['type']    		 = 5; //分销
                    $data_record['balance']     	 = $supplier['income'];
                    $data_record['payment_method']   = 'balance';
                    $data_record['trade_no']         = $order_info['trade_no'];
                    $data_record['add_time']         = time();
                    $data_record['status']           = 1;
                    $data_record['user_order_id']    = $order_info['user_order_id'];
                    $financial_record_id = D('Financial_record')->data($data_record)->add();

                    //判断供货商，如果上级供货商是分销商，添加分销订单
                    if (!empty($seller_info)) {
                        $cost_sub_total = 0;
                        $sub_total = 0;
                        $tmp_fx_products = array();
                        foreach ($fx_products as $k => $fx_product) {
                            $properties = ''; //商品属性字符串
                            if (!empty($fx_product['sku_data'])) {
                                $sku_data = unserialize($fx_product['sku_data']);
                                $skus = array();
                                foreach($sku_data as $sku) {
                                    $skus[] = $sku['pid'] . ':' . $sku['vid'];
                                }
                                $properties = implode(';', $skus);
                            }
                            //获取分销商品的来源
                            $product_info = $product_model->get(array('product_id' => $fx_product['product_id']), 'source_product_id,original_product_id');
                            $source_product_id = $product_info['source_product_id']; //分销来源商品
                            $original_product_id = $product_info['original_product_id'];
                            if (empty($source_product_id) || $original_product_id == $source_product_id) { //商品供货商或商品供货商为上级分销商
                                unset($fx_products[$k]);
                                continue;
                            }
                            $tmp_fx_product = $fx_product;
                            if (!empty($seller_info) && !empty($product_info['original_product_id'])) {
                                $product_info = $product_model->get(array('product_id' => $source_product_id), 'source_product_id,original_product_id');
                                $source_product_id = $product_info['source_product_id']; //分销来源商品
                            }
                            if (!empty($properties)) { //有属性
                                $sku = $product_sku->getSku($source_product_id, $properties);
                                //$price = $sku['price'];
                                $cost_price = $sku['cost_price']; //分销来源商品的成本价格
                                $sku_id = $sku['sku_id'];
                            } else { //无属性
                                $source_product_info = $product_model->get(array('product_id' => $source_product_id), 'price,cost_price');
                                //$price = $source_product_info['price'];
                                $cost_price = $source_product_info['cost_price']; //分销来源商品的成本价格
                                $sku_id = 0;
                            }
                            $cost_sub_total += $cost_price;
                            $sub_total += $fx_product['pro_price'];
                            $tmp_fx_product['product_id'] = $source_product_id;
                            $tmp_fx_product['price'] = $fx_product['pro_price'];
                            $tmp_fx_product['cost_price'] = $cost_price;
                            $tmp_fx_product['sku_id'] = $sku_id;
                            $tmp_fx_product['original_product_id'] = $original_product_id;
                            $tmp_fx_products[] = $tmp_fx_product;
                        }
                        if (!empty($fx_products)) {
                            $fx_order_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999); //分销订单号
                            //运费
                            $fx_postages = array();
                            if (!empty($order_info['fx_postage'])) {
                                $fx_postages = unserialize($order_info['fx_postage']);
                            }
                            $postage = !empty($fx_postages[$seller_info['supplier_id']]) ? $fx_postages[$seller_info['supplier_id']] : 0;
                            $data2 = array(
                                'fx_order_no'      => $fx_order_no,
                                'uid'              => $order_info['uid'],
                                'order_id'         => $new_order_id,
                                'order_no'         => $order_info['order_no'],
                                'fx_trade_no'      => $data['trade_no'],
                                'supplier_id'      => $seller_info['supplier_id'],
                                'store_id'         => $data['supplier_id'],
                                'quantity'         => $fx_order_info['quantity'],
                                'sub_total'        => $sub_total,
                                'cost_sub_total'   => $cost_sub_total,
                                'postage'          => $postage,
                                'total'            => ($sub_total + $postage),
                                'cost_total'       => ($cost_sub_total + $postage),
                                'delivery_user'    => $order_info['address_user'],
                                'delivery_tel'     => $order_info['address_tel'],
                                'delivery_address' => $order_info['address'],
                                'add_time'         => time(),
                                'user_order_id'    => $order_info['user_order_id']
                            );
                            if ($fx_order_id = $fx_order->add($data2)) { //添加分销商订单
                                foreach ($tmp_fx_products as $tmp_fx_product) {
                                    if (!empty($tmp_fx_product['product_id'])) {
                                        $product_info = D('Product')->field('store_id, original_product_id')->where(array('product_id' => $tmp_fx_product['original_product_id']))->find();
                                        $tmp_supplier_id = $product_info['store_id'];
                                        $fx_order_product->add(array('fx_order_id' => $fx_order_id, 'product_id' => $tmp_fx_product['product_id'], 'source_product_id' => $tmp_fx_product['source_product_id'], 'price' => $tmp_fx_product['price'], 'cost_price' => $tmp_fx_product['cost_price'], 'quantity' => $tmp_fx_product['pro_num'], 'sku_id' => $tmp_fx_product['sku_id'], 'sku_data' => $tmp_fx_product['sku_data'], 'comment' => $tmp_fx_product['comment']));
                                    }
                                }
                                if (!empty($tmp_supplier_id)) { //修改订单，设置分销商
                                    D('Fx_order')->where(array('fx_order_id' => $fx_order_id))->data(array('suppliers' => $tmp_supplier_id))->save();
                                }
                            }
                            //获取分销利润
                            if (!empty($financial_record_id) && !empty($data2['cost_total'])) {
                                $profit = $data2['total'] - $data2['cost_total'];
                                if ($profit > 0) {
                                    D('Financial_record')->where(array('pigcms_id' => $financial_record_id))->data(array('profit' => $profit))->save();
                                }
                            }
                        }
                    }

                    //分销商不可用余额和收入减商品成本
                    if ($store->setUnBalanceDec($data['seller_id'], $fx_order_info['cost_total']) && $store->setIncomeDec($data['seller_id'], $fx_order_info['cost_total'])) {
                        //添加分销商财务记录（支出）
                        $order_no = $order_info['order_no'];
                        $data_record = array();
                        $data_record['store_id']         = $data['seller_id'];
                        $data_record['order_id'] 		 = $order_id;
                        $data_record['order_no'] 		 = $order_no;
                        $data_record['income']  		 = (0 - $fx_order_info['cost_total']);
                        $data_record['type']    		 = 5; //分销
                        $data_record['balance']     	 = $seller['income'];
                        $data_record['payment_method']   = 'balance';
                        $data_record['trade_no']         = $order_trade_no;
                        $data_record['add_time']         = time();
                        $data_record['status']           = 1;
                        $data_record['user_order_id']    = $order_info['user_order_id'];
                        D('Financial_record')->data($data_record)->add();
                    } else { //操作失败，记录日志文件
                        $supplier_name = $supplier['name'];
                        $seller_name = $seller['name'];
                        $dir = './upload/pay/';
                        if(!is_readable($dir))
                        {
                            is_file($dir) or mkdir($dir, 0777);
                        }
                        file_put_contents($dir . 'error.txt', '[' . date('Y-m-d H:i:s') . '] 付款给供货商失败，订单类型：分销，订单ID：' . $order_id . '，交易单号：' . $order_trade_no . '，供货商（收款方）：' . $supplier_name . '，分销商（付款方）：' . $seller_name . '，付款金额：' . $fx_order_info['cost_total'] . '元，请手动从 ' . $seller_name . ' 账户余额中减' . $fx_order_info['cost_total'] . '元' . PHP_EOL, FILE_APPEND );
                        return array('err_code' => 1005, 'err_msg' => '付款失败，请联系客服处理，交易单号：' . $order_trade_no);
                    }
                }
            }
            return array('err_code' => 0, 'err_msg' => '付款成功，等待供货商发货');
        } else {
            return array('err_code' => 1004, 'err_msg' => '付款失败');
        }
    } else {
        return array('err_code' => 1003, 'err_msg' => '付款金额无效');
    }

}
?>