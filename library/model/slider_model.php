<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class slider_model extends base_model
{
	public function get_slider_by_key($cat_key, $limit = 6)
	{
		if (empty($cat_key)) {
			return false;
		}

		$adver_list = $this->db->table('Slider as s')->join('Slider_category sc On s.cat_id = sc.cat_id')->where('sc.cat_key=\'' . $cat_key . '\' and s.status=\'1\'')->limit($limit)->select();
		$adverlist = array();

		foreach ($adver_list as $key => $value) {
			$adver_list[$key]['pic'] = getAttachmentUrl($value['pic']);
		}

		return $adver_list;
	}
}

?>
