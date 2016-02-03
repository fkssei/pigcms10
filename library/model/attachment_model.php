<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class attachment_model extends base_model
{
	public function getListByStoreId($store_id)
	{
		$condition = array('store_id' => $store_id, 'status' => 1);

		switch ($_POST['type']) {
		case 'list_image':
			$condition['type'] = 0;
			break;

		case 'list_upload_image':
			$condition['type'] = 0;
			$condition['from'] = 0;
			break;

		case 'list_import_image':
			$condition['type'] = 0;
			$condition['from'] = 1;
			break;

		case 'list_collect_image':
			$condition['type'] = 0;
			$condition['from'] = 2;
			break;

		case 'list_voice':
			$condition['type'] = 1;
			break;

		case 'list_upload_voice':
			$condition['type'] = 1;
			$condition['from'] = 0;
			break;

		case 'list_collect_voice':
			$condition['type'] = 1;
			$condition['from'] = 1;
			break;
		}

		if ($_POST['txt']) {
			$condition['name'] = array('like', '%' . $_POST['txt'] . '%');
		}

		$attachment_count = $this->db->where($condition)->count('pigcms_id');
		import('source.class.user_page');
		$p = new Page($attachment_count, 10);
		$attachment_list = $this->db->where($condition)->order('`pigcms_id` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();

		foreach ($attachment_list as &$value) {
			$value['file'] = getAttachmentUrl($value['file']);
		}

		$return['attachment_list'] = $attachment_list;
		$return['page'] = $p->show();
		return $return;
	}

	public function get_tpl($tpl_id, $store_id)
	{
		$condition_postage_template['tpl_id'] = $tpl_id;
		$condition_postage_template['store_id'] = $store_id;
		$tpl = $this->db->field('`tpl_id`,`tpl_name`,`tpl_area`,`last_time`,`copy_id`')->where($condition_postage_template)->find();
		$area_arr = explode(';', $tpl['tpl_area']);

		foreach ($area_arr as $v) {
			if (!empty($v)) {
				$area_content_arr = explode(',', $v);
				$tpl['area_list'][] = $area_content_arr;
			}
		}

		return $tpl;
	}
}

?>
