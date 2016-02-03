<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class adver_model extends base_model
{
	public function get_adver_by_key($cat_key, $limit = 3)
	{
		$database_adver_category = D('Adver_category');
		$condition_adver_category['cat_key'] = $cat_key;
		$now_adver_category = $database_adver_category->field('`cat_id`')->where($condition_adver_category)->find();
		$adver_list = array();

		if ($now_adver_category) {
			$condition_adver['cat_id'] = $now_adver_category['cat_id'];
			$condition_adver['status'] = '1';
			$adver_list = D('Adver')->where($condition_adver)->order('`id` DESC')->limit($limit)->select();

			foreach ($adver_list as $key => $value) {
				$adver_list[$key]['pic'] = getAttachmentUrl($value['pic']);
			}

			return $adver_list;
		}
		else {
			return $adver_list;
		}
	}
}

?>
