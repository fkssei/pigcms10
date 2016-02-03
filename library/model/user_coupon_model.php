<?php
/**
 * 用户优惠券模型
 * User: pigcms-s
 * Date: 2015/06/25
 * Time: 11:10
 */
	class user_coupon_model extends base_model {

		/**
		* 用户领取优惠券
		* param $uid       Int
		* param 优惠券的信息 Array
		*/
		public function add($uid, $couponinfo) {

			$data = array(
				'uid' => $uid,         //领取者的uid
				'coupon_id' => $couponinfo['id'],
				'store_id' => $couponinfo['store_id'],   //发放的商铺id
				'cname' => $couponinfo['name'],   //优惠券名称
				'face_money' => $couponinfo['face_money'],   //优惠券面值
				'start_time' => $couponinfo['start_time'],
				'end_time' => $couponinfo['end_time'],
				'limit_money' => $couponinfo['limit_money'],
				'is_expire_notice' => $couponinfo['is_expire_notice'],
				'is_share' => $couponinfo['is_share'],
				'is_all_product' => $couponinfo['is_all_product'],
				'is_original_price' => $couponinfo['is_original_price'],
				'description' => $couponinfo['description'],
				'timestamp' => time(),
				'type' => $couponinfo['type'],
				'is_valid' => 1,
				'card_no' => String::keyGen()
			);

			if ($result = $this->db->data($data)->add()) {
				return true;
			} else {
				return false;
			}
		}
		/**
		 * 获取某个优惠券
		 */
		public function getUserCoupon($where) {
			$user_coupon = $this->db->where($where)->find();
			return $user_coupon;
		}
	
		//获取单条券信息
		function getOneCouponInfo($where) {
			$coupon = $this->db->where($where)->find();
			return $coupon;
		}

		//已经有多少不同人领取优惠券/赠送券
		function getPeopleCountByCoupon($coupon_id) {
			if(is_array($coupon_id)) {
				$where = implode(',',$coupon_id);
			} else {
				$where = $coupon_id;
			}
			$db_prefix = option('system.DB_PREFIX');
			$sql = "SELECT count(DISTINCT uid) as counts,coupon_id  FROM  `" . $db_prefix . "user_coupon` WHERE `coupon_id` IN (" . $where . ") GROUP BY `coupon_id`  ";
			$coupon_count = $this->db->query($sql);
			$return_arr = array();
			foreach($coupon_count as $k => $v) {
					$return_arr[$v['coupon_id']] = $v;
			}
			//echo $this->db->last_sql;
			return $return_arr;

		}


		//根据优惠券 id 更新 优惠券s使用量
		function updateCouponInfo($coupon_id) {

			$where = array(
				'coupon_id' => $coupon_id,
				'is_use' => 1
			);

		 	$count = $this->getCount($where);
			unset($where);

			$data = array(
				'used_number' => $count
			);
			D('Coupon')->where(array('id'=>$coupon_id))->save($data);

		}

		
			
	/**
	 * 根据产品ID获得优惠活动
	 * $product_id_arr 产品ID数组
	 * $store_id 店铺ID
	 * $uid 店铺UID
	 */
	public function getListByProductId($product_id_arr, $store_id, $uid) {
		$tmp_product_id_arr = array();
		foreach ($product_id_arr as $tmp) {
			$tmp_product_id_arr[] = $tmp['product_id'];
		}
		
		
		$time = time();
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT distinct u.* FROM `" . $db_prefix . "user_coupon` AS u LEFT JOIN `" . $db_prefix . "coupon_to_product` AS cp ON `u`.`coupon_id` = `cp`.`coupon_id` WHERE `u`.`store_id` = '" . $store_id . "' AND (`u`.`is_all_product` = 0 or `cp`.`product_id` in (" . join(',', $tmp_product_id_arr) . ")) AND `u`.`uid` = '" . $uid . "' AND `u`.`start_time` <= '" . $time . "' AND `u`.`end_time` >= '" . $time . "' AND `u`.`is_use` = '0' AND `u`.is_valid = '1' AND `u`.`delete_flg` = '0'";
		$user_coupon_list = $this->db->query($sql);
		
		
		foreach ($user_coupon_list as &$user_coupon) {
			$where = array();
			$where['coupon_id'] = $user_coupon['coupon_id'];
			
			// 优惠参加产品
			if ($user_coupon['is_all_product'] == 1) {
				$product_list = M('Coupon_to_product')->getList($where);
				$product_id_arr = array();
				foreach ($product_list as $tmp) {
					$product_id_arr[$tmp['product_id']] = $tmp['product_id'];
				}
				
				$user_coupon['product_list'] = $product_id_arr;
			} else {
				$user_coupon['product_list'] = array();
			}
		}
		return $user_coupon_list;
	}
	
	
		/**
		* 根据条件获到优惠券列表
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
			//echo $this->db->last_sql;
			return $coupon_list;
		}



		/**
		 * 根据条件获到优惠券对应的用户列表
		 * 当limit与offset都为0时，表示不行限制
		 */
		public function getuserList($where, $order_by = '', $limit = 0, $offset = 0) {

			$arr = $this->db->table("User_coupon as uc")->join('User u  ON  u.uid=uc.uid','LEFT')
						->where($where)
						->limit($offset . ',' . $limit)
						->order($order_by)
						->field("uc.*,u.nickname,u.last_time,u.avatar,u.phone")
						->select();

	//		echo $this->db->last_sql;

			return $arr;

		}
		
		/**
		 * 使优惠券无效
		 * 以后要更改优惠券无效的其它逻辑，可以在此扩充
		 */
		public function invaild($where) {
			$this->db->where($where)->data(array('is_valid' => '0', 'delete_flg' => 1))->save();
		}
	
		/**
		* 获取满足条件的优惠券记录数
		*/
		public function getCount($where) {
			$coupon_count = $this->db->field('count(1) as count')->where($where)->find();
			return $coupon_count['count'];
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