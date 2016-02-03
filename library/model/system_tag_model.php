<?php
/**
 * 系统TAGmodel
 */
class system_tag_model extends base_model{
	/**
	 * 返回相应TAG name列表
	 */
	public function geNameList($where) {
		$where['status'] = 1;
		$system_list = $this->db->where($where)->select();
		
		$data = array();
		foreach ($system_list as $tmp) {
			$data[$tmp['id']] = $tmp['name'];
		}
		
		return $data;
	}
	
	
	/**
	 * 更改评论,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->db->data($data)->where($where)->save();
	}
	
	/**
	 * 添加
	 */
	public function add ($data) {
		$this->db->data($data)->add();
	}
}