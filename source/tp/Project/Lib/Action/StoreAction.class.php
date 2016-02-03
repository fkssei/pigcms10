<?php
/**
 * 店铺
 * User: pigcms_21
 * Date: 2015/3/18
 * Time: 20:02
 */

class StoreAction extends BaseAction
{
    public function index()
    {
        $store = D('StoreView');
        $sale_category = M('SaleCategory');

        $condition = array();
        if (!empty($_GET['type']) && !empty($_GET['keyword'])) {
            if ($_GET['type'] == 'store_id') {
                $condition['Store.store_id'] = trim($_GET['keyword']);
            } else if ($_GET['type'] == 'user') {
                $condition['User.nickname'] = array('like', '%' . trim($_GET['keyword']) . '%');
            } else if ($_GET['type'] == 'account') {
                $condition['User.phone'] = array('like', "%" . trim($_GET['keyword']));
            } else if ($_GET['type'] == 'name') {
                $condition['Store.name'] = array('like', '%' . trim($_GET['keyword']) . '%');
            } else if ($_GET['type'] == 'tel') {
                $condition['Store.tel'] = array('like', '%' . trim($_GET['keyword']));
            }
        }
        if (!empty($_GET['sale_category'])) {
            $condition['_string'] = "(Store.sale_category_id = '" . $_GET['sale_category'] . "' OR Store.sale_category_fid = '" . $_GET['sale_category'] . "')";
        }
        if (isset($_GET['approve']) && is_numeric($_GET['approve'])) {
            $condition['approve'] = $_GET['approve'];
        }
        if (isset($_GET['status']) && is_numeric($_GET['status'])) {
            $condition['status'] = $_GET['status'];
        }
        $store_count = $store->where($condition)->count();
        import('@.ORG.system_page');
        $page = new Page($store_count, 10);
        $stores = $store->where($condition)->order("Store.store_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();

        $sale_categories = $sale_category->where(array('status' => 1))->select();

        //未处理的提现记录
        $withdrawal = M('StoreWithdrawal');
        $withdrawal_count = $withdrawal->where(array('status' => 1))->count('pigcms_id');

        $this->assign('stores', $stores);
        $this->assign('page', $page->show());
        $this->assign('sale_categories', $sale_categories);
        $this->assign('withdrawal_count', $withdrawal_count);
        $this->display();
    }

    //
    public function detail()
    {
        $store = D('StoreView');
        $bank = M('Bank');

        $store_id = $this->_get('id', 'trim,intval');

        $store = $store->where(array('Store.store_id' => $store_id))->find();
        if (!empty($store['logo'])) {
            $store['logo'] = getAttachmentUrl($store['logo']);
        } else {
        	$store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
        }

        $bank = $bank->where(array('bank_id' => $store['bank_id']))->getField('name');
        $store['bank'] = $bank;

        $this->assign('store', $store);
        $this->display();
    }

    //
    public function status()
    {
        $store = M('Store');

        if (IS_POST) {
            $store_id = $this->_post('store_id', 'trim,intval');
            $status  = $this->_post('status', 'trim,intval');
            $store->where(array('store_id' => $store_id))->save(array('status' => $status));
        }
    }

    //
    public function approve()
    {
        $store = M('Store');

        if (IS_POST) {
            $store_id = $this->_post('store_id', 'trim,intval');
            $status  = $this->_post('approve', 'trim,intval');
            $store->where(array('store_id' => $store_id))->save(array('approve' => $status));
        }
    }

    //收支明细
    public function inoutdetail()
    {
        $order = D('OrderView');
        $financial_record = D('FinancialRecordView');

        $store_id = $this->_get('id', 'trim,intval');
        if ($store_id) {
            $where['FinancialRecord.store_id'] = $store_id;
        } else {
            //未处理的提现记录
            $withdrawal_count = M('StoreWithdrawal')->where(array('status' => 1))->count('pigcms_id');
            $this->assign('withdrawal_count', $withdrawal_count);
        }
        if ($this->_get('type', 'trim') && $this->_get('keyword', 'trim')) {
            if ($this->_get('type') == 'order_no') {
                $where['FinancialRecord.order_no'] = $this->_get('keyword', 'trim');
            } else if ($this->_get('type') == 'trade_no') {
                $where['FinancialRecord.trade_no'] = $this->_get('keyword', 'trim');
            } else if ($this->_get('type') == 'store') {
                $where['Store.name'] = array('like', '%' . $this->_get('keyword', 'trim') . '%');
            }
        }
        if ($this->_get('record_type')) {
            $where['FinancialRecord.type'] = $this->_get('record_type');
        }
        if ($this->_get('payment_method')) {
            $where['FinancialRecord.payment_method'] = $this->_get('payment_method');
        }
        if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
            $where['_string'] = "FinancialRecord.add_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND FinancialRecord.add_time <= '" . strtotime($this->_get('end_time')) . "'";
        } else if ($this->_get('start_time', 'trim')) {
            $where['FinancialRecord.add_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
        } else if ($this->_get('end_time', 'trim')) {
            $where['FinancialRecord.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
        }
        $record_count = $financial_record->where($where)->count('FinancialRecord.pigcms_id');
        import('@.ORG.system_page');
        $page = new Page($record_count, 10);
        $records = $financial_record->where($where)->order("FinancialRecord.pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();

        $payment_methods = $order->getPaymentMethod();

        $record_types = array(
            1 => '订单入账',
            2 => '提现',
            3 => '退款',
            4 => '系统退款'
        );

        $this->assign('records', $records);
        $this->assign('page', $page->show());
        $this->assign('payment_methods', $payment_methods);
        $this->assign('record_types', $record_types);
        if ($store_id) {
            $this->display('inoutdetail');
        } else {
            $this->display('inoutdetails');
        }
    }

    //提现记录
    public function withdraw()
    {
        $withdrawal = D('StoreWithdrawalView');
        $bank = M('Bank');

        $store_id = $this->_get('id', 'trim,intval');
        $where = array();
        if ($store_id) {
            $where['StoreWithdrawal.store_id'] = $store_id;
        } else {
            $banks = $bank->where(array('status' => 1))->select();
            $this->assign('banks', $banks);

            //未处理的提现记录
            $withdrawal_count = M('StoreWithdrawal')->where(array('status' => 1))->count('pigcms_id');
            $this->assign('withdrawal_count', $withdrawal_count);
        }
        if (!empty($_GET['type']) && !empty($_GET['keyword'])) {
            if ($_GET['type'] == 'trade_no') {
                $where['StoreWithdrawal.trade_no'] = trim($_GET['keyword']);
            } else if ($_GET['type'] == 'bank_account') {
                $where['StoreWithdrawal.bank_card'] = trim($_GET['keyword']);
            } else if ($_GET['type'] == 'store') {
                $where['Store.name'] = array('like', '%' . trim($_GET['keyword']) . '%');
            } else if ($_GET['type'] == 'user') {
                $where['User.name'] = array('like', '%' . trim($_GET['keyword']) . '%');
            } else if ($_GET['type'] == 'tel') {
                $where['Store.tel'] = trim($_GET['keyword']);
            }
        }
        if ($this->_get('bank', 'trim,intval')) {
            $where['StoreWithdrawal.bank_id'] = $this->_get('bank', 'trim,intval');
        }
        if ($this->_get('status', 'trim,intval')) {
            $where['StoreWithdrawal.status'] = $this->_get('status', 'trim,intval');
        }
        if ($this->_get('start_time', 'trim') && $this->_get('end_time', 'trim')) {
            $where['_string'] = "StoreWithdrawal.add_time >= '" . strtotime($this->_get('start_time', 'trim')) . "' AND StoreWithdrawal.add_time <= '" . strtotime($this->_get('end_time')) . "'";
        } else if ($this->_get('start_time', 'trim')) {
            $where['StoreWithdrawal.add_time'] = array('egt', strtotime($this->_get('start_time', 'trim')));
        } else if ($this->_get('end_time', 'trim')) {
            $where['StoreWithdrawal.add_time'] = array('elt', strtotime($this->_get('end_time', 'trim')));
        }
        $withdrawal_count = $withdrawal->where($where)->count('StoreWithdrawal.pigcms_id');
        import('@.ORG.system_page');
        $page = new Page($withdrawal_count, 10);
        $withdrawals = $withdrawal->where($where)->limit($page->firstRow, $page->listRows)->order('StoreWithdrawal.status ASC, StoreWithdrawal.pigcms_id DESC')->select();

        $status = $withdrawal->getWithdrawalStatus();

        $this->assign('withdrawals', $withdrawals);
        $this->assign('status', $status);
        $this->assign('page', $page->show());
        if ($store_id) {
            $this->display('withdraw');
        } else {
            $this->display('withdraws');
        }
    }

    //提现状态
    public function withdraw_status()
    {
        $withdrawal = M('StoreWithdrawal');
        $store = M('Store');

        $id = $this->_post('id', 'trim');
        $status = $this->_post('status', 'trim,intval');
        $withdrawal_info = $withdrawal->where()->find();
        //提现金额
        $amount = $withdrawal_info['amount'];
        $store_id = $withdrawal_info['store_id'];
        if ($withdrawal->where(array('pigcms_id' => $id))->save(array('status' => $status, 'complate_time' => time()))) {
            if ($status == 4) { //提现失败
                $store->where(array('store_id' => $store_id))->setInc('balance', $amount); //退回账户余额
            }
            echo 1;
        } else {
            echo 0;
        }
    }

    //主营类目
    public function category()
    {
        $category = M('SaleCategory');
        $where = array();
        if ($this->_get('cat_id', 'trim,intval')) {
            $where['_string'] = "cat_id = '" . $this->_get('cat_id', 'trim,intval') . "' OR parent_id = '" . $this->_get('cat_id', 'trim,intval') . "'";
        }

        $category_count = $category->where($where)->count('cat_id');
        import('@.ORG.system_page');
        $page = new Page($category_count, 20);
        $categories = $category->where($where)->order('path ASC')->limit($page->firstRow, $page->listRows)->select();

        //未处理的提现记录
        $withdrawal_count = M('StoreWithdrawal')->where(array('status' => 1))->count('pigcms_id');
        $this->assign('withdrawal_count', $withdrawal_count);


        //所有分类
        $all_categories = $category->order('path ASC')->select();

        $this->assign('categories', $categories);
        $this->assign('all_categories', $all_categories);
        $this->assign('page', $page->show());
        $this->display();
    }

    //添加主营类目
    public function category_add()
    {
        $category = M('SaleCategory');

        if (IS_POST) {
			if($_FILES['pic']['error'] != 4){
				//上传图片
				$rand_num = date('Y/m',$_SERVER['REQUEST_TIME']);
				$upload_dir = './upload/category/'.$rand_num.'/'; 
				if(!is_dir($upload_dir)){
					mkdir($upload_dir,0777,true);
				}
				import('ORG.Net.UploadFile');
				$upload = new UploadFile();
				$upload->maxSize = 10*1024*1024;
				$upload->allowExts = array('jpg','jpeg','png','gif');
				$upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
				$upload->savePath = $upload_dir; 
				$upload->saveRule = 'uniqid';
				if($upload->upload()){
					$uploadList = $upload->getUploadFileInfo();

					// 上传到又拍云服务器
					$attachment_upload_type = C('config.attachment_upload_type');
					if ($attachment_upload_type == '1') {
						import('upyunUser', './source/class/upload/');
						upyunUser::upload('./upload/category/' . $rand_num . '/' . $uploadList[0]['savename'], '/category/' . $rand_num . '/' . $uploadList[0]['savename']);
					}

					$_POST['cat_pic'] = 'category/' . $rand_num.'/'.$uploadList[0]['savename'];
				}else{
					$this->frame_submit_tips(0,$upload->getErrorMsg());
				}
			}
            $data = array();
            $data['parent_id'] = $this->_post('parent_id', 'trim,intval');
            $data['name']      = $this->_post('name', 'trim');
            $data['order_by']  = $this->_post('order_by', 'trim,intval');
            $data['status']    = $this->_post('status', 'trim,intval');
            $data['desc']      = $this->_post('desc', 'trim');
			if($_POST['cat_pic']){
				$data['cat_pic'] = $_POST['cat_pic'];	
			}
			
            if (!empty($data['parent_id'])) {
                $data['level'] = 2;
                $path = $category->where(array('cat_id' => $data['parent_id']))->getField('path');
                $data['path'] = $path;
            } else {
                $data['level'] = 1;
                $data['path'] = 0;
            }
            if ($cat_id = $category->add($data)) {
                if ($cat_id <= 9) {
                    $str_cat_id =  '0' . $cat_id;
                } else {
                    $str_cat_id = $cat_id;
                }
                $path = $data['path'] . ',' . $str_cat_id;
                $category->where(array('cat_id' => $cat_id))->save(array('path' => $path));
                $this->frame_submit_tips(1,'添加成功！');
            } else {
                $this->frame_submit_tips(0,'添加失败！请重试~');
            }
        }
		$this->assign('bg_color','#F3F3F3');
        $categories = $category->where(array('level' => 1, 'status' => 1))->order('order_by ASC, cat_id ASC')->select();

        $this->assign('categories', $categories);
        $this->display();
    }

    //修改主营类目
    public function category_edit()
    {
        $category = M('SaleCategory');

        if (IS_POST) {
			$cat_id = $this->_post('cat_id', 'trim,intval');
			$now_cat = $category->find($cat_id);
			if($_FILES['pic']['error'] != 4){
				//上传图片
				$rand_num = date('Y/m',$_SERVER['REQUEST_TIME']);
				$upload_dir = './upload/category/'.$rand_num.'/'; 
				if(!is_dir($upload_dir)){
					mkdir($upload_dir,0777,true);
				}
				import('ORG.Net.UploadFile');
				$upload = new UploadFile();
				$upload->maxSize = 10*1024*1024;
				$upload->allowExts = array('jpg','jpeg','png','gif');
				$upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
				$upload->savePath = $upload_dir; 
				$upload->saveRule = 'uniqid';
				if($upload->upload()){
					$uploadList = $upload->getUploadFileInfo();

					// 上传到又拍云服务器
					$attachment_upload_type = C('config.attachment_upload_type');
					if ($attachment_upload_type == '1') {
						import('upyunUser', './source/class/upload/');
						upyunUser::upload('./upload/category/' . $rand_num . '/' . $uploadList[0]['savename'], '/category/' . $rand_num . '/' . $uploadList[0]['savename']);
					}

					$_POST['cat_pic'] = 'category/' . $rand_num.'/'.$uploadList[0]['savename'];
				}else{
					$this->frame_submit_tips(0,$upload->getErrorMsg());
				}
			}
			
            $data = array();
            $data['parent_id'] = $this->_post('parent_id', 'trim,intval');
            $data['name']      = $this->_post('name', 'trim');
            $data['order_by']  = $this->_post('order_by', 'trim,intval');
            $data['status']    = $this->_post('status', 'trim,intval');
            $data['desc']      = $this->_post('desc', 'trim');
			if($_POST['cat_pic']){
				$data['cat_pic'] = $_POST['cat_pic'];	
			}
          

            if (!empty($data['parent_id'])) {
                $data['level'] = 2;
                $path = $category->where(array('cat_id' => $data['parent_id']))->getField('path');
                $data['path'] = $path;
            } else {
                $data['level'] = 1;
                $data['path'] = 0;
            }

            if ($category->where(array('cat_id' => $cat_id))->save($data)) {
                if ($cat_id <= 9) {
                    $str_cat_id =  '0' . $cat_id;
                } else {
                    $str_cat_id = $cat_id;
                }
                $path = $data['path'] . ',' . $str_cat_id;
                $category->where(array('cat_id' => $cat_id))->save(array('path' => $path));
				if($_POST['cat_pic'] && $now_cat['cat_pic']){
					unlink('./upload/'.$now_cat['cat_pic']);

					// 上传到又拍云服务器
					$attachment_upload_type = C('config.attachment_upload_type');
					if ($attachment_upload_type == '1') {
						import('upyunUser', './source/class/upload/');
						upyunUser::delete('/' . $now_cat['cat_pic']);
					}
				}
                $this->frame_submit_tips(1,'修改成功！');
            } else {
                $this->frame_submit_tips(0,'修改失败！请重试~');
            }
        }
		$this->assign('bg_color','#F3F3F3');
        $id = $this->_get('id', 'trim,intval');

        $categories = $category->where(array('level' => 1, 'status' => 1))->order('order_by ASC, cat_id ASC')->select();

        $category = $category->find($id);
        $category['cat_pic'] = getAttachmentUrl($category['cat_pic']);

        $this->assign('categories', $categories);
        $this->assign('category', $category);
        $this->display();
    }

    //修改主营类目状态
    public function category_status()
    {
        $category = M('SaleCategory');

        $cat_id = $this->_post('cat_id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        $category->where(array('cat_id' => $cat_id))->save(array('status' => $status));
        $category->where(array('parent_id' => $cat_id))->save(array('status' => $status, 'parent_status' => $status));
    }

    //删除主营类目
    public function category_del()
    {
        $category = M('SaleCategory');

        $cat_id = $this->_get('id', 'trim,intval');
        if ($category->delete($cat_id)) {
            $category->where(array('parent_id' => $cat_id))->delete(); //删除子分类
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！请重试~');
        }
    }


	//商铺品牌类别
	public function brandType() {

		$count = M('StoreBrandType')->count();
		import('@.ORG.system_page');
		$page = new Page($count, 10);
		$list = M('StoreBrandType')->limit($page->firstRow . ',' . $page->listRows)->select();

		$this->assign('typelist', $list);
		$this->assign('page', $page->show());
		$this->display();
	}

	//修改商品品牌类别状态
	public function brandType_status()
	{
		$StoreBrandType = M('StoreBrandType');
		$type_id = $this->_post('type_id', 'trim,intval');
		$status = $this->_post('status', 'trim,intval');
		$StoreBrandType->where(array('type_id' => $type_id))->save(array('status' => $status));
	}

	//添加商品品牌类别
	public function brandtype_add(){
		$StoreBrandType = M('StoreBrandType');

		if (IS_POST) {

			$data = array();
			$data['type_name'] = $this->_post('type_name', 'trim');
			$data['order_by']  = $this->_post('order_by', 'trim,intval');
			$data['status']    = $this->_post('status', 'trim,intval');


			if ($type_id = $StoreBrandType->add($data)) {
				$this->frame_submit_tips(1,'添加成功！');
			} else {

				$this->frame_submit_tips(0,'添加失败！请重试~');
			}
		}
		$this->assign('bg_color','#F3F3F3');
		$StoreBrandType = $StoreBrandType->where(array('status' => 1))->order('order_by ASC, type_id ASC')->select();

		$this->assign('categories', $StoreBrandType);
		$this->display();

	}


	//添加商品品牌类别
	public function brandtype_edit()
	{
		$StoreBrandType = M('StoreBrandType');

		if (IS_POST) {
			$type_id = $this->_post('type_id', 'trim,intval');

			$data = array();
			$data['type_name']      = $this->_post('type_name', 'trim');
			$data['order_by']  = $this->_post('order_by', 'trim,intval');
			$data['status']    = $this->_post('status', 'trim,intval');

			if ($StoreBrandType->where(array('type_id' => $type_id))->save($data)) {
				$this->frame_submit_tips(1,'修改成功！');
			} else {
				$this->frame_submit_tips(0,'修改失败！请重试~');
			}
		}
		$this->assign('bg_color','#F3F3F3');
		$type_id = $this->_get('id', 'trim,intval');

		$StoreBrandType = $StoreBrandType->find($type_id);

		$this->assign('brandtype', $StoreBrandType);
		$this->display();
	}

	//删除商品品牌类别
	public function brandtype_del()
	{
		$category = M('StoreBrandType');

		$type_id = $this->_get('id', 'trim,intval');


		/*如果有子栏目 先删除子栏目再删除*/
		$where = array('type_id' => $type_id);
		if( M('StoreBrand')->where($where)->count()){

			$this->error('删除失败！该品牌类目下仍有品牌，请先清除品牌再来操作！');

		}


		/*如果有子栏目 先删除子栏目再删除*/

		if ($category->delete($type_id)) {
			//有品牌的時候刪除否？

			$this->success('删除成功！');
		} else {
			$this->error('删除失败！请重试~');
		}
	}

	//商铺品牌列表
	public function brand() {

		if ($this->_get('type_id', 'trim,intval')) {
			$where['_string'] = "type_id = '" . $this->_get('type_id', 'trim,intval'). "'";
		}

		$count = M('StoreBrand')->where($where)->count();

		import('@.ORG.system_page');
		$page = new Page($count, 10);
		$list = M('StoreBrand')->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		//类别
		$brandtype =  M('StoreBrandType')->where(array( 'status' => 1))->order('order_by ASC, type_id ASC')->select();

		$this->assign('all_brandtypes', $brandtype);
		$this->assign('brands', $list);
		$this->assign('page', $page->show());
		$this->display();
	}

	//修改商品品牌类别状态
	public function brand_status()
	{
		$StoreBrand = M('StoreBrand');
		$brand_id = $this->_post('brand_id', 'trim,intval');
		$status = $this->_post('status', 'trim,intval');
		$StoreBrand->where(array('brand_id' => $brand_id))->save(array('status' => $status));
	}

	//添加商铺品牌
	public function brand_add()
	{
		$brand = M('StoreBrand');

		if (IS_POST) {
			if($_FILES['pic']['error'] != 4){
				//上传图片
				$rand_num = date('Y/m',$_SERVER['REQUEST_TIME']);
				$upload_dir = './upload/brand/'.$rand_num.'/';
				if(!is_dir($upload_dir)){
					mkdir($upload_dir,0777,true);
				}
				import('ORG.Net.UploadFile');
				$upload = new UploadFile();
				$upload->maxSize = 10*1024*1024;
				$upload->allowExts = array('jpg','jpeg','png','gif');
				$upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
				$upload->savePath = $upload_dir;
				$upload->saveRule = 'uniqid';
				if($upload->upload()){
					$uploadList = $upload->getUploadFileInfo();

					// 上传到又拍云服务器
					$attachment_upload_type = C('config.attachment_upload_type');
					if ($attachment_upload_type == '1') {
						import('upyunUser', './source/class/upload/');
						upyunUser::upload('./upload/brand/' . $rand_num . '/' . $uploadList[0]['savename'], '/brand/' . $rand_num . '/' . $uploadList[0]['savename']);
					}

					$_POST['pic'] = 'brand/' . $rand_num.'/'.$uploadList[0]['savename'];
				}else{
					$this->frame_submit_tips(0,$upload->getErrorMsg());
				}
			}
			$data = array();

			$data['store_id']  = $this->_post('storeid', 'trim');
			$data['type_id']      = $this->_post('type_id', 'trim');
			if(empty($data['store_id']) || empty($data['type_id'])) $this->frame_submit_tips(0,'添加失败！请重试~');
			$data['name']      = $this->_post('name', 'trim');
			$data['order_by']  = $this->_post('order_by', 'trim,intval');
			$data['status']    = $this->_post('status', 'trim,intval');
			$data['desc']      = $this->_post('desc', 'trim');
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}


			if ($brand_id = $brand->add($data)) {

				$this->frame_submit_tips(1,'添加成功！');
			} else {
				echo $brand->getLastSql();exit;
				$this->frame_submit_tips(0,'添加失败！请重试~~~');
			}
		}
		$this->assign('bg_color','#F3F3F3');
		$brandtypes =  M('StoreBrandType')->where(array( 'status' => 1))->order('order_by ASC,type_id ASC')->select();
		//echo M('StoreBrandType')->getLastSql();
		//dump($brandtypes);exit;
		$this->assign('brandtypes', $brandtypes);
		$this->display();
	}



	//修改商铺品牌
	public function brand_edit()
	{
		$StoreBrand = M('StoreBrand');

		if (IS_POST) {
			$brand_id = $this->_post('brand_id', 'trim,intval');
			$now_brand = $StoreBrand->find($brand_id);
			if($_FILES['pic']['error'] != 4){
				//上传图片
				$rand_num = date('Y/m',$_SERVER['REQUEST_TIME']);
				$upload_dir = './upload/brand/'.$rand_num.'/';
				if(!is_dir($upload_dir)){
					mkdir($upload_dir,0777,true);
				}
				import('ORG.Net.UploadFile');
				$upload = new UploadFile();
				$upload->maxSize = 10*1024*1024;
				$upload->allowExts = array('jpg','jpeg','png','gif');
				$upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
				$upload->savePath = $upload_dir;
				$upload->saveRule = 'uniqid';
				if($upload->upload()){
					$uploadList = $upload->getUploadFileInfo();

					// 上传到又拍云服务器
					$attachment_upload_type = C('config.attachment_upload_type');
					if ($attachment_upload_type == '1') {
						import('upyunUser', './source/class/upload/');
						upyunUser::upload('./upload/brand/' . $rand_num . '/' . $uploadList[0]['savename'], '/brand/' . $rand_num . '/' . $uploadList[0]['savename']);
					}

					$_POST['pic'] = 'brand/' . $rand_num.'/'.$uploadList[0]['savename'];
				}else{
					$this->frame_submit_tips(0,$upload->getErrorMsg());
				}
			}

			$data = array();
			$data['store_id']  = $this->_post('storeid', 'trim');
			$data['type_id']      = $this->_post('type_id', 'trim');
			if(empty($data['store_id']) || empty($data['type_id'])) $this->frame_submit_tips(0,'添加失败！请重试~');
			$data['name']      = $this->_post('name', 'trim');
			$data['order_by']  = $this->_post('order_by', 'trim,intval');
			$data['status']    = $this->_post('status', 'trim,intval');
			$data['desc']      = $this->_post('desc', 'trim');
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}


			$store_status = $StoreBrand->where(array('brand_id' => $brand_id))->save($data);
			if ($store_status === 0 || $store_status) {

				if($_POST['pic'] && $now_brand['pic']){
					unlink('./upload/'.$now_brand['pic']);

					// 上传到又拍云服务器
					$attachment_upload_type = C('config.attachment_upload_type');
					if ($attachment_upload_type == '1') {
						import('upyunUser', './source/class/upload/');
						upyunUser::delete('/' . $now_brand['pic']);
					}
				}
				$this->frame_submit_tips(1,'修改成功！');
			} else {

				$this->frame_submit_tips(0,'修改失败！请重试~');
			}
		}
		$this->assign('bg_color','#F3F3F3');
		$id = $this->_get('id', 'trim,intval');

		$brandtype =  M('StoreBrandType')->where(array( 'status' => 1))->order('order_by ASC, type_id ASC')->select();
		$StoreBrand = $StoreBrand->find($id);
		$StoreBrand['pic'] = getAttachmentUrl($StoreBrand['pic']);
		if($StoreBrand['store_id']) {
			$Store = M('Store')->find($StoreBrand['store_id']);
			$StoreBrand['store_name'] = $Store['name'];

		}
		$this->assign('brandtype', $brandtype);
		$this->assign('StoreBrand', $StoreBrand);
		$this->display();
	}


	//删除商铺品牌
	public function brand_del()
	{
		$StoreBrand = M('StoreBrand');
		$brand_id = $this->_get('id', 'trim,intval');

		$now_brand = $StoreBrand->find($brand_id);
		if ($StoreBrand->delete($brand_id)) {
			//删除图片
			if($now_brand['pic']){
				unlink('./upload/'.$now_brand['pic']);
				// 上传到又拍云服务器
				$attachment_upload_type = C('config.attachment_upload_type');
				if ($attachment_upload_type == '1') {
					import('upyunUser', './source/class/upload/');
					upyunUser::delete('/' . $now_brand['pic']);
				}
			}

			$this->success('删除成功！');
		} else {
			$this->error('删除失败！请重试~');
		}
	}


	//搜索店铺
	public function search_store() {
		$keyword = $this->_post('store_name');
		if(empty($keyword)) return false;

		$where = array(
			'name' =>  array('like', '%' . $keyword . '%')
		);
		$Store = M('Store');
		$store_list = $Store->where($where)->field("`store_id`,`name`")->limit(10)->select();


		echo json_encode($store_list);
		exit;
	}
	
	private function getStoreNameToken($store_id_arr = array()) {
        if (empty($store_id_arr)) {
       		return array(0 => '-');
        }
        
        $store_list = D('Store')->where("`status` = 1 AND `store_id` in (" . join(',', $store_id_arr) . ")")->select();
        
        $data = array();
        foreach ($store_list as $store) {
			$token = $this->getToken($store['store_id']);
        	$data[$token] = $store['name'];
        }
        
        return $data;
        
    }
	public function activityManage(){
		$_activityModel = array('bargain','seckill','crowdfunding','unitary','cutprice','red_packet');
		$_eventsId      = array('bargain'=>'pigcms_id','seckill'=>'action_id','cutprice'=>'pigcms_id'); //活动ID转换，调用时用作排序
		$_eventsToken   = array('seckill'=>'action_token'); //活动Token转换，where条件生成时需要
		$_eventsModel   = array('seckill'=>'seckillAction','red_packet'=>'redPacket'); //活动Model转换，每张表明不一致
		$_modelName     = array('bargain'=>'砍价','seckill'=>'秒杀','crowdfunding'=>'众筹','unitary'=>'一元夺宝','cutprice'=>'降价拍','red_packet'=>'红包'); //活动名称
		
		$page = $_GET['page'] ? $this->_get('page') : 1;
		$viewInitialNumber = ($page-1)*10;
		
        $apiUrl = C('config.syn_domain');
        $salt   = C('config.encryption') ? C('config.encryption') : 'pigcms';
        
        if(!empty($_GET)){
            $selectModel = $this->_get('activity_type','htmlspecialchars');
        }else{
            $selectModel = $_activityModel[0];
        }
        
        $modelId = $_eventsId[$selectModel] ? $_eventsId[$selectModel] : 'id';
        $model   = $_eventsModel[$selectModel] ? $_eventsModel[$selectModel] : $selectModel;
        $tokenField = $_eventsToken[$selectModel] ? $_eventsToken[$selectModel] : 'token';
        
        $where  = "status=1 AND pigcmsToken !=''";
        if($_GET['keyword'] != ''){
            if ($_GET['type'] == 'store_id') {
                $where .= " AND store_id=".trim($_GET['keyword']);
            } else if ($_GET['type'] == 'user') {
                $where .= " AND name LIKE %".trim($_GET['keyword'])."%";
            } else if ($_GET['type'] == 'tel') {
                $where .= " AND tel LIKE %".trim($_GET['keyword'])."%";
            }
        }
        $store_id       = array();
        $pigcmsToken    = M('Store')->where($where)->field('store_id,pigcmsToken')->select();
        $tokenRally     = '';
        if(!empty($pigcmsToken)){
            foreach($pigcmsToken as $key=>$val){
                $tokenRally .= $val['pigcmsToken'].',';
                $store_id[] = $val['store_id'];
            }
            $tokenRally     = rtrim($tokenRally,',');
        }else{
            $tokenRally     = '-1'; //防止无数据错误
        }

        $condition[$tokenField] = array('in',$tokenRally);
        $post = array(
            'option'=>array(
                'order' => $modelId.' DESC',
                'where' => $condition,
                'limit' => $viewInitialNumber.',10'
            ),
            'model' => ucfirst($model),
            'debug'=>true
        );
		
		$post['sign'] = $this->getSign($post,$salt);
		$result = $this->api_curl_post($apiUrl.'/index.php?g=Home&m=Auth&a=select',$post);

		if($result['status'] == 0 && $result['data'] != null){
			$activityFunction = $selectModel.'Data';
			
			$this->assign('activityList',D('ActivityManage')->$activityFunction($result['data']));
			$this->assign('activityName',$_modelName[$selectModel]);
		}
		
		$result = $this->api_curl_post($apiUrl.'/index.php?g=Home&m=Auth&a=count',$post);
		
		if($result['status'] == 0 && $result['data'] != null){
			import('@.ORG.system_page');
        	$page = new Page($result['data']['count'], 10);
			
			$this->assign('page',$page->show());
		}

		if(!empty($store_id)){
			$storeNames = $this->getStoreNameToken($store_id);
			$this->assign('storeNames',$storeNames);
		}
		
		$this->assign('selectModel',$selectModel);
		$this->assign('modelName',$_modelName);
		$this->display();
	}
	public function activityRecommendAdd(){
		if($this->isPost()){
			foreach($_POST as $val){
				$activityRecommend = M('Activity_recommend')->where(array('modelId'=>$val['modelId'],'model'=>$val['model'],'token'=>$val['token']))->find();
				if(!$activityRecommend){
					$data = $this->clear_html($val);;
					M('Activity_recommend')->add($data);
				}
			}
			echo json_encode(array('status'=>1,'msg'=>'推荐成功'));
		}
	}
	public function activityRecommend(){
		$_modelName     = array('bargain'=>'砍价','seckill'=>'秒杀','crowdfunding'=>'众筹','unitary'=>'一元夺宝','cutprice'=>'降价拍','red_packet'=>'红包'); //活动名称
		
        $store_id         = array();

		$activityRecommend = M('Activity_recommend');
		$condition = array();
		if(!empty($_GET)){
			if($_GET['activity_type'] != 999){
				$condition['model'] = $this->_get('activity_type','htmlspecialchars');
			}
		}

        $where  = "status=1 AND pigcmsToken !=''";
        if($_GET['keyword'] != ''){
            if ($_GET['type'] == 'store_id') {
                $where .= " AND store_id=".trim($_GET['keyword']);
            } else if ($_GET['type'] == 'user') {
                $where .= " AND name LIKE %".trim($_GET['keyword'])."%";
            } else if ($_GET['type'] == 'tel') {
                $where .= " AND tel LIKE %".trim($_GET['keyword'])."%";
            } else if ($_GET['type'] == 'activity_id'){
                $condition['id']    = intval($_GET['keyword']);
            } else if ($_GET['type'] == 'activity_name'){
                $condition['title']    = trim($_GET['keyword']);
            }
        }

        $pigcmsToken    = M('Store')->where($where)->field('store_id,pigcmsToken')->select();
        $tokenRally     = '';
        if(!empty($pigcmsToken)){
            foreach($pigcmsToken as $key=>$val){
                $tokenRally .= $val['pigcmsToken'].',';
                $store_idp[] = $val['store_id'];
            }
            $tokenRally     = rtrim($tokenRally,',');
        }else{
            $tokenRally     = '-1'; //防止无数据错误
        }


        $condition['token'] = array('in',$tokenRally);

		if(!empty($store_id)){
			$storeNames = $this->getStoreNameToken($store_id);
			$this->assign('storeNames',$storeNames);
		}
		
		
		$activity_count = $activityRecommend->where($condition)->count();
        import('@.ORG.system_page');
        $page = new Page($activity_count, 10);
        $activity = $activityRecommend->where($condition)->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();

		$this->assign('activity',$activity);
		$this->assign('modelName',$_modelName);
		$this->assign('page',$page->show());
		$this->display();
	}
	public function activityRecommendDel(){
		if($this->isPost()){
			$data = implode(',',$this->clear_html($_POST));
			if(M('Activity_recommend')->where(array('id'=>array('in',$data)))->delete()){
				echo json_encode(array('status'=>1,'msg'=>'删除成功'));
			}else{
				echo json_encode(array('status'=>0,'msg'=>'删除失败'));
			}
		}
	}
    public function activityRecommendRecAdd(){
        if($this->isPost()){
            $data = implode(',',$this->clear_html($_POST));
            if(M('Activity_recommend')->where(array('id'=>array('in',$data)))->data(array('is_rec'=>1))->save()){
                echo json_encode(array('status'=>1,'msg'=>'操作成功'));
            }else{
                echo json_encode(array('status'=>0,'msg'=>'请不要重复添加'));
            }
        }
    }
    public function activityRecommendRecDel(){
        if($this->isPost()){
            $data = implode(',',$this->clear_html($_POST));
            if(M('Activity_recommend')->where(array('id'=>array('in',$data)))->data(array('is_rec'=>0))->save()){
                echo json_encode(array('status'=>1,'msg'=>'操作成功'));
            }else{
                echo json_encode(array('status'=>0,'msg'=>'请不要重复取消'));
            }
        }
    }
	private function clear_html($array) {
		if(!is_array($array)) return trim(htmlspecialchars($array, ENT_QUOTES));
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->clear_html($value);
            } else {
                $array[$key] = trim(htmlspecialchars($value, ENT_QUOTES));
            }
        }
        return $array;
    }
	
	/**
 	* 微信API CURL POST
 	*
 	* param url 抓取的URL
 	* param data post的数组
 	*/
	private function api_curl_post($url,$data){
		$result = $this->post($url,$data);
		$result_arr = json_decode($result,true);
		return $result_arr;
	}
	private function post($url,$post){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// post数据
		curl_setopt($ch, CURLOPT_POST, true);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		$result = curl_exec($ch);
		curl_close($ch);
		//返回获得的数据
		return $result;
	}
	private function getToken($id){
		return substr(md5(C('config.site_url').$id.$this->synType),8,16);
	}
	private function getSign($data,$salt){
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$validate[$key] = $this->getSign($value,$salt);
			} else {
				$validate[$key] = $value;
			}			
		}
		$validate['salt'] = $salt;
		sort($validate, SORT_STRING);
		return sha1(implode($validate));
	}
	
	
	
	//店铺对账
	public function check() {
	
		$store = D('Store');
		$order = D('Order');
		$order_product = D('OrderProductView');
		$limit = 5;
		//现在
		$config_sales_ratio = $this->config['sales_ratio'];
		$sales_ratio = $config_sales_ratio*0.01;
		$store_id = $this->_get('id');
		if($this->_get('types') == 'checked') {
			//已对账
			$is_check = 2;
		} else {
				
			$is_check = 1;
		}
	
	
		if (IS_POST) {
			//修改对账状态
				
			$store_id = $store_id ? $store_id : $this->_post('store_id');
			$arr = array(
					'order_id' => $this->_post('order_id'),
					'order_no' => $this->_post('order_no'),
					'store_id' => $store_id,
					'is_check' => $this->_post('is_check')
			);
			$wheres = array(
					'order_id' => $this->_post('order_id'),
					'order_no' => $this->_post('order_no')
			);
			$order->where($wheres)->save(array('is_check'=> 2,'sales_ratio' => $config_sales_ratio ));
			if($this->set_check_log($arr)) {
				exit(json_encode(array('error' => 0,'message' =>'已出账')));
			} else{
				exit(json_encode(array('error' => 1,'message' =>'缺少必要参数')));
			}
		}
			
		//获取店铺订单信息
		/*
		 $where = array(
		 'store_id'=> $store_id,
		 //'status' => 4,
		 //'is_fx' => 	0,
		 //'user_order_id' => 0
		 );//
		 */
			
		$where['store_id'] = $store_id;
		$where['status'] = 4;
		$where['is_check'] = $is_check;
			
		$order_total = $order->getOrderTotal($where);
			
		import('@.ORG.system_page');
		$page = new Page($order_total, $limit);
			
		$order_list = $order->where($where)->order("order_id asc")->limit($page->firstRow . ',' . $page->listRows)->select();
	
		foreach($order_list as $k => $v){
			$order_id_arr[] = $v['order_id'];
		}
	
		$order_id_arr = is_array($order_id_arr) ? $order_id_arr : array();
			
		//dump($order_id_arr);
	
		//获取取到的订单的商品信息
		$order_prodcut_detail = $order_product->getStoreProductByorderArr($order_id_arr,$store_id);
	//	dump($order_prodcut_detail);
	
		//抽取比例
		//dump($this->system_session);
		//dump($this->config);

		foreach($order_list as $k => &$v){
			$v['un_check_account'] = $order_prodcut_detail['amount'][$v['order_id']];
			$v['should_check_account'] = $v['un_check_account']*(1-$v['sales_ratio']*0.01);
			$v['sales_ratio'] = ($v['sales_ratio']).'%';
			$page_uncheck_account[] = $order_prodcut_detail['amount'][$v['order_id']];
			$page_should_check_account[] = $v['un_check_account']*(1-$sales_ratio);
			
			$had_page_should_check_account[] = $v['un_check_account']*(100-$v[sales_ratio])*0.01;

				
		}
	
	
		//本页包含的其他页面info
		$info = array(
				'sys_sales_ratio' => ($sales_ratio*100).'%',
				'order_sales_ratio' => ($sales_ratio*100).'%',
				'page_uncheck_account' => array_sum($page_uncheck_account),
				'page_should_check_account' => array_sum($page_should_check_account),
				'page_liyun_account' => array_sum($page_uncheck_account)-array_sum($page_should_check_account),
				
				'had_page_uncheck_account' => array_sum($page_uncheck_account),
				'had_page_should_check_account' => array_sum($had_page_should_check_account),
				'had_page_liyun_account' => array_sum($page_uncheck_account)-array_sum($had_page_should_check_account)				
		);
	
	
		$this->assign('orders',$order_list);
		$this->assign('page', $page->show());
		$this->assign('info',$info);
		$this->assign('store_id',$store_id);
		$this->assign('is_check', $is_check);
		$this->display();
	}
	
	
	/*description:记录出账日志
	 *
	 * @arr : 必须包含： order_id,order_no
	 */
	public function set_check_log($arr) {
	
		$check_log = D('OrderCheckLog');
	
		$thisUser = $this->system_session;
	
		if(empty($arr['order_id']) || empty($arr['order_no']) || empty($thisUser['id']) || empty($arr['store_id']) ) {
	
			return false;
		}
	
		$description = "";
	
		$data = array(
				'timestamp' => time(),
				'admin_uid' => 	$thisUser['id'],
				'order_id' => $arr['order_id'],
				'store_id' => $arr['store_id'],
				'order_no' => $arr['order_no'],
				'ip' => ip2long($_SERVER['REMOTE_ADDR']),
				'description' => $description
		);
	
		if($check_log->add($data)){
			return true;
		}else{
			return false;
		}
	}
	
	//店铺评价删除
	public function comment_del() {
	
		$comment = M('Comment');
		$delete_flg = $this->_get('delete', 'trim,intval');
		$comment_id = $this->_get('comment_id', 'trim,intval');
	
		if ($comment->where(array('id' => $comment_id))->save(array('delete_flg' => $delete_flg))) {
			$this->success('操作成功');
			exit;
		} else {
			$this->error('操作失败');
		}
	}
	
	
	//店铺评价审核操作
	public function comment_status() {
	
		$comment = M('Comment');
	
		$comment_id = $this->_post('id', 'trim,intval');
		$status   = $this->_post('status','trim,intval');
		if ($comment->where(array('id' => $comment_id))->save(array('status' => $status ))) {
			$this->success('操作成功');
			exit;
		} else {
				
			$this->error('操作失败');
		}
	}
	
	
	//店铺评价管理
	public function comment() {
		$config = C('config');
		//$where['delete_flg'] = 0;
		$where['type'] = 'STORE';
		$comment_model = D('Comment');
		$isdelete = $this->_get("isdelete");
		if(in_array($isdelete,array('0','1'))) {
			$where['delete_flg'] = $isdelete;
		}
	
	
		$count = $comment_model->getCount($where);
		if($count>0) {
			$limit = 15;
			import('@.ORG.system_page');
			$page = new Page($count, $limit);
				
				
			$comment_list = $comment_model->getList($where, 'id desc', $page->listRows, $page->firstRow, true);
	
			foreach($comment_list['comment_list'] as $k=>$v) {
				$product_new_arr[] = $v['relation_id'];
			}
	
			$in_array = $product_new_arr;
	
			$Stores = D('Store')->where(array('store_id'=>array('in',$in_array)))->select();
			if(is_array($Stores)) {
				foreach($Stores as $k=>$v) {
					$store_arr[$v['store_id']] = $v;
				}
			}
			//dump($comment_list);
			$this->assign('comments', $comment_list);
			$this->assign('page', $page->show());
			$this->assign('config', $config);
			$this->assign('isdelete', $isdelete);
			$this->assign('store_arr', $store_arr);
		}
		$this->display();
	}	
}
