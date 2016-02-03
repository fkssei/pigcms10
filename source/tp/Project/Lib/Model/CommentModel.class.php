<?php
/**
 * 评论model
 */
class CommentModel extends Model{
	/**
	 * 返回三种评论满意的总数量
	 * 返回数组，total => '总量', t1 => '不满意数', t2 => '一般数', t3 => '满意数'
	 */
	public function getCountList($where) {
		$where['status'] = 1;
		$where['delete_flg'] = 0;
		$count = $this->field('count(*) as total, sum(if(score <= 2, 1, 0)) as t1, sum(if(score = 3, 1, 0)) as t2, sum(if(score > 3, 1, 0)) as t3')->where($where)->find();
		return $count;
	}
	
	/**
	 * 获取评论记录数
	 */
	public function getCount($where) {
		$comment_count = $this->field('count(1) as count')->where($where)->find();
		
		return $comment_count['count'];
	}


	/**
	 * 根据条件获到评论列表
	 * 当limit与offset都为0时，表示不行限制
	 * 当is_attachment为真时，需要查寻评论的图片列表,以及评论会员基本信息
	 */
	public function getList($where, $order_by = '', $limit = 0 , $offset = 0, $is_attachment = false) {
		
		$comment_list = $this->where($where)->order($order_by)->limit($offset . ',' . $limit)->select();
		
		if ($is_attachment) {
			$return_comment_list = array();
			$comment_id_arr = array();
			$uid_arr = array();
			foreach ($comment_list as $comment) {
				$comment['attachment_list'] = array();
				$return_comment_list[$comment['id']] = $comment;
				$comment_id_arr[] = $comment['id'];
				$uid_arr[$comment['uid']] = $comment['uid'];
			}
			
			$comment_tag_list = array();
			if ($comment_id_arr) {
				$where = array();
				$where['cid'] = array('in', $comment_id_arr);
				$comment_attachment_list = D('Comment_attachment')->getList($where);
				
				foreach ($comment_attachment_list as $key => $comment_attachment) {
					$return_comment_list[$key]['attachment_list'] = $comment_attachment;
				}
				
				$comment_tag_list = D('Comment_tag')->getListName($comment_id_arr);
				
			}
			
			$user_list = array();
			if ($uid_arr) {
				$where = array();
				$where['uid'] = array('in', $uid_arr);
				$user_list = D('User')->getList($where);
			}
			
			return array('comment_list' => $return_comment_list, 'user_list' => $user_list, 'comment_tag_list' => $comment_tag_list);
		}
		
		
		return $comment_list;
	}
	
	
	/**
	 * 
	 */
	public function getSimiplyList($where, $limit = 5, $offset = 0) {

		$comment_list = $this->where($where)->order($order_by)->limit($offset . ',' . $limit)->select();
		
		
		$return_comment_list = array();
		$uid_arr = array();
		foreach ($comment_list as $comment) {
			$return_comment_list[$comment['id']] = $comment;
			$uid_arr[$comment['uid']] = $comment['uid'];
		}
			
			
		$user_list = array();
		if ($uid_arr) {
			$where = array();
			$where['uid'] = array('in', $uid_arr);
			$user_list = D('User')->getList($where);
		}
			
		return array('comment_list' => $return_comment_list, 'user_list' => $user_list);
	}
	
	/**
	 * 满意度
	 * 根据条件查询出相应的满意度
	 * 当会员评论值为4，5表示满意
	 */
	public function satisfaction($where) {
		$data = $this->field('count(1) as count, sum(if(score > 3, 1, 0)) as pass')->where($where)->find();
		
		if ($data['count'] == 0) {
			return '100%';
		}
		
		return round($data['pass'] / $data['count'] * 100) . '%';
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