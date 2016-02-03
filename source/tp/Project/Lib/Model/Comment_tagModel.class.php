<?php
/**
 * 评论TAGmodel
 */
class Comment_tagModel extends Model{
	/**
	 * 返回相应TAG数量
	 * 参数array('type', 'relation_id', 'status' => 1, 'delete_flg' => 0)
	 */
	public function getCountList($where) {
		$where['status'] = 1;
		$where['delete_flg'] = 0;
		$count_list = $this->field('count(tag_id) as count, tag_id')->where($where)->group('tag_id')->select();
		
		$data = array();
		foreach ($count_list as $count) {
			$data[$count['tag_id']] = $count['count'];
		}
		
		return $data;
	}
	
	
	/**
	 * 获取评论记录数
	 */
	public function getCount($where) {
		$coupon_count = $this->field('count(1) as count')->where($where)->find();
		return $coupon_count['count'];
	}
	
	/**
	 * 根据条件获到评论列表
	 * 当limit与offset都为0时，表示不行限制
	 */
	public function getList($where, $order_by = '', $limit = 0, $offset = 0) {

		$coupon_list = $this->where($where)->order($order_by)->limit($offset . ',' . $limit)->select();
		return $coupon_list;
	}
	

	
	/**
	 * 根据评论ID，返回相应tag
	 * 返回数据根据cid进行分组
	 */
	public function getListName($cid_arr) {
		if (empty($cid_arr)) {
			return array();
		}
		$cid_str = join(',', $cid_arr);
		
		$db_prefix = C('DB_PREFIX');
		
		$sql = "SELECT * FROM " . $db_prefix . "comment_tag AS ct, " . $db_prefix . "system_tag AS st WHERE st.id = ct.tag_id AND ct.cid in (" . $cid_str . ") AND ct.status = 1 AND ct.delete_flg = 0";
		$comment_tag_list = M()->query($sql); 

		$return_comment_tag_list = array();
		foreach ($comment_tag_list as $comment_tag) {
			$return_comment_tag_list[$comment_tag['cid']][] = $comment_tag;
		}
		
		return $return_comment_tag_list;
	}
	
	
	/**
	 * 更改评论,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->data($data)->where($where)->save();
	}
	
	/**
	 * 删除
	 * 逻辑删除
	 */
	public function delete($where) {
		$this->where($where)->data(array('delete_flg' => 1))->save();
	}
}