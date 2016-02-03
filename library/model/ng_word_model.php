<?php
/**
 * 敏感词model
 */
class ng_word_model extends base_model{
	/**
	 * 敏感词处理
	 */
	public function filterNgWord($content) {
		if (empty($content)) {
			return $content;
		}
		
		$ng_word_list = $this->db->select();
		$data = array();
		foreach ($ng_word_list as $tmp) {
			$data['ng_word'][] = $tmp['ng_word'];
			$data['replace_word'][] = $tmp['replace_word'];
		}
		
		if (empty($data)) {
			return $content;
		}
		
		return str_replace($data['ng_word'], $data['replace_word'], $content);
	}
}