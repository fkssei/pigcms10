<?php
class setting_controller extends base_controller{
    public function load(){
        $action = strtolower(trim($_POST['page']));
        if (empty($action)) pigcms_tips('非法访问！', 'none');
        switch ($action) {
            case 'store_content': //店铺信息
                $this->_store_content();
                break;
			case 'contact_content': //联系我们
                $this->_contact_content();
                break;
			case 'list_content': //门店管理
                $this->_list_content();
                break;
			case 'physical_edit_content': //门店管理
                $this->_physical_edit_content();
                break;
			case 'friend_content':
				$this->_friend_content();
				break;
            default:
                break;
        }
        $this->display($_POST['page']);
    }
	 //店铺名称唯一性检测
    public function store_name_check()
    {
        $store = M('Store');

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $unique = $store->getUniqueName($name);
        echo $unique;
        exit;
    }
    //设置店铺
    public function store(){
        if (IS_POST) {
            $store = M('Store');

            $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
			if(isset($_POST['logo'])){
				$logo = getAttachment($_POST['logo']);//str_replace(array(option('config.site_url').'/upload/images/','./upload/images/'),'',trim($_POST['logo']));
			}else{
				$logo = '';
			}
            $intro   = isset($_POST['intro']) ? trim($_POST['intro']) : '';
            $linkman = isset($_POST['linkman']) ? trim($_POST['linkman']) : '';
            $qq      = isset($_POST['qq']) ? trim($_POST['qq']) : '';
			$mobile  = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
            $open_service  = isset($_POST['open_service']) ? intval(trim($_POST['open_service'])) : 0;

            $data = array();
            if($name) $data['name'] = $name;
            if($logo) $data['logo'] = $logo;
            $data['intro'] = $intro;
            $data['linkman'] = $linkman;
            $data['qq'] = $qq;
			$data['tel'] = $mobile;
            $data['open_service'] = $open_service;
            if ($_SESSION['store']['name'] != $name) {
                $data['edit_name_count'] = $_SESSION['store']['edit_name_count'] + 1; //店铺名称修改次数
            }

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            if ($store->setting($where, $data)) {
                $_SESSION['store']['name'] = $name;
                $_SESSION['store']['logo'] = $_POST['logo'];
                $_SESSION['store']['edit_name_count'] += 1;
            }
            json_return(0, url('store:index'));
        }

        $id = $_GET['id'] + 0;
        if (!empty($id)) {
        	$store = M('Store')->getStoreById($id, $_SESSION['user']['uid']);
        	if (empty($store)) {
        		pigcms_tips('未找到相应的店铺', 'none');
        	}

        	$_SESSION['store'] = $store;
        }

        $this->display();
    }
	//联系我们
	public function contact(){
		if(IS_POST){
			$data_store_contact['phone1'] = $_POST['phone1'];
			$data_store_contact['phone2'] = $_POST['phone2'];
			$data_store_contact['province'] = $_POST['province'];
			$data_store_contact['city'] = $_POST['city'];
			$data_store_contact['county'] = $_POST['county'];
			$data_store_contact['address'] = $_POST['address'];
			$data_store_contact['long'] = $_POST['map_long'];
			$data_store_contact['lat'] = $_POST['map_lat'];
			$data_store_contact['last_time'] = $_SERVER['REQUEST_TIME'];
				
			$database_store_contact = D('Store_contact');
			$condition_store_contact['store_id'] = $this->store_session['store_id'];
			if($database_store_contact->where($condition_store_contact)->find()){
				if($database_store_contact->where($condition_store_contact)->data($data_store_contact)->save()){
					json_return(0,'保存成功');
				}else{
					json_return(1,'保存失败');
				}
			}else{
				$data_store_contact['store_id'] = $this->store_session['store_id'];
				if($database_store_contact->data($data_store_contact)->add()){
					json_return(0,'保存成功');
				}else{
					json_return(1,'保存失败');
				}
			}
		}else{
			json_return(1,'非法访问！');
		}
	}
	//店铺详细
    private function _store_content(){
        $company = M('Company');
        $database_store = M('Store');

        $company = $company->getCompanyByUid($this->user_session['uid']);

        //店铺主营类目
        $sale_category = $database_store->getSaleCategory($this->store_session['store_id'], $this->user_session['uid']);
        $store = $database_store->getStoreById($this->store_session['store_id'], $this->user_session['uid']);
        $this->assign('company', $company);
        $this->assign('store', $store);
        $this->assign('sale_category', $sale_category);
    }
	//联系我们
    private function _contact_content(){
		$store_contact = D('Store_contact')->where(array('store_id'=>$this->store_session['store_id']))->find();
		$this->assign('store_contact',$store_contact);
    }
	//门店管理
	private function _list_content(){
		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id']))->select();
		$this->assign('store_physical',$store_physical);
	}
	//门店编辑
	private function _physical_edit_content(){
		$store_physical = D('Store_physical')->where(array('store_id'=>$this->store_session['store_id'],'pigcms_id'=>$_POST['pigcms_id']))->find();
		if(empty($store_physical)){
			exit('该门店不存在！');
		}
		
		$store_physical['images_arr'] = explode(',',$store_physical['images']);
		foreach($store_physical['images_arr'] as &$physical_value){
			$physical_value = getAttachmentUrl($physical_value);
		}
		$this->assign('store_physical',$store_physical);
	}
	//门店添加
	public function physical_add(){
		if(IS_POST){
			$data_store_physical['store_id'] = $this->store_session['store_id'];
			$data_store_physical['name'] = $_POST['name'];
			$data_store_physical['phone1'] = $_POST['phone1'];
			$data_store_physical['phone2'] = $_POST['phone2'];
			$data_store_physical['province'] = $_POST['province'];
			$data_store_physical['city'] = $_POST['city'];
			$data_store_physical['county'] = $_POST['county'];
			$data_store_physical['address'] = $_POST['address'];
			$data_store_physical['long'] = $_POST['map_long'];
			$data_store_physical['lat'] = $_POST['map_lat'];
			$data_store_physical['last_time'] = $_SERVER['REQUEST_TIME'];
			
			
			if(is_array($_POST['images'])){
				foreach($_POST['images'] as &$images_value){
					$images_value = getAttachment($images_value);
				}
				$data_store_physical['images'] = implode(',',$_POST['images']);
			}else {
				json_return(1,'门店照片不存在，添加失败');
			}
			
			
			
			$data_store_physical['business_hours'] = $_POST['business_hours'];
			$data_store_physical['description'] = $_POST['description'];
				
			$database_store_physical = D('Store_physical');
			if($database_store_physical->data($data_store_physical)->add()){
				D('Store')->where(array('store_id'=>$this->store_session['store_id']))->setInc('physical_count');
				json_return(0,'添加成功');
			}else{
				json_return(1,'添加失败');
			}
		}else{
			json_return(1,'非法访问！');
		}
	}
	//门店编辑
	public function physical_edit(){
		if(IS_POST){
			$condition_store_physical['pigcms_id'] = $_POST['pigcms_id'];	
			$condition_store_physical['store_id'] = $this->store_session['store_id'];
			$data_store_physical['name'] = $_POST['name'];
			$data_store_physical['phone1'] = $_POST['phone1'];
			$data_store_physical['phone2'] = $_POST['phone2'];
			$data_store_physical['province'] = $_POST['province'];
			$data_store_physical['city'] = $_POST['city'];
			$data_store_physical['county'] = $_POST['county'];
			$data_store_physical['address'] = $_POST['address'];
			$data_store_physical['long'] = $_POST['map_long'];
			$data_store_physical['lat'] = $_POST['map_lat'];
			$data_store_physical['last_time'] = $_SERVER['REQUEST_TIME'];
			
			if(is_array($_POST['images'])){
				foreach($_POST['images'] as &$images_value){
					$images_value = getAttachment($images_value);
				}
				$data_store_physical['images'] = implode(',',$_POST['images']);
			}else {
				json_return(1,'门店照片不存在，修改失败');
			}
			
			
			$data_store_physical['images'] = implode(',',$_POST['images']);
			$data_store_physical['business_hours'] = $_POST['business_hours'];
			$data_store_physical['description'] = $_POST['description'];
				
			$database_store_physical = D('Store_physical');
			if($database_store_physical->where($condition_store_physical)->data($data_store_physical)->save()){
				json_return(0,'修改成功');
			}else{
				json_return(1,'修改失败');
			}
		}else{
			json_return(1,'非法访问！');
		}
	}
	//门店删除
	public function physical_del(){
		if(IS_POST){
			$database_store_physical = D('Store_physical');
			$condition_store_physical['pigcms_id'] = $_POST['pigcms_id'];
			$condition_store_physical['store_id']  = $this->store_session['store_id'];
			if($database_store_physical->where($condition_store_physical)->delete()){
				D('Store')->where(array('store_id'=>$this->store_session['store_id']))->setDec('physical_count');
				json_return(0,'删除成功');
			}else{
				json_return(1,'删除失败');
			}
		}else{
			json_return(1,'非法访问！');
		}
	}
	
	// 物流配送相关
	public function config() {
		$this->display();
	}
	
	public function logistics() {
		$store = M('Store')->getStore($this->store_session['store_id']);
		$this->assign('store', $store);
		$this->display();
	}
	
	public function logistics_status() {
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];
		
		$store = M('Store');
		$result = D('Store')->where(array('store_id' => $store_id))->data(array('open_logistics' => $status))->save();
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}
	
	private function _friend_content(){
		$store = M('Store')->getStoreById($this->store_session['store_id'], $this->user_session['uid']);
		$this->assign('store', $store);
	}
	
	public function friend_status() {
		$status = intval(trim($_POST['status']));
		$store_id = $this->store_session['store_id'];
	
		$store = M('Store');
		$result = D('Store')->where(array('store_id' => $store_id))->data(array('open_friend' => $status))->save();
		if ($result) {
			json_return(0, '保存成功！');
		} else {
			json_return(4099, '保存失败，请重试！');
		}
	}
}
?>