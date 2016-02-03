<?php
/**
 * 评论附件model
 */
class Comment_attachmentModel extends Model{
	
	/**
	 * 根据条件获到评论附件列表
	 */
	public function getList($where) {
		$comment_attachment_list = $this->where($where)->select();
		
		$return_comment_attachment_list = array();
		foreach ($comment_attachment_list as $tmp) {
			$tmp['file'] = getAttachmentUrl($tmp['file']);
			
			$return_comment_attachment_list[$tmp['cid']][] = $tmp;
		}
		
		return $return_comment_attachment_list;
	}

	/**
	 * 根据条件获到评论列表
	 * 当limit与offset都为0时，表示不行限制
	 * 当is_attachment为真时，需要查寻评论的图片列表,以及评论会员基本信息
	 */
	public function getSimpleList($limit = 0, $offset = 0,$order_by = '') {
		if(empty($order_by)) $order_by = "ca.id desc";
		$where = "c.status=1 and c.has_image=1 and c.delete_flg=0 and c.type='PRODUCT'";
		$group = 'c.relation_id';
		$comment_list = D('Comment')->alias("c")->join('Comment_attachment as ca ON ca.cid=c.id','LEFT')
							-> where($where)->group($group)
							-> limit($offset . ',' . $limit)
							-> field("c.*,ca.file,ca.width,ca.height,c.relation_id")
							-> select();
		
		foreach($comment_list as $k=>$tmp) {
			$comment_list[$k]['file'] = getAttachmentUrl($tmp['file']);
			$comment_list[$k]['ilink'] = url_rewrite('goods:index', array('id' => $tmp['relation_id']))."#product_comment_image";
		}

		return $comment_list;
	}
	/**
	 * 更改评论,条件一般指的是ID
	 */
	public function save($data, $where) {
		$this->data($data)->where($where)->save();
	}
	
	/**
	 * 删除
	 */
	public function delete($where) {
		$this->where($where)->delete();
	}
}