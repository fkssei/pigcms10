<?php
class case_controller extends base_controller{
	public function __construct(){
		parent::__construct();
		if(empty($this->store_session)) redirect(url('index:index'));
	}
	public function case_load(){
		if(empty($_POST['page'])) pigcms_tips('非法访问！','none');
		if($_POST['page'] == 'attachment_content'){
			$get_result = M('Attachment')->getListByStoreId($this->store_session['store_id']);
			$this->assign('get_result',$get_result);
		} else if ($_POST['page'] == 'ad_content') {
            $this->_ad_content();
        } else if ($_POST['page'] == 'ad_edit_content') {
            $this->_ad_edit_content();
        } else if ($_POST['page'] == 'page_content') {
            $this->_page_content();
        } else if ($_POST['page'] == 'create_page_content') {
            $this->_create_page_content();
        } else if ($_POST['page'] == 'edit_page_content') {
            $this->_edit_page_content();
        }
		$this->display($_POST['page']);
	}
    //文件
	public function attachment(){
		$this->display();
	}
	public function attchment_amend_name(){
		$condition_attachment['pigcms_id'] = $_POST['pigcms_id'];
		$condition_attachment['store_id']  = $this->store_session['store_id'];
		$data_attachment['name'] = $_POST['name'];
		if(D('Attachment')->where($condition_attachment)->data($data_attachment)->save()){
			json_return(0,'保存成功');
		}else{
			json_return(1001,'保存文件名失败');
		}
	}
	public function attchment_delete(){
		$condition_attachment['pigcms_id'] = $_POST['pigcms_id'];
		$condition_attachment['store_id']  = $this->store_session['store_id'];
		$data_attachment['status'] = 0;
		if(D('Attachment')->where($condition_attachment)->data($data_attachment)->save()){
			json_return(0,'删除成功');
		}else{
			json_return(1002,'删除失败');
		}
	}
	public function attchment_delete_more(){
		if(empty($_POST['pigcms_id'])) json_return(1003,'请选中一些值');
		
		$condition_attachment['pigcms_id'] = array('in',$_POST['pigcms_id']);
		$condition_attachment['store_id']  = $this->store_session['store_id'];
		$data_attachment['status'] = 0;
		if(D('Attachment')->where($condition_attachment)->data($data_attachment)->save()){
			json_return(0,'批量删除成功');
		}else{
			json_return(1004,'批量删除失败');
		}
	}

    //开启/关闭店铺广告
    public function open_ad()
    {
        $store = M('Store');

        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = $store->openAd($this->store_session['store_id'], $status);
        if ($result) {
            echo true;
        } else {
            echo false;
        }
        exit;
    }

    //广告
    public function ad()
    {
        $store = M('Store');
        $store = $store->getStoreById($this->store_session['store_id'], $this->user_session['uid']);

        $this->assign('action', $store['has_ad']);
        $this->display();
    }

    //广告添加页面
    private function _ad_content()
    {
        $store = M('Store');
        $store = $store->getStoreById($this->store_session['store_id'], $this->user_session['uid']);
        $this->assign('store', $store);
    }

    //广告修改页面
    private function _ad_edit_content()
    {
        $store = M('Store');
        $store = $store->getStoreById($this->store_session['store_id'], $this->user_session['uid']);

        $customField = M('Custom_field')->get_field($this->store_session['store_id'], 'common_ad', $this->store_session['store_id']);

        $this->assign('customField',json_encode($customField));
        $this->assign('store', $store);
    }

    //保存广告
    public function save_ad()
    {
        $store = M('Store');
        $custom_field = M('Custom_field');

        $store_id = $this->store_session['store_id'];
        $action = isset($_POST['action']) ? intval(trim($_POST['action'])) : 0;
        $position = isset($_POST['position']) ? $_POST['position'] : 0;
        $pages = isset($_POST['pages']) ? $_POST['pages'] : '';
        $fields = isset($_POST['custom']) ? $_POST['custom'] : array();
        if (!empty($fields)) {
            $has_ad = 1;
        } else {
            $has_ad = 0;
        }

        $page_arr = explode(',', $pages);
        $tmp_page_arr = array();
        foreach ($page_arr as $tmp) {
        	if (!empty($tmp) || $tmp === '0') {
        		$tmp_page_arr[] = $tmp;
        	}
        }

        $pages = join(',', $tmp_page_arr);

        if ($store->setAd($store_id, array('has_ad' => $has_ad, 'ad_position' => $position, 'use_ad_pages' => $pages, 'date_edited' => time()))) {
            if (!empty($fields)) {
                if (empty($action)) { //添加
                    $result = $custom_field->delete_field($this->store_session['store_id'], 'common_ad', $this->store_session['store_id']);
                    $custom_field->add_field($this->store_session['store_id'], $fields, 'common_ad', $this->store_session['store_id']);
                } else { //编辑
                    $result = $custom_field->delete_field($this->store_session['store_id'], 'common_ad', $this->store_session['store_id']);
                    if ($result) {
                        $custom_field->add_field($this->store_session['store_id'], $fields, 'common_ad', $this->store_session['store_id']);
                    }
                }
            } else {
            	$result = $custom_field->delete_field($this->store_session['store_id'], 'common_ad', $this->store_session['store_id']);
            }
        }
        json_return(0, '保存成功');
    }

    //自定义页面
    public function page()
    {
        $this->display();
    }

    //自定义页面内容
    private function _page_content()
    {
        $page = M('Custom_page');
        $pages = $page->getPages($this->store_session['store_id'], 15);

        $this->assign('custom_pages', $pages['pages']);
        $this->assign('page', $pages['page']);
    }

    //创建页面
    public function create_page()
    {
        //保存页面
        if (IS_POST) {
            $custom_field = M('Custom_field');
            $custom_page = M('Custom_page');

            $store_id = $this->store_session['store_id'];
            $page_id = isset($_POST['page_id']) ? $_POST['page_id'] : 0;
            $name = isset($_POST['name']) ? mysql_real_escape_string($_POST['name']) : '';
            $fields = isset($_POST['custom']) ? $_POST['custom'] : '';
            if (empty($page_id)) {
                if ($page_id = $custom_page->add(array('store_id' => $store_id, 'name' => $name,'add_time'=>$_SERVER['REQUEST_TIME']))) {
                    $custom_field->add_field($store_id, $fields, 'custom_page', $page_id);
                    json_return(0, '添加成功');
                } else {
                    json_return(1001, '添加失败');
                }
            } else {
                if ($custom_page->save(array('page_id' => $page_id, 'store_id' => $store_id), array('name' => $name,'add_time'=>$_SERVER['REQUEST_TIME']))) {
                    $custom_field->delete_field($store_id, 'custom_page', $page_id);
                    $custom_field->add_field($store_id, $fields, 'custom_page', $page_id);
                    json_return(0, '修改成功');
                } else {
                    json_return(1001, '修改失败');
                }
            }
        }
        $this->display();
    }

    //创建页面内容
    private function _create_page_content()
    {

    }

    //修改页面内容
    private function _edit_page_content()
    {
        $custom_page = M('Custom_page');

        $page_id = isset($_POST['page_id']) ? $_POST['page_id'] : 0;
        $customField = M('Custom_field')->get_field($this->store_session['store_id'], 'custom_page', $page_id);

        $custom_page = $custom_page->get($this->store_session['store_id'], $page_id);

        $this->assign('page_id', $page_id);
        $this->assign('customField', json_encode($customField));
        $this->assign('page_name', $custom_page['name']);
    }

    //删除页面
    public function delete_page()
    {
        $custom_page = M('Custom_page');
        $custom_field = M('Custom_field');

        $store_id = $this->store_session['store_id'];
        $page_id = isset($_POST['page_id']) ? $_POST['page_id'] : 0;

        if ($custom_page->delete($store_id, $page_id)) {
            $custom_field->delete_field($store_id, 'custom_page', $page_id);
            json_return(0, '删除成功');
        } else {
            json_return(1001, '删除失败');
        }
    }

    //重命名页面标题
    public function rename_page()
    {
        $custom_page = M('Custom_page');

        $store_id = $this->store_session['store_id'];
        $page_id = isset($_POST['page_id']) ? intval(trim($_POST['page_id'])) : 0;
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';

        if ($custom_page->rename($store_id, $page_id, $name)) {
            json_return(0, '修改成功');
        } else {
            json_return(1001, '修改失败');
        }
    }
}
?>