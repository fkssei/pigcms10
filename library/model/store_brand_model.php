<?php
/**
 * 商品数据模型
 * User: pigcms_21
 * Date: 2015/2/9
 * Time: 13:15
 */
	class store_brand_model extends base_model
	{
		public function add($data)
		{
			if (!empty($data['pic'])) {
				$data['pic'] = getAttachment($data['pic']);
			}
			$product_id = $this->db->data($data)->add();
			return $product_id;
		}

		public function edit($where, $data)
		{
			if (!empty($data['pic'])) {
				$data['pic'] = getAttachment($data['pic']);
			}
			return $this->db->where($where)->data($data)->save();
		}



		//启用状态中的品牌总数
		public function getTotal($where)
		{
			$where['status'] = 1;
			return $this->db->where($where)->order('brand_id DESC')->count('brand_id');
		}

		//
		public function getList($where = array(),$order_by="", $limit="10"){
			if(!is_array($where)) return false;

			$where1 = array(
				'status' => 1,
			);
			if(empty($order_by)) $order_by = "order_by asc,type_id asc";

			$where = array_merge($where,$where1);

			$return = $this->db->where($where)->limit($limit)->select();

			if(!empty($return)) {
				foreach($return as &$value) {
					$value['link']  =  url_rewrite('store:index', array('id' => $value['store_id']));
					if(empty($value['pic'])) {
						$store['pic'] = getAttachmentUrl('images/default_shop_2.jpg', false);
					} else {
						$value['pic'] = getAttachmentUrl($value['pic']);
					}
				}
			}

			return $return;
		}


		/**
		 * @param $where
		 * @param $orderbyfield 排序字段
		 * @param $orderbymethod 排序方式 ASC DESC
		 * @param $offset
		 * @param $limit
		 * @return array
		 */
		public function getbrandList($where, $order_by_field, $order_by_method, $offset, $limit) {

			if (!empty($order_by_field) && !empty($order_by_method)) {
				$order = $order_by_field . ' ' . strtoupper($order_by_method);
			} else { //默认排序
				$order = 'order_by asc, brand_id asc';
			}

			$brand = $this->db->where($where)->where($where)->limit($limit)->select();

			if(!empty($brand)) {
				foreach ($brand as &$tmp) {
					$tmp['pic'] = getAttachmentUrl($tmp['pic']);
					$tmp['link'] = url_rewrite('store:index', array('id' => $tmp['store_id']));
				}
			}
			return $brand;
		}

		/**
		 * @desc 获取单个品牌信息
		 * @param $where
		 * @param string $fields
		 */
		public function get($where, $fields = '*')
		{
			$brand = $this->db->field($fields)->where($where)->find();
			$brand['pic'] = getAttachmentUrl($brand['pic']);
			return $brand;
		}




	}
