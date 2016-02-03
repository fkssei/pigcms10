<?php
/**
 *  处理订单
 */
require_once dirname(__FILE__).'/global.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'add';

switch($action){
	case 'add':
		if(IS_POST){
			if($wap_user['uid']){
				$data_user_address['uid'] = $wap_user['uid'];
			}else{
				$data_user_address['session_id'] = session_id();
			}
			$data_user_address['name'] = !empty($_POST['name']) ? $_POST['name'] : json_return(1000,'请填写名字');
			$data_user_address['tel'] = !empty($_POST['tel']) ? $_POST['tel'] : json_return(1001,'请填写联系电话');
			$data_user_address['province'] = !empty($_POST['province']) ? $_POST['province'] : json_return(1002,'请选择地区');
			$data_user_address['city'] = !empty($_POST['city']) ? $_POST['city'] : json_return(1003,'请选择地区');
			$data_user_address['area'] = !empty($_POST['area']) ? $_POST['area'] : json_return(1004,'请选择地区');
			$data_user_address['address'] = !empty($_POST['address']) ? $_POST['address'] : json_return(1005,'请填写详细地址');
			$data_user_address['zipcode'] = !empty($_POST['zipcode']) ? $_POST['zipcode'] : 0;
			$data_user_address['add_time'] = $_SERVER['REQUEST_TIME'];
			if($data_user_address['address_id'] = D('User_address')->data($data_user_address)->add()){
				json_return(0,$data_user_address);
			}else{
				json_return(1006,'添加地址失败,请重试');
			}
		}
		break;
	case 'edit':
		if(IS_POST){
			$condition_user_address['address_id'] = $_POST['address_id'];
			if($wap_user['uid']){
				$condition_user_address['uid'] = $wap_user['uid'];
			}else{
				$condition_user_address['session_id'] = session_id();
			}
			$data_user_address['name'] = !empty($_POST['name']) ? $_POST['name'] : json_return(1000,'请填写名字');
			$data_user_address['tel'] = !empty($_POST['tel']) ? $_POST['tel'] : json_return(1001,'请填写联系电话');
			$data_user_address['province'] = !empty($_POST['province']) ? $_POST['province'] : json_return(1002,'请选择地区');
			$data_user_address['city'] = !empty($_POST['city']) ? $_POST['city'] : json_return(1003,'请选择地区');
			$data_user_address['area'] = !empty($_POST['area']) ? $_POST['area'] : json_return(1004,'请选择地区');
			$data_user_address['address'] = !empty($_POST['address']) ? $_POST['address'] : json_return(1005,'请填写详细地址');
			$data_user_address['zipcode'] = !empty($_POST['zipcode']) ? $_POST['zipcode'] : 0;
			$data_user_address['add_time'] = $_SERVER['REQUEST_TIME'];
			if(D('User_address')->where($condition_user_address)->data($data_user_address)->save()){
				$data_user_address['address_id'] = $_POST['address_id'];
				json_return(0,$data_user_address);
			}else{
				json_return(1006,'添加地址失败,请重试');
			}
		}
		break;
	case 'postage':
		if(IS_POST){
			$address_id = $_POST['address_id'];
			$province_id = $_POST['province_id'];
			
			if (!empty($address_id)) {
				$nowAddress = D('User_address')->field('`province`')->where(array('address_id'=>$_POST['address_id']))->find();
				if(empty($nowAddress)) json_return(1007,'该地址不存在');
			} else if (!empty($province_id)) {
				import('area');
				$areaClass = new area();
				$province_txt = $areaClass->get_name($province_id);
				if (empty($province_txt)) {
					json_return(1007,'该地址不存在');
				}
				$nowAddress['province'] = $province_id;
			} else {
				json_return(1007,'该地址不存在');
			}
			
			$nowOrder = M('Order')->find($_POST['orderNo']);
			if(empty($nowOrder)) json_return(1008,'该订单不存在');
            if (empty($nowOrder['address'])) {
                //计算运费
                $postage_arr = array();
                $hasTplPostage = false;
                $order_products = array();
                $postage_details = array();

                // 有无运费模板
                $has_tpl_postage_arr = array();
                $hast_tpl_postage_arr = array();

                $postage_template_model = M('Postage_template');
                foreach ($nowOrder['proList'] as $key => $product) {
                    if (empty($product['supplier_id'])) {
                        $product['supplier_id'] = $product['store_id'];
                    }

                    if ($product['postage_template_id']) {
                        $postage_template = $postage_template_model->get_tpl($product['postage_template_id'], $product['supplier_id']);

                        // 没有相应运费模板，直接跳出
                        if (empty($postage_template)) {
                            json_return(1009, '');
                        }

                        $has_tpl = false;
                        foreach ($postage_template['area_list'] as $area) {
                            $has_tpl = false;
                            if (in_array($nowAddress['province'], explode('&', $area[0]))) {
                                if (isset($has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['protage_template_id']])) {
                                    $has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']]['weight'] += $product['pro_num'] * $product['pro_weight'];
                                } else {
                                    $has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']]['weight'] = $product['pro_num'] * $product['pro_weight'];
                                    $has_tpl_postage_arr[$product['supplier_id'] . '_' . $product['postage_template_id']]['area'] = $area;
                                }

                                $has_tpl = true;
                                break;
                            }
                        }

                        // 没有相应运费模板，直接跳出
                        if (!$has_tpl) {
                            json_return(1009, '');
                        }
                    } else {
                        $hast_tpl_postage_arr[$product['supplier_id']] += $product['postage'];
                    }
                }


                $supplier_postage_arr = array();
                $postageCount = 0;
                foreach ($has_tpl_postage_arr as $key => $postage_detail) {
                    list($supplier_id, $tpl_id) = explode('_', $key);
                    $supplier_postage_arr[$supplier_id] += $postage_detail['area'][2];
                    $postageCount += $postage_detail['area'][2];
                    if ($postage_detail['weight'] > $postage_detail['area']['1'] && $postage_detail['area'][3] > 0 && $postage_detail['area'][4] > 0) {
                        $supplier_postage_arr[$supplier_id] += ceil(($postage_detail['weight'] - $postage_detail['area']['1']) / $postage_detail['area'][3]) * $postage_detail['area']['4'];
                        $postageCount += ceil(($postage_detail['weight'] - $postage_detail['area']['1']) / $postage_detail['area'][3]) * $postage_detail['area']['4'];
                    }
                }

                foreach ($hast_tpl_postage_arr as $key => $postage) {
                    $supplier_postage_arr[$key] += $postage;
                    $postageCount += $postage;
                }

                $fx_postage = '';
                if (!empty($supplier_postage_arr)) {
                    $fx_postage = serialize($supplier_postage_arr);
                }

                $condition_order['order_id'] = $nowOrder['order_id'];
                $data_order['postage'] = $postageCount;
                $data_order['total'] = $nowOrder['sub_total'] + $postageCount;
                $data_order['fx_postage'] = $fx_postage;
                D('Order')->where($condition_order)->data($data_order)->save();
                json_return(0,$postageCount);


                foreach($nowOrder['proList'] as $value){
                    if($value['postage_template_id']){
                        $supplier_id = $value['supplier_id'];

                        // 当供货商为空时，直接用产品的店铺ID
                        if (empty($supplier_id)) {
                            $supplier_id = $value['store_id'];
                            $value['supplier_id'] = $value['store_id'];
                        }

                        $postage_template = M('Postage_template')->get_tpl($value['postage_template_id'], $supplier_id);
                        if(!empty($postage_template['area_list'])){
                            $inTpl = false;
                            foreach($postage_template['area_list'] as $v){
                                if(in_array($nowAddress['province'],explode('&',$v[0]))){
                                    if (!empty($v[3]) && $v[3] > 0) {
                                        $postage_arr[$value['supplier_id']][] = $value['pro_num'] > $v[1] ? $v[2]+floor(($value['pro_num']-$v[1])/$v[3])*$v[4] : $v[2];
                                    } else {
                                        $postage_arr[$value['supplier_id']][] = 0;
                                    }
                                    $inTpl = $hasTplPostage = true;
                                    break;
                                }
                            }
                            if($inTpl === false){
                                $condition_order['order_id'] = $nowOrder['order_id'];
                                $data_order['postage'] = $data_order['total'] = 0;
                                D('Order')->where($condition_order)->data($data_order)->save();
                                json_return(1009,'');
                            }
                        }
                    }else{
                        $postage_arr[$value['supplier_id']][] = $value['postage'];
                    }
                    if (!empty($value['supplier_id']) && !empty($postage_arr[$value['supplier_id']])) {
                        $postage_details[$value['supplier_id']] = $postage_arr[$value['supplier_id']];//不同供货商运费单独计算
                    }
                }

                //分销运费详细
                $fx_postage = array();
                $postageCount = 0;
                if (!empty($postage_details)) {
                    foreach ($postage_details as $supplier_id => $postage_detail) {
                        $postageCount += ($hasTplPostage ? array_sum($postage_detail) : min($postage_detail));
                        $fx_postage[$supplier_id] = ($hasTplPostage ? array_sum($postage_detail) : min($postage_detail));
                    }
                    $fx_postage = serialize($fx_postage);
                } else {
                    $fx_postage = '';
                }
                /*foreach($nowOrder['proList'] as $value){
                    if($value['postage_template_id']){
                        $store_id = $nowOrder['store_id'];
                        $postage_template = M('Postage_template')->get_tpl($value['postage_template_id'], $store_id);
                        if($postage_template['area_list']){
                            $inTpl = false;
                            foreach($postage_template['area_list'] as $v){
                                if(in_array($nowAddress['province'],explode('&',$v[0]))){
                                    $postage_arr[] = $value['pro_num'] > $v[1] ? $v[2]+floor(($value['pro_num']-$v[1])/$v[3])*$v[4] : $v[2];
                                    $inTpl = $hasTplPostage = true;
                                    break;
                                }
                            }
                            if($inTpl === false){
                                $condition_order['order_id'] = $nowOrder['order_id'];
                                $data_order['postage'] = $data_order['total'] = 0;
                                D('Order')->where($condition_order)->data($data_order)->save();
                                json_return(1009,'');
                            }
                        }
                    }else{
                        $postage_arr[] = $value['postage'];
                    }
                }*/
                $condition_order['order_id'] = $nowOrder['order_id'];
                $data_order['postage'] = $postageCount;
                $data_order['total'] = $nowOrder['sub_total']+$postageCount;
                $data_order['fx_postage'] = $fx_postage;
                D('Order')->where($condition_order)->data($data_order)->save();
                json_return(0,$postageCount);
            } else {
                json_return(1001,'刷新订单');
            }
		}
		break;
	case 'list':
		if(IS_POST){
			$userAddress = M('User_address')->select(session_id(),$wap_user['uid']);
			foreach($userAddress as $value){
				$returnAddress[$value['address_id']] = $value;
			}
			json_return(0,$returnAddress);
		}
		break;
}
?>