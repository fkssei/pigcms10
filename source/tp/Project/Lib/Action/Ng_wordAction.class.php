<?php
/*
 * 后台敏感词基础类
 * @  Writers cmx
 * @  BuildTime  2015/07/03 14:28
 */

class Ng_wordAction extends BaseAction{
	public function index(){
		$ng_word_model = M('Ng_word');
		$count = $ng_word_model->count('id');
		
		$ng_word_list = array();
		if ($count > 0) {
			import('@.ORG.system_page');
			$page = new Page($count, 30);
			$ng_word_list = $ng_word_model->limit($page->firstRow, $page->listRows)->select();
			
			$this->assign('page', $page->show());
		}
		$this->assign('ng_word_list', $ng_word_list);
		$this->display();
	}
	
	// 添加系统TAG
	public function add() {
		if (IS_POST) {
			$ng_word_model = M('Ng_word');
			$ng_word = $this->_post('ng_word', 'trim');
			$replace_word = $this->_post('replace_word', 'trim');
			error_log($ng_word);
			$ng_word_arr = explode("\n", $ng_word);
			$replace_word_arr = explode("\n", $replace_word);
			
			//
			$pass_number = 0;
			foreach ($ng_word_arr as $key => $tmp) {
				$tmp = trim($tmp);
				if ($ng_word_model->where(array('ng_word' => $tmp))->find()) {
					$pass_number++;
					continue;
				}
				
				$data['ng_word'] = $tmp;
				$data['replace_word'] = isset($replace_word_arr[$key]) ? $replace_word_arr[$key] : '*';
				$ng_word_model->add($data);
			}
			
			$this->frame_submit_tips(1, '添加成功!');
		}
		
		$this->display();
	}
	
	// 删除
	public function delete() {
		$id = $this->_get('id');
		if (empty($id)) {
			$this->frame_submit_tips(0, '缺少最基本的参数ID');
		}
		
		M('Ng_word')->where(array('id' => $id))->delete();
		$this->success('删除成功！');
	}
	
	// 修改
	public function edit() {
		$id = $this->_get('id');
		
		if (empty($id)) {
			$this->frame_submit_tips(0, '缺少最基本的参数ID');
		}
		
		$ng_word_model = M('Ng_word');
		$ng_word = $ng_word_model->where(array('id' => $id))->find();
		if (empty($ng_word_model)) {
			$this->frame_submit_tips(0, '未找到要修改的敏感词');
		}
		
		if (IS_POST) {
			$ng_word = $this->_post('ng_word', 'trim');
			$replace_word = $this->_post('replace_word', 'trim');
			
			$ng_word_new = $ng_word_model->where(array('ng_word' => $ng_word, 'id' => array('neq', $id)))->find();
			if (!empty($ng_word_new)) {
				$this->frame_submit_tips(0, $tmp . ',该敏感词已经存在！');
			}
			
			$data = array();
			$data['replace_word'] = $replace_word;
			$data['ng_word'] = $ng_word;
			$ng_word_model->data($data)->where(array('id' => $id))->save();
			
			$this->frame_submit_tips(1, '修改成功!');
		}
		
		$this->assign('ng_word', $ng_word);
		$this->display();
	}
}