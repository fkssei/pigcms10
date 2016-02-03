<?php
/*
 * 后台TAG基础类
 * @  Writers cmx
 * @  BuildTime  2015/07/03 14:28
 */

class TagAction extends BaseAction{
	public function index(){
		$system_tag_model = M('System_tag');
		$count = $system_tag_model->count('id');
		
		$tag_list = array();
		if ($count > 0) {
			import('@.ORG.system_page');
			$page = new Page($count, 30);
			$tag_list = $system_tag_model->alias('t')->join(C('DB_PREFIX') . "system_property_type as pt on pt.type_id=t.tid")->field("t.*,pt.type_name")->order('t.id ASC')->limit($page->firstRow, $page->listRows)->select();
			$this->assign('page', $page->show());
		}
		
		$this->assign('tag_list', $tag_list);
		$this->display();
	}
	
	// 添加系统TAG
	public function add() {
		if (IS_POST) {
			$system_tag_model = M('System_tag');
			$property_type_id = $this->_post('property_type_id', 'trim,intval') + 0;
			$tag = $this->_post('tag', 'trim');
			$status = $this->_post('status');
			
			$tag_arr = explode("\n", $tag);
			
			$data['tid'] = $property_type_id;
			$data['status'] = $status;
			//查询同意分类下 不允许相同的属性
			foreach ($tag_arr as $tmp) {
				$tmp = trim($tmp);
				if ($system_tag_model->where(array('name' => $tmp, 'pid' => $property_type_id))->find()) {
					$this->frame_submit_tips(0, $tmp . ',该TAG已经存在！');
				}
			
				$data['name'] = $tmp;
				$system_tag_model->add($data);
			}
			
			$this->frame_submit_tips(1, '添加成功!');
		}
		
		$system_property_type_list = M('System_property_type')->where(array('type_status' => 1))->select();
		
		$this->assign('system_property_type_list', $system_property_type_list);
		$this->display();
	}
	
	// 删除
	public function delete() {
		$this->frame_submit_tips(0, '禁止删除');
		$id = $this->_get('id');
		if (empty($id)) {
			$this->frame_submit_tips(0, '缺少最基本的参数ID');
		}
	}
	
	// 修改
	public function edit() {
		$id = $this->_get('id');
		
		if (empty($id)) {
			$this->frame_submit_tips(0, '缺少最基本的参数ID');
		}
		
		$system_tag_model = M('System_tag');
		$system_tag = $system_tag_model->where(array('id' => $id))->find();
		if (empty($system_tag)) {
			$this->frame_submit_tips(0, '未找到要修改的TAG');
		}
		
		if (IS_POST) {
			$property_type_id = $this->_post('property_type_id', 'trim,intval') + 0;
			$tag = $this->_post('tag', 'trim');
			$status = $this->_post('status');
			
			$data = array();
			$data['tid'] = $property_type_id;
			$data['tag'] = $tag;
			$data['status'] = $status;
			
			$system_tag_new = $system_tag_model->where(array('name' => $tag))->find();
			if (!empty($system_tag_new) && $system_tag['id'] != $system_tag['id']) {
				$this->frame_submit_tips(0, $tmp . ',该TAG已经存在！');
			}
			
			$system_tag_model->data($data)->where(array('id' => $id))->save();
			
			$this->frame_submit_tips(1, '修改成功!');
		}
		
		$system_property_type_list = M('System_property_type')->where(array('type_status' => 1))->select();
		$this->assign('system_property_type_list', $system_property_type_list);
		$this->assign('system_tag', $system_tag);
		
		$this->display();
	}
	
	// 更改状态
	public function status() {
		$id = $this->_post('id');
		$status = $this->_post('status');
		
		if (empty($id)) {
			$this->frame_submit_tips(0, '缺少最基本的参数ID');
		}
		
		$system_tag_model = M('System_tag');
		$system_tag = $system_tag_model->where(array('id' => $id))->find();
		if (empty($system_tag)) {
			$this->frame_submit_tips(0, '未找到要修改的TAG');
		}
		
		$data = array();
		$data['status'] = $status;
			
		$system_tag_model->data($data)->where(array('id' => $id))->save();
	}
}