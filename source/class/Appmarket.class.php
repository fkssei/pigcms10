<?php
/**
 * 应用营销数据处理
 */
class Appmarket {
	/**
	 * 一个订单里的产品返回所有享受的满减送列表
	 */
	static function getAeward($reward_arr, $product_arr) {
		//print_r($product_arr);exit;
		// 优惠活动与优惠券
		$reward_list = M('Reward')->getListByProductId($reward_arr['product_id_arr'], $reward_arr['store_id'], $reward_arr['uid']);
		//print_r($reward_list);exit;
		$return_reward_list = array();
		$product_price_list = array();
		$is_all = false;
		// 记录购买的产品享受的优惠活动
		foreach ($reward_list as $reward) {
			// 如果是全总产品参与
			if ($reward['is_all'] == 1) {
				foreach ($reward['condition_list'] as $condition) {
					if ($condition['money'] <= $product_arr['total_price']) {
						$data = array();
						$data['rid'] = $reward['id'];
						$data['name'] = $reward['name'];
						$data['condition_id'] = $condition['id'];
						$data['money'] = $condition['money'];
						$data['cash'] = $condition['cash'];
						$data['postage'] = $condition['postage'];
						$data['score'] = $condition['score'];
						
						if (!empty($condition['coupon'])) {
							$data['coupon'] = M('Coupon')->getValidCoupon($condition['coupon']);
						} else {
							$data['coupon'] = $condition['coupon'];
						}
						
						if (!empty($condition['present'])) {
							$data['present'] = M('Present')->getProductByPid($condition['present']);
						} else {
							$data['present'] = $condition['present'];
						}
						
						// 是否全部产品参与
						$data['is_all'] = 'ALL';
						
						$cash = $condition['cash'];
						foreach ($product_arr['product_price_arr'] as $product_id => $tmp_product_price) {
							for ($i = 1; $i <= $tmp_product_price['pro_num']; $i++) {
								if ($cash > 0) {
									$tmp_cash = $cash;
									$cash -= $tmp_product_price['price'];
									if ($cash < 0) {
										$tmp = array();
										$tmp['product_id'] = $product_id;
										$tmp['is_original_price'] = 0;
										$tmp['price'] = $tmp_product_price['price'] - $tmp_cash;
										$tmp['pro_num'] = 1;
										
										$product_price_list[] = $tmp;
									}
								} else {
									$tmp = array();
									$tmp['product_id'] = $product_id;
									$tmp['is_original_price'] = 1;
									$tmp['price'] = $tmp_product_price['price'];
									$tmp['pro_num'] = $tmp_product_price['pro_num'] - $i + 1;
									
									$product_price_list[] = $tmp;
									break;
								}
							}
						}
						
						$data['product_price_list'] = $product_price_list;
						
						$return_reward_list[] = $data;
						break;
					}
				}
				
				$is_all = true;
				break;
			} else {
				$total_price = 0;
				foreach ($reward['product_list'] as $product_id) {
					$total_price += $product_arr['product_price_arr'][$product_id]['price'] * $product_arr['product_price_arr'][$product_id]['pro_num'];
				}
				
				foreach ($reward['condition_list'] as $condition) {
					if ($condition['money'] <= $total_price) {
						$data = array();
						$data['rid'] = $reward['id'];
						$data['name'] = $reward['name'];
						$data['condition_id'] = $condition['id'];
						$data['money'] = $condition['money'];
						$data['cash'] = $condition['cash'];
						$data['postage'] = $condition['postage'];
						$data['score'] = $condition['score'];
						if (!empty($condition['coupon'])) {
							$data['coupon'] = M('Coupon')->getValidCoupon($condition['coupon']);
						} else {
							$data['coupon'] = $condition['coupon'];
						}
						if (!empty($condition['present'])) {
							$data['present'] = M('Present')->getProductByPid($condition['present']);
						} else {
							$data['present'] = $condition['present'];
						}
						
						// 是否全部产品参与
						$data['is_all'] = $reward['product_list'];
						$cash = $condition['cash'];
						// 使用满减送减现金后的产品信息
						foreach ($reward['product_list'] as $prudoct_id) {
							$tmp_product_price = $product_arr['product_price_arr'][$product_id];
							
							for ($i = 1; $i <= $tmp_product_price['pro_num']; $i++) {
								if ($cash > 0) {
									$tmp_cash = $cash;
									$cash -= $tmp_product_price['price'];
									if ($cash < 0) {
										$tmp = array();
										$tmp['product_id'] = $product_id;
										$tmp['is_original_price'] = 0;
										$tmp['price'] = $tmp_product_price['price'] - $tmp_cash;
										$tmp['pro_num'] = 1;
							
										$product_price_list[] = $tmp;
									}
								} else {
									$tmp = array();
									$tmp['product_id'] = $product_id;
									$tmp['is_original_price'] = 1;
									$tmp['price'] = $tmp_product_price['price'];
									$tmp['pro_num'] = $tmp_product_price['pro_num'] - $i + 1;
										
									$product_price_list[] = $tmp;
									break;
								}
							}
							
							unset($product_arr['product_price_arr'][$product_id]);
						}
						
						$return_reward_list[] = $data;
						break;
					}
				}
			}
		}
		
		/**
		 * 进行满减送处理后，对剩下的产品价格进行再次分配
		 */
		if ($is_all) {
			if (empty($product_price_list)) {
				foreach ($product_arr['product_price_arr'] as $product_id => $tmp_product_price) {
					$tmp = array();
					$tmp['product_id'] = $product_id;
					$tmp['is_original_price'] = 1;
					$tmp['price'] = $tmp_product_price['price'];
					$tmp['pro_num'] = $tmp_product_price['pro_num'];
				
					$product_price_list[] = $tmp;
				}
			}
		} else {
			if (isset($product_arr['product_price_arr']) && count($product_arr['product_price_arr']) > 0) {
				foreach ($product_arr['product_price_arr'] as $product_id => $tmp_product_price) {
					$tmp = array();
					$tmp['product_id'] = $product_id;
					$tmp['is_original_price'] = 1;
					$tmp['price'] = $tmp_product_price['price'];
					$tmp['pro_num'] = $tmp_product_price['pro_num'];
					
					$product_price_list[] = $tmp;
				}
			}
		}
		
		$return_reward_list['product_price_list'] = $product_price_list;
		return $return_reward_list;
	}

	/**
	 * 一个订单里经过满减送处理后，可以用的优惠券列表
	 */
	static function getCoupon($reward_list, $user_coupon_list = 0) {
		$product_list = $reward_list['product_price_list'];
		//print_r($product_list);exit;
		$return_user_coupon_list = array();
		foreach ($user_coupon_list as $user_coupon) {
			// is_original_price 0:非原价购买可以使用，1：原价购买可以使用
			// is_all_product 0:全店通用，1：指定商品
			$price = 0;
			
			// 全店通用
			if ($user_coupon['is_all_product'] == 0) {
				foreach ($product_list as $product) {
					if ($user_coupon['is_original_price'] == 1) {
						if ($product['is_original_price'] == 1) {
							$price += $product['price'] * $product['pro_num'];
						}
					} else {
						$price += $product['price'] * $product['pro_num'];
					}
				}
			} else {
				foreach ($user_coupon['product_list'] as $product_id) {
					foreach ($product_list as $product) {
						if ($product['product_id'] != $product_id) {
							continue;
						}
						
						if ($user_coupon['is_original_price'] == 1) {
							if ($product['is_original_price'] == 1) {
								$price += $product['price'] * $product['pro_num'];
							}
						} else {
							$price += $product['price'] * $product['pro_num'];
						}
					}
				}
			}
			
			if ($price >= $user_coupon['limit_money']) {
				$return_user_coupon_list[] = $user_coupon;
			}
		}
		
		return $return_user_coupon_list;
	}


}