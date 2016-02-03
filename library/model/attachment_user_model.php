<?php
/**
 * 用户图片附件表
 */
class attachment_user_model extends base_model{
	// 添加
	public function add($data) {
		if (!isset($data['add_time'])) {
			$data['add_time'] = $_SERVER['REQUEST_TIME'];
		}
		if (!isset($data['ip'])) {
			$data['ip'] = get_client_ip(1);
		}
		if (!isset($data['agent'])) {
			$data['agent'] = $_SERVER['HTTP_USER_AGENT'];
		}
		
		return $this->db->data($data)->add();
	}
	
	// 查打用户图片
	public function getList($where, $order = '', $limit = 0, $offset = 0) {
		$this->db->where($where);
		if (!empty($order)) {
			$this->db->order($order);
		}
		
		if (!empty($limit)) {
			$this->db->limit($offset . ', ' . $limit);
		}
		
		return $this->db->select();
	}
}
?>