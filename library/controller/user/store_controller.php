<?php

class store_controller extends base_controller {

    public function load() {
        $action = strtolower(trim($_POST['page']));
        if (empty($action))
            pigcms_tips('非法访问！', 'none');

        switch ($action) {
            case 'index_content': //订单概况
                $this->_index_content();
                break;
            case 'wei_page_content': //微页面
                //首页的微杂志
                $home_page = D('Wei_page')->field('`page_id`,`page_name`')->where(array('is_home' => 1, 'store_id' => $this->store_session['store_id']))->find();
                $this->assign('home_page', $home_page);
                //微杂志列表
                $page_list = M('Wei_page')->get_list($this->store_session['store_id']);
                $this->assign('page_list', $page_list);
                break;
            case 'wei_page_edit': //微页面编辑
                $now_page = M('Wei_page')->get_page($this->store_session['store_id'], $_POST['page_id']);
                if (!empty($now_page)) {
                    if ($now_page['has_category']) {
                        $cat_arr = D('Wei_page_to_category')->field('`cat_id`')->where(array('page_id' => $now_page['page_id']))->order('`pigcms_id` ASC')->select();
                        $cat_ids_arr = array();
                        foreach ($cat_arr as $value) {
                            $cat_ids_arr[] = $value['cat_id'];
                        }
                        $this->assign('cat_ids', implode(',', $cat_ids_arr));
                    }
                    if ($now_page['has_custom']) {
                        $customField = M('Custom_field')->get_field($this->store_session['store_id'], 'page', $now_page['page_id']);
                        $this->assign('customField', json_encode($customField));
                    }
                    $this->assign('now_page', $now_page);
                } else {
                    exit('当前页面不存在！');
                }
                break;
            case 'wei_page_category_content': //微页面分类
                $cat_list = M('Wei_page_category')->get_list($this->store_session['store_id']);
                $this->assign('cat_list', $cat_list);
                break;
            case 'wei_page_category_edit':
                $now_category = M('Wei_page_category')->get_category($this->store_session['store_id'], $_POST['cat_id']);
                if (!empty($now_category)) {
                    if ($now_category['has_custom']) {
                        $customField = M('Custom_field')->get_field($this->store_session['store_id'], 'page_cat', $now_category['cat_id']);
                        $this->assign('customField', json_encode($customField));
                    }
                    $this->assign('now_category', $now_category);
                } else {
                    exit('当前分类不存在！');
                }
            case 'ucenter_content': //会员主页
                break;
            case 'setting_content': //店铺信息
                $this->_setting_content();
                break;
            case 'storenav_content': //店铺导航
                $this->_storenav_content();
                break;
            case 'storenav_wei_page': //微页面
                $this->_storenav_wei_page();
                break;
            case 'storenav_wei_page_category': //微页面分类
                $this->_storenav_wei_page_category();
                break;
            case 'storenav_goods': //商品
                $this->_storenav_goods();
                break;
            case 'storenav_goods_group': //商品分类
                $this->_storenav_goods_group();
                break;
            case 'service_list':
                $this->_service_list();
                break;
            case 'service_edit':
                $this->_service_edit();
                break;
            case 'business_hours_list':
                $this->_business_hours_list();
            case 'business_hours_create':
                $this->_business_hours_create();
            case 'edit_business_hours':
                $this->_edit_business_hours();
            default:
                break;
        }
        $this->display($_POST['page']);
    }

    public function store_load() {
        if (empty($_POST['page']))
            pigcms_tips('非法访问！', 'none');
        if ($_POST['page'] == 'select_content') {
            $this->_select_content();
        }
        $this->display($_POST['page']);
    }

    //店铺概况
    public function index() {
        $this->display();
    }

    //微页面
    public function wei_page() {
        $this->display();
    }

    //添加微页面提交页
    public function wei_page_add() {
        if (IS_POST) {
            if ($_POST['cat_ids']) {
                $tmp_arr = explode(',', $_POST['cat_ids']);
                $cat_ids_arr = array();
                foreach ($tmp_arr as $value) {
                    if (!empty($value)) {
                        $cat_ids_arr[] = $value;
                    }
                }
            }
            $database_page = D('Wei_page');
            $data_page['store_id'] = $this->store_session['store_id'];
            $data_page['page_name'] = $_POST['page_name'];
            $data_page['page_desc'] = $_POST['page_desc'];
            $data_page['bgcolor'] = $_POST['bgcolor'];
            $data_page['add_time'] = $_SERVER['REQUEST_TIME'];
            $data_page['has_custom'] = !empty($_POST['custom']) ? 1 : 0;
            $data_page['has_category'] = !empty($cat_ids_arr) ? 1 : 0;
            $page_id = $database_page->data($data_page)->add();
            if (empty($page_id)) {
                json_return(1000, '页面添加失败');
            }

            if (!empty($cat_ids_arr)) {
                $database_page_cat = D('Wei_page_category');
                $database_page_to_cat = D('Wei_page_to_category');
                $data_page_to_cat['page_id'] = $page_id;
                foreach ($cat_ids_arr as $value) {
                    $data_page_to_cat['cat_id'] = $value;
                    if ($database_page_to_cat->data($data_page_to_cat)->add()) {
                        $database_page_cat->where(array('cat_id' => $value))->setInc('page_count');
                    }
                    $database_page_cat->where(array('cat_id' => $value))->data($data_page_to_cat)->save();
                }
            }

            if ($_POST['custom']) {
                $field_result = M('Custom_field')->add_field($this->store_session['store_id'], $_POST['custom'], 'page', $page_id);
                if (empty($field_result)) {
                    json_return(1001, '页面添加成功！自定义内容添加失败。请刷新页面重试');
                } else {
                    json_return(0, '添加成功');
                }
            } else {
                json_return(0, '添加成功');
            }
        } else {
            pigcms_tips('非法访问');
        }
    }

    //编辑微页面提交页
    public function wei_page_edit() {
        if (IS_POST) {
            if ($_POST['cat_ids']) {
                $tmp_arr = explode(',', $_POST['cat_ids']);
                $cat_ids_arr = array();
                foreach ($tmp_arr as $value) {
                    if (!empty($value)) {
                        $cat_ids_arr[] = $value;
                    }
                }
            }

            $database_page = D('Wei_page');
            $condition_page['page_id'] = $_POST['page_id'];
            $condition_page['store_id'] = $this->store_session['store_id'];
            $data_page['page_name'] = $_POST['page_name'];
            $data_page['page_desc'] = $_POST['page_desc'];
            $data_page['bgcolor'] = $_POST['bgcolor'];
            $data_page['add_time'] = $_SERVER['REQUEST_TIME'];
            $data_page['has_custom'] = !empty($_POST['custom']) ? 1 : 0;
            $data_page['has_category'] = !empty($cat_ids_arr) ? 1 : 0;
            if (!$database_page->where($condition_page)->data($data_page)->save()) {
                json_return(1000, '页面编辑失败，请重试');
            }

            $database_page_to_cat = D('Wei_page_to_category');
            $condition_page_to_cat['page_id'] = $_POST['page_id'];
            $tmp_cat_ids = $database_page_to_cat->field('`cat_id`')->where($condition_page_to_cat)->select();
            $cat_ids = array();
            foreach ($tmp_cat_ids as $key => $value) {
                $cat_ids[] = $value['cat_id'];
            }

            //删除以前的关系
            if ($cat_ids) {
                $database_page_to_cat->where($condition_page_to_cat)->delete();
                $database_page_cat = D('Wei_page_category');
                $condition_page_cat['cat_id'] = array('in', $cat_ids);
                $database_page_cat->where($condition_page_cat)->setDec('page_count');
            }
            if (!empty($cat_ids_arr)) {
                //添加新的关系
                $data_page_to_cat['page_id'] = $_POST['page_id'];
                $database_page_cat = D('Wei_page_category');
                foreach ($cat_ids_arr as $value) {
                    $data_page_to_cat['cat_id'] = $value;
                    if ($database_page_to_cat->data($data_page_to_cat)->add()) {
                        $database_page_cat->where(array('cat_id' => $value))->setInc('page_count');
                    }
                    $database_page_cat->where(array('cat_id' => $value))->data($data_page_to_cat)->save();
                }
            }

            M('Custom_field')->delete_field($this->store_session['store_id'], 'page', $_POST['page_id']);
            if ($_POST['custom']) {
                $field_result = M('Custom_field')->add_field($this->store_session['store_id'], $_POST['custom'], 'page', $_POST['page_id']);
                if (empty($field_result)) {
                    json_return(1001, '页面添加成功！自定义内容添加失败。请刷新页面重试');
                } else {
                    json_return(0, '编辑成功');
                }
            } else {
                json_return(0, '编辑成功');
            }
        } else {
            pigcms_tips('非法访问');
        }
    }

    //微页面删除
    public function wei_page_delete() {
        $database_page = D('Wei_page');
        $condition_page['store_id'] = $this->store_session['store_id'];
        $condition_page['page_id'] = $_POST['page_id'];
        $now_page = $database_page->field('`page_id`,`store_id`,`has_category`,`has_custom`')->where($condition_page)->find();
        if (empty($now_page)) {
            json_return(1004, '页面不存在');
        }
        if ($now_page['has_category']) {
            $database_page_to_cat = D('Wei_page_to_category');
            $condition_page_to_cat['page_id'] = $now_page['page_id'];
            $tmp_cat_ids = $database_page_to_cat->field('`cat_id`')->where($condition_page_to_cat)->select();
            $cat_ids = array();
            foreach ($tmp_cat_ids as $key => $value) {
                $cat_ids[] = $value['cat_id'];
            }

            //删除以前的关系
            if ($cat_ids) {
                $database_page_to_cat->where($condition_page_to_cat)->delete();
                $database_page_cat = D('Wei_page_category');
                $condition_page_cat['cat_id'] = array('in', $cat_ids);
                $database_page_cat->where($condition_page_cat)->setDec('page_count');
            }
        }
        if ($now_page['has_custom']) {
            M('Custom_field')->delete_field($now_page['store_id'], 'page', $now_page['page_id']);
        }
        if ($database_page->where($condition_page)->delete()) {
            json_return(0, '删除成功');
        } else {
            json_return(1005, '删除失败，请重试');
        }
    }

    public function set_home() {
        $database_page = D('Wei_page');
        $condition_page['store_id'] = $this->store_session['store_id'];
        if ($database_page->where(array('store_id' => $this->store_session['store_id'], 'is_home' => '1'))->find()) {
            if ($database_page->where($condition_page)->data(array('is_home' => '0'))->save()) {
                $condition_page['page_id'] = $_POST['page_id'];
                if ($database_page->where($condition_page)->data(array('is_home' => '1'))->save()) {
                    json_return(0, '设置成功');
                } else {
                    json_return(1003, '设置失败，请重试');
                }
            } else {
                json_return(1002, '设置失败，请重试');
            }
        } else {
            $condition_page['page_id'] = $_POST['page_id'];
            if ($database_page->where($condition_page)->data(array('is_home' => '1'))->save()) {
                json_return(0, '设置成功');
            } else {
                json_return(1003, '设置失败，请重试');
            }
        }
    }

    //得到所有微页面分类
    public function get_pageCategory() {
        $cat_list = M('Wei_page_category')->get_all_list($this->store_session['store_id']);
        if (empty($cat_list)) {
            json_return(1000, '没有分类');
        } else {
            json_return(0, $cat_list);
        }
    }

    //微页面分类
    public function wei_page_category() {
        $this->display();
    }

    //添加微页面提交页
    public function wei_page_category_add() {
        if (IS_POST) {
            $database_category = D('Wei_page_category');
            $data_category['store_id'] = $this->store_session['store_id'];
            $data_category['cat_name'] = $_POST['cat_name'];
            $data_category['first_sort'] = $_POST['first_sort'];
            $data_category['second_sort'] = $_POST['second_sort'];
            // $data_category['show_style'] = $_POST['show_style'];
            $data_category['cat_desc'] = $_POST['cat_desc'];
            $data_category['add_time'] = $_SERVER['REQUEST_TIME'];
            $data_category['has_custom'] = !empty($_POST['custom']) ? 1 : 0;
            $data_category['uid'] = $_SESSION['user']['uid'];
            $data_category['cover_img'] = !empty($_POST['cover_img']) ? $_POST['cover_img'] : '';
            $cat_id = $database_category->data($data_category)->add();
            if (empty($cat_id)) {
                json_return(1000, '分类添加失败');
            }
            if ($_POST['custom']) {
                $field_result = M('Custom_field')->add_field($this->store_session['store_id'], $_POST['custom'], 'page_cat', $cat_id);
                if (empty($field_result)) {
                    json_return(1001, '分类添加成功！自定义内容添加失败。请刷新页面重试');
                } else {
                    json_return(0, '添加成功');
                }
            } else {
                json_return(0, '添加成功');
            }
        } else {
            pigcms_tips('非法访问');
        }
    }

    //编辑微页面提交页
    public function wei_page_category_edit() {
        if (IS_POST) {
            $database_category = D('Wei_page_category');
            $condition_category['cat_id'] = $_POST['cat_id'];
            $condition_category['store_id'] = $this->store_session['store_id'];
            $data_category['cat_name'] = $_POST['cat_name'];
            $data_category['first_sort'] = $_POST['first_sort'];
            $data_category['second_sort'] = $_POST['second_sort'];
            // $data_category['show_style'] = $_POST['show_style'];
            $data_category['cat_desc'] = $_POST['cat_desc'];
            $data_category['add_time'] = $_SERVER['REQUEST_TIME'];
            $data_category['has_custom'] = !empty($_POST['custom']) ? 1 : 0;
            $data_category['cover_img'] = !empty($_POST['cover_img']) ? $_POST['cover_img'] : '';
            if (!$database_category->where($condition_category)->data($data_category)->save()) {
                json_return(1000, '分类修改失败');
            }

            M('Custom_field')->delete_field($this->store_session['store_id'], 'page_cat', $_POST['cat_id']);
            if ($_POST['custom']) {
                $field_result = M('Custom_field')->save_field($this->store_session['store_id'], $_POST['custom'], 'page_cat', $_POST['cat_id']);
                if (empty($field_result)) {
                    json_return(1001, '分类修改成功！自定义内容添加失败。请刷新页面重试');
                } else {
                    json_return(0, '修改成功');
                }
            } else {
                json_return(0, '修改成功');
            }
        } else {
            pigcms_tips('非法访问');
        }
    }

    //微页面分类删除
    public function wei_page_category_delete() {
        if (IS_POST) {
            $wei_page_category = D('Wei_page_category');
            $wei_page_to_category = D('Wei_page_to_category');
            $cat_id = isset($_POST['cat_id']) ? intval(trim($_POST['cat_id'])) : 0;
            if (!empty($cat_id) && $wei_page_category->where(array('cat_id' => $cat_id))->delete()) {
                $wei_page_to_category->where(array('cat_id' => $cat_id))->delete();
                json_return(0, '删除成功');
            } else {
                json_return(1001, '删除失败');
            }
        } else {
            pigcms_tips('非法访问');
        }
    }

    //会员中心
    public function ucenter() {
        $database_ucenter = D('Ucenter');
        $condition_ucenter['store_id'] = $this->store_session['store_id'];
        $ucenter = $database_ucenter->where($condition_ucenter)->find();
        if (empty($ucenter)) {
            $ucenter['page_title'] = $this->config['ucenter_page_title'];
            $ucenter['bg_pic'] = './upload/images/' . $this->config['ucenter_bg_pic'];
            $ucenter['show_level'] = $this->config['ucenter_show_level'];
            $ucenter['show_point'] = $this->config['ucenter_show_point'];
        } else {
            $ucenter['bg_pic'] = $ucenter['bg_pic'];
            if ($ucenter['has_custom']) {
                $customField = M('Custom_field')->get_field($this->store_session['store_id'], 'ucenter', $this->store_session['store_id']);
                $this->assign('customField', json_encode($customField));
            }
        }

        $this->assign('ucenter', $ucenter);
        $this->display();
    }

    //提交会员中心
    public function ucenter_save() {
        if (empty($this->store_session)) {
            json_return(1, '登录超时，请刷新页面重新登录');
        }
        $database_ucenter = D('Ucenter');
        $condition_ucenter['store_id'] = $this->store_session['store_id'];
        $ucenter = $database_ucenter->field('`store_id`,`has_custom`')->where($condition_ucenter)->find();

        $data_ucenter['page_title'] = $_POST['page_title'];

        // 此处理篾片不做远程和本地处理
        $data_ucenter['bg_pic'] = $_POST['bg_pic'];

        $data_ucenter['show_level'] = intval($_POST['show_level']);
        $data_ucenter['show_point'] = intval($_POST['show_point']);
        $data_ucenter['last_time'] = $_SERVER['REQUEST_TIME'];
        $data_ucenter['has_custom'] = !empty($_POST['custom']) ? 1 : 0;
        if (!empty($ucenter)) {
            if (!$database_ucenter->where($condition_ucenter)->data($data_ucenter)->save()) {
                json_return(1000, '修改失败，请重试。');
            }
        } else {
            $data_ucenter['store_id'] = $this->store_session['store_id'];
            if (!$database_ucenter->data($data_ucenter)->add()) {
                json_return(1001, '修改失败，请重试。');
            }
        }
        if ($ucenter['has_custom']) {
            if ($_POST['custom']) {
                $method_name = 'save_field';
            } else {
                $method_name = 'delete_field';
            }
        } else {
            if ($_POST['custom']) {
                $method_name = 'add_field';
            }
        }
        if ($method_name) {
            if ($method_name != 'delete_field') {
                // dump($_POST['custom']);
                $field_result = M('Custom_field')->$method_name($this->store_session['store_id'], $_POST['custom'], 'ucenter', $this->store_session['store_id']);
            } else {
                $field_result = M('Custom_field')->delete_field($this->store_session['store_id'], 'ucenter', $this->store_session['store_id']);
            }

            if (empty($field_result)) {
                json_return(1001, '自定义内容添加失败');
            } else {
                json_return(0, '修改成功');
            }
        } else {
            json_return(0, '修改成功');
        }
    }

    public function create() {
        //生成6位数字短信验证码
        if (strtolower(trim($_GET['type'])) == 'captcha_generate') {
            $tel = trim($_GET['tel']);
            //$captcha = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $captcha = '123456';
            $_SESSION['captcha'][$tel] = md5($captcha); //手机关联短信验证码
            if (empty($_SESSION['captcha'][$tel])) {
                echo false;
            }
            echo true;
            exit;
        }
        //短信验证校验
        if (strtolower(trim($_GET['type'])) == 'captcha_validate') {
            $tel = trim($_GET['tel']);
            $captcha = trim($_GET['captcha']);
            if (empty($_SESSION['captcha'][$tel]) || $_SESSION['captcha'][$tel] != md5($captcha)) { //验证码有误
                echo false;
            } else {
                echo true;
            }
            exit;
        }
        if (IS_POST) {
            $data = array();
            $data['uid'] = $_SESSION['user']['uid'];
            $data['name'] = trim($_POST['store_name']);
            $data['sale_category_id'] = intval($_POST['sale_category_id']);
            $data['sale_category_fid'] = intval($_POST['sale_category_fid']);
            $data['linkman'] = trim($_POST['contact_man']);
            $data['tel'] = trim($_POST['tel']);
            $data['qq'] = trim($_POST['qq']);
            $data['date_added'] = time();
            $data['drp_supplier_id'] = 0;
            if (!empty($_SESSION['sync_store'])) { //对接店铺
                $data['bind_weixin'] = 1; //已绑定微信
                $data['source_site_url'] = $_SESSION['user']['source_site_url'];
                $data['payment_url'] = $_SESSION['user']['payment_url'];
                $data['notify_url'] = $_SESSION['user']['notify_url'];
                $data['oauth_url'] = $_SESSION['user']['oauth_url'];
                $data['token'] = $_SESSION['user']['token'];
            }

            $user = M('User');
            $store = M('Store');
            $sale_category = M('Sale_category');

            $ischeck_store = option('config.ischeck_store');
            $data['status'] = 1;
            if ($ischeck_store) {
                $data['status'] = 2;
            }

            //创建店铺
            $result = $store->create($data);
            if (!empty($result['err_code'])) {

                $data['company'] = trim($_POST['company_name']);
                $data['province'] = trim($_POST['province']);
                $data['city'] = trim($_POST['city']);
                $data['area'] = trim($_POST['area']);
                $data['address'] = trim($_POST['address']);
                //创建公司
                $company = M('Company');
                if (!$company->getCompanyByUid($this->user_session['uid'])) {
                    $company->create(array('uid' => $data['uid'], 'name' => $data['company'], 'province' => $data['province'], 'city' => $data['city'], 'area' => $data['area'], 'address' => $data['address']));
                }
                if (!empty($_SESSION['captcha'][$data['tel']])) {
                    unset($_SESSION['captcha'][$data['tel']]);
                }

                //用户店铺数加1
                $user->setStoreInc($this->user_session['uid']);
                //设置为卖家
                $user->setSeller($this->user_session['uid'], 1);
                //主营类目店铺数加1
                $sale_category->setStoreInc($data['sale_category_id']);
                $sale_category->setStoreInc($data['sale_category_fid']);

                //关联后台ID
                $user_info = $user->getUserById($this->user_session['uid']);

                if (!$user_info['admin_id']) {
                    //$user->getUserById(array('uid' => $this->user_session['uid']), array('admin_id' => $_SESSION['system']['id']));
                    $store_list = $store->getAllStoresByUid($this->user_session['uid']);
                    if (count($store_list) == 1) {
                        $user->save_user(array('uid' => $this->user_session['uid']), array('admin_id' => $_SESSION['system']['id']));
                    }
                }

                //添加默认消息
                $database_page = D('Wei_page');
                $data_page['store_id'] = $result['err_msg']['store_id'];
                $data_page['page_name'] = '这是您的第一篇微杂志';
                $data_page['is_home'] = 1;
                $data_page['add_time'] = $_SERVER['REQUEST_TIME'];
                $data_page['has_custom'] = 1;
                if ($page_id = $database_page->data($data_page)->add()) {
                    $database_custom_field = D('Custom_field');
                    $data_custom_field['store_id'] = $result['err_msg']['store_id'];
                    $data_custom_field['module_name'] = 'page';
                    $data_custom_field['module_id'] = $page_id;
                    $data_custom_field['field_type'] = 'title';
                    $data_custom_field['content'] = serialize(array('title' => '初次认识微杂志', 'sub_title' => date('Y-m-d H:i', $_SERVER['REQUEST_TIME'])));
                    $database_custom_field->data($data_custom_field)->add();
                    $data_custom_field['field_type'] = 'rich_text';
                    $data_custom_field['content'] = serialize(array('content' => '<p>感谢您使用' . $this->config['site_name'] . '，在' . $this->config['site_name'] . '里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择' . $this->config['site_name'] . '！</p>'));
                    $database_custom_field->data($data_custom_field)->add();
                }


                if ($_SESSION['user']['admin_id']) {
                    redirect(url('store:select'));
                } else {
                    //判断是否创建官方店铺
                    $admin_info = D('Admin')->find();
                    $admin_info = D('User')->where(array('admin_id' => $admin_info['id']))->find();
                    if (!$admin_info) {
                        redirect(url('store:select'));
                    }
					                        redirect(url('store:select'));
//jy comment under line
                    //redirect(url('store:select_template', array('store_id' => $result['err_msg']['store_id'], 'page_id' => $page_id)));
                }
            } else {
                pigcms_tips('店铺添加失败，请重新提交！');
            }
        } else {
            //是否验证手机
            $this->assign('is_check_mobile', option('config.is_check_mobile'));
            $this->assign('has_company', M('Company')->getCompanyByUid($this->user_session['uid']) ? true : false);
            $tmp_categories = M('Sale_category')->getCategoriesValid(0);
            $categories = array();
            foreach ($tmp_categories as $tmp_category) {
                $children = M('Sale_category')->getCategoriesValid($tmp_category['cat_id']);
                $categories[$tmp_category['cat_id']] = array(
                    'cat_id' => $tmp_category['cat_id'],
                    'name' => $tmp_category['name'],
                    'children' => $children
                );
            }
            $this->assign('json_categories', json_encode($categories));
            $this->assign('categories', $categories);
            $this->assign('readme_title', option('config.readme_title'));
            $this->display();
        }
    }

    //选择店铺
    public function select() {
        $user = M('User');
        $avatar = $user->getAvatarById($this->user_session['uid']);

        $create_store_status = true;
        $user = $user->getUserById($this->user_session['uid']);
        if (option('config.user_store_num_limit')) {
            $store_num = $user['stores']; //当前店铺数量
            if ($store_num >= option('config.user_store_num_limit')) {
                $create_store_status = false;
            }
        }

        //进行自动创建
        $store_num = D('Store')->where(array('uid' => $user['uid']))->find();

        $db_prefix = option('system.DB_PREFIX');
        $table_pigcms_store = $db_prefix . 'store';
        $table_pigcms_product = $db_prefix . 'product';
        $table_pigcms_wei_page_category = $db_prefix . 'wei_page_category';
        $table_pigcms_wei_page = $db_prefix . 'wei_page';
        $table_pigcms_custom_field = $db_prefix . 'custom_field';
        $table_pigcms_product_group = $db_prefix . 'product_group';

        if (!$user['stores'] && !$store_num && $_SESSION['system']) {
            $sql = "INSERT INTO `" . $table_pigcms_store . "` (`uid`, `name`, `edit_name_count`, `logo`, `sale_category_fid`, `sale_category_id`, `linkman`, `tel`, `intro`, `approve`, `status`, `date_added`, `service_tel`, `service_qq`, `service_weixin`, `bind_weixin`, `weixin_name`, `weixin_original_id`, `weixin_id`, `qq`, `open_weixin`, `buyer_selffetch`, `buyer_selffetch_name`, `pay_agent`, `offline_payment`, `open_logistics`, `open_friend`, `open_nav`, `nav_style_id`, `use_nav_pages`, `open_ad`, `has_ad`, `ad_position`, `use_ad_pages`, `date_edited`, `income`, `balance`, `unbalance`, `withdrawal_amount`, `withdrawal_type`, `bank_id`, `bank_card`, `bank_card_user`, `opening_bank`, `last_edit_time`, `physical_count`, `drp_supplier_id`, `drp_level`, `collect`, `attention_num`, `wxpay`, `open_drp_approve`, `drp_approve`, `drp_profit`, `drp_profit_withdrawal`, `open_service`, `source_site_url`, `payment_url`, `notify_url`, `oauth_url`, `token`, `open_drp_guidance`, `open_drp_limit`, `drp_limit_buy`, `drp_limit_share`, `drp_limit_condition`, `pigcmsToken`, `template_cat_id`, `template_id`) VALUES ( '" . $_SESSION['user']['uid'] . "', '官方店铺', '0', '', '1', '0', '李标', '13761415048', '', '0', '1', '1438825585', '', '', '', '0', '', '', '', '123456', '0', '0', '', '0', '0', '1', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', '', '0', '0');";
            D('Store')->execute($sql);
            $store_id = D('Store')->lastInsID;

            $group_sql = "INSERT INTO `" . $table_pigcms_product_group . "` (`store_id`, `group_name`, `is_show_name`, `first_sort`, `second_sort`, `list_style_size`, `list_style_type`, `is_show_price`, `is_show_product_name`, `is_show_buy_button`, `buy_button_style`, `group_label`, `product_count`, `has_custom`, `add_time`) VALUES ('567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');";
            D('Product_group')->execute($group_sql);
            $group_id = D('Product_group')->lastInsID;

            $food_arr = array(
                "INSERT INTO  `" . $table_pigcms_product . "`  ( `uid`, `store_id`, `category_fid`, `category_id`, `group_id`, `name`, `sale_way`, `buy_way`, `type`, `quantity`, `price`, `original_price`, `weight`, `code`, `image`, `image_size`, `postage_type`, `postage`, `postage_template_id`, `buyer_quota`, `allow_discount`, `invoice`, `warranty`, `sold_time`, `sales`, `show_sku`, `status`, `date_added`, `soldout`, `pv`, `uv`, `buy_url`, `intro`, `info`, `has_custom`, `has_category`, `properties`, `has_property`, `is_fx`, `fx_type`, `cost_price`, `min_fx_price`, `max_fx_price`, `is_recommend`, `source_product_id`, `supplier_id`, `delivery_address_id`, `last_edit_time`, `original_product_id`, `sort`, `is_fx_setting`, `collect`, `attention_num`, `drp_profit`, `drp_seller_qty`, `drp_sale_qty`, `unified_price_setting`, `drp_level_1_price`, `drp_level_2_price`, `drp_level_3_price`, `drp_level_1_cost_price`, `drp_level_2_cost_price`, `drp_level_3_cost_price`, `is_hot`) VALUES ( '" . $_SESSION['user']['uid'] . "', '" . $store_id . "', '3', '" . $group_id . "', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');",
                "INSERT INTO  `" . $table_pigcms_product . "`  ( `uid`, `store_id`, `category_fid`, `category_id`, `group_id`, `name`, `sale_way`, `buy_way`, `type`, `quantity`, `price`, `original_price`, `weight`, `code`, `image`, `image_size`, `postage_type`, `postage`, `postage_template_id`, `buyer_quota`, `allow_discount`, `invoice`, `warranty`, `sold_time`, `sales`, `show_sku`, `status`, `date_added`, `soldout`, `pv`, `uv`, `buy_url`, `intro`, `info`, `has_custom`, `has_category`, `properties`, `has_property`, `is_fx`, `fx_type`, `cost_price`, `min_fx_price`, `max_fx_price`, `is_recommend`, `source_product_id`, `supplier_id`, `delivery_address_id`, `last_edit_time`, `original_product_id`, `sort`, `is_fx_setting`, `collect`, `attention_num`, `drp_profit`, `drp_seller_qty`, `drp_sale_qty`, `unified_price_setting`, `drp_level_1_price`, `drp_level_2_price`, `drp_level_3_price`, `drp_level_1_cost_price`, `drp_level_2_cost_price`, `drp_level_3_cost_price`, `is_hot`) VALUES ('" . $_SESSION['user']['uid'] . "', '" . $store_id . "', '3', '" . $group_id . "', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');",
                "INSERT INTO  `" . $table_pigcms_product . "`  (`uid`, `store_id`, `category_fid`, `category_id`, `group_id`, `name`, `sale_way`, `buy_way`, `type`, `quantity`, `price`, `original_price`, `weight`, `code`, `image`, `image_size`, `postage_type`, `postage`, `postage_template_id`, `buyer_quota`, `allow_discount`, `invoice`, `warranty`, `sold_time`, `sales`, `show_sku`, `status`, `date_added`, `soldout`, `pv`, `uv`, `buy_url`, `intro`, `info`, `has_custom`, `has_category`, `properties`, `has_property`, `is_fx`, `fx_type`, `cost_price`, `min_fx_price`, `max_fx_price`, `is_recommend`, `source_product_id`, `supplier_id`, `delivery_address_id`, `last_edit_time`, `original_product_id`, `sort`, `is_fx_setting`, `collect`, `attention_num`, `drp_profit`, `drp_seller_qty`, `drp_sale_qty`, `unified_price_setting`, `drp_level_1_price`, `drp_level_2_price`, `drp_level_3_price`, `drp_level_1_cost_price`, `drp_level_2_cost_price`, `drp_level_3_cost_price`, `is_hot`) VALUES ('" . $_SESSION['user']['uid'] . " ', '" . $store_id . "', '3', '" . $group_id . "', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');"
            );



            $goods_id_arr = array();
            for ($i = 0; $i < count($food_arr); $i++) {
                D('Product')->execute($food_arr[$i]);
                D('Product_to_group')->data(array('product_id' => D('Product')->lastInsID, 'group_id' => $group_id))->add();
                $goods_id_arr[] = D('Product')->lastInsID;
            }

            $wei_page_category_arr = array(
                "INSERT INTO  `" . $table_pigcms_wei_page_category . "`  ( `store_id`, `cat_name`, `first_sort`, `second_sort`, `show_style`, `cat_desc`, `page_count`, `has_custom`, `add_time`, `cover_img`, `uid`) VALUES ( '" . $store_id . "', '通用模板', '0', '0', '0', '<p>通用模板描述。</p>', '1', '0', '1438998819', '/upload/images/icon_03.png', '" . $_SESSION['user']['uid'] . "');",
                "INSERT INTO  `" . $table_pigcms_wei_page_category . "`  ( `store_id`, `cat_name`, `first_sort`, `second_sort`, `show_style`, `cat_desc`, `page_count`, `has_custom`, `add_time`, `cover_img`, `uid`) VALUES ( '" . $store_id . "', '餐饮外卖', '0', '0', '0', '<p>餐饮外卖描述。</p>', '1', '0', '1438998801', '/upload/images/icon_05.png', '" . $_SESSION['user']['uid'] . "');",
                "INSERT INTO  `" . $table_pigcms_wei_page_category . "`  ( `store_id`, `cat_name`, `first_sort`, `second_sort`, `show_style`, `cat_desc`, `page_count`, `has_custom`, `add_time`, `cover_img`, `uid`) VALUES ('" . $store_id . "', '食品电商', '0', '0', '0', '<p>食品电商描述</p>', '1', '0', '1438998781', '/upload/images/icon_07.png', '" . $_SESSION['user']['uid'] . "');",
                "INSERT INTO  `" . $table_pigcms_wei_page_category . "`  ( `store_id`, `cat_name`, `first_sort`, `second_sort`, `show_style`, `cat_desc`, `page_count`, `has_custom`, `add_time`, `cover_img`, `uid`) VALUES ( '" . $store_id . "', '美妆电商', '1', '0', '0', '<p>美妆电商描述。</p>', '1', '0', '1438998760', '/upload/images/icon_12.png', '" . $_SESSION['user']['uid'] . "');",
                "INSERT INTO  `" . $table_pigcms_wei_page_category . "`  ( `store_id`, `cat_name`, `first_sort`, `second_sort`, `show_style`, `cat_desc`, `page_count`, `has_custom`, `add_time`, `cover_img`, `uid`) VALUES ( '" . $store_id . "', '线下门店', '0', '0', '0', '<p>线下门店描述</p>', '1', '0', '1438998738', '/upload/images/icon_13.png', '" . $_SESSION['user']['uid'] . "');",
                "INSERT INTO  `" . $table_pigcms_wei_page_category . "`  ( `store_id`, `cat_name`, `first_sort`, `second_sort`, `show_style`, `cat_desc`, `page_count`, `has_custom`, `add_time`, `cover_img`, `uid`) VALUES ( '" . $store_id . "', '鲜花速递', '0', '0', '0', '<p>鲜花速递描述。</p>', '1', '0', '1438998718', '/upload/images/icon_14.png', '" . $_SESSION['user']['uid'] . "');",
            );

            $wei_page_arr = array(
                "INSERT INTO  `" . $table_pigcms_wei_page . "`  (`store_id`, `page_name`, `page_desc`, `bgcolor`, `is_home`, `add_time`, `product_count`, `hits`, `page_sort`, `has_category`, `has_custom`) VALUES ( '" . $store_id . "', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');",
                "INSERT INTO  `" . $table_pigcms_wei_page . "`  (`store_id`, `page_name`, `page_desc`, `bgcolor`, `is_home`, `add_time`, `product_count`, `hits`, `page_sort`, `has_category`, `has_custom`) VALUES ( '" . $store_id . "', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');",
                "INSERT INTO  `" . $table_pigcms_wei_page . "`  (`store_id`, `page_name`, `page_desc`, `bgcolor`, `is_home`, `add_time`, `product_count`, `hits`, `page_sort`, `has_category`, `has_custom`) VALUES ('" . $store_id . "', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');",
                "INSERT INTO  `" . $table_pigcms_wei_page . "`  (`store_id`, `page_name`, `page_desc`, `bgcolor`, `is_home`, `add_time`, `product_count`, `hits`, `page_sort`, `has_category`, `has_custom`) VALUES ('" . $store_id . "', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');",
                "INSERT INTO  `" . $table_pigcms_wei_page . "`  (`store_id`, `page_name`, `page_desc`, `bgcolor`, `is_home`, `add_time`, `product_count`, `hits`, `page_sort`, `has_category`, `has_custom`) VALUES ('" . $store_id . "', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');",
                "INSERT INTO  `" . $table_pigcms_wei_page . "`  (`store_id`, `page_name`, `page_desc`, `bgcolor`, `is_home`, `add_time`, `product_count`, `hits`, `page_sort`, `has_category`, `has_custom`) VALUES ('" . $store_id . "', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');",
            );

            $custom_field_arr = array(
                array(
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  ( `store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  ( `store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page', 'search', 'a:0:{}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  ( `store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[0]) . ":\"" . $goods_id_arr[0] . "\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[1]) . ":\"" . $goods_id_arr[1] . "\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[2]) . ":\"" . $goods_id_arr[2] . "\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');",
                ),
                array("INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page', 'search', 'a:0:{}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:" . strlen($group_id) . ":\"" . $group_id . "\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
"),
                array(
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page',  'search', 'a:0:{}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page',  'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page',  'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[0]) . ":\"" . $goods_id_arr[0] . "\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[1]) . ":\"" . $goods_id_arr[1] . "\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[2]) . ":\"" . $goods_id_arr[2] . "\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page', '548', 'store', 'a:0:{}');)"
                ),
                array(
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page', 'search', 'a:0:{}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page',  'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[0]) . ":\"" . $goods_id_arr[0] . "\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[1]) . ":\"" . $goods_id_arr[1] . "\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[2]) . ":\"" . $goods_id_arr[2] . "\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');",
                ),
                array(
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page',  'search', 'a:0:{}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page',  'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[0]) . ":\"" . $goods_id_arr[0] . "\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[1]) . ":\"" . $goods_id_arr[1] . "\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[2]) . ":\"" . $goods_id_arr[2] . "\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');",
                ),
                array(
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page',  'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page',  'search', 'a:0:{}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ( '" . $store_id . "', 'page',  'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', 'page',  'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[0]) . ":\"" . $goods_id_arr[0] . "\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[1]) . ":\"" . $goods_id_arr[1] . "\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:" . strlen($goods_id_arr[2]) . ":\"" . $goods_id_arr[2] . "\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";" . $this->url_formark('/wap/good.php?id=', $goods_id_arr) . "s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');",
                    "INSERT INTO  `" . $table_pigcms_custom_field . "`  (`store_id`, `module_name`, `field_type`, `content`) VALUES ('" . $store_id . "', '567', 'page', 'store', 'a:0:{}');",
                ),
            );

            for ($i = 0; $i < count($wei_page_category_arr); $i++) {
                D('Wei_page_category')->execute($wei_page_category_arr[$i]);
                D('Wei_page')->execute($wei_page_arr[$i]);
                $page_id = D('Wei_page')->lastInsID;
                D('Wei_page_category')->where(array('cat_id' => D('Wei_page_category')->lastInsID))->data(array('page_id' => $page_id))->save();

                $arr = array();
                foreach ($custom_field_arr[$i] as $v) {
                    D('Custom_field')->execute($v);
                    array_push($arr, D('Custom_field')->lastInsID);
                }
                $wheres["field_id"] = array("in", $arr);
                D('Custom_field')->where($wheres)->data(array('module_id' => $page_id))->save();
            }
        }
        $this->assign('avatar', $avatar);
        $this->assign('create_store_status', $create_store_status);
        $this->display();
    }

    public function url_formark($url, $goodsArr) {

        $link = '';
        $domain = option('config.site_url');
        $goods_id = array_rand(array_flip($goodsArr));

        $link = $domain . $url . $goods_id;
        $leng = strlen($link);

        $str = 's:' . $leng . ':\"' . $link . '\";';

        return $str;
    }

    private function _select_content() {
        $user = M('User');
        $create_store_status = true;
        $user = $user->getUserById($this->user_session['uid']);
        if (option('config.user_store_num_limit')) {
            $store_num = $user['stores']; //当前店铺数量
            if ($store_num >= option('config.user_store_num_limit')) {
                $create_store_status = false;
            }
        }

        $company = M('Company')->getCompanyByUid($this->user_session['uid']);
        $store_return = M('Store')->getStoresByUid($this->user_session['uid'], 2);

        $store_id_arr = array();
        foreach ($store_return['store_list'] as $v) {
            $store_id_arr[] = $v['store_id'];
        }
        $Map['store_id'] = array('in', $store_id_arr);
        $store_cate_list = D('Wei_page_category')->where($Map)->select('store_id');

        $newstore_cate_list = array();
        foreach ($store_cate_list as $k => $v) {
            $newstore_cate_list[$v['store_id']] = $v;
        }
        $wei_page_list = D('Wei_page')->where($Map)->select();
        $new_wei_page_list = array();
        foreach ($wei_page_list as $v) {
            $new_wei_page_list[$v['store_id']] = $v;
        }

        $cate_info = D('Wei_page_category')->order('cat_id desc')->find();

        $this->assign('create_store_status', $create_store_status);
        $this->assign('company', $company);
        $this->assign('store_return', $store_return);
        $this->assign('newstore_cate_list', $newstore_cate_list);
        $this->assign('new_wei_page_list', $new_wei_page_list);
        $this->assign('cate_info', $cate_info);
    }

    //选择店铺
    public function store_select() {
        if (empty($_GET['store_id']))
            pigcms_tips('非法访问！');
        $store = M('Store')->getStoreById($_GET['store_id'], $this->user_session ['uid']);
        if ($store) {
            $_SESSION['tmp_store_id'] = $store['store_id'];
            if (empty($store['logo']))
                $store['logo'] = 'default_shop_2.jpg';
            $_SESSION['store'] = $store;
            redirect(url('store:index'));
        }else {
            pigcms_tips('该店铺不存在！');
        }
    }

    //删除店铺
    public function store_delete() {


        $result = M('Store')->change_status($_POST['store_id'], $this->user_session['uid'], 4);
        if (empty($result['err_code'])) {
            //店铺数减1
            M('User')->setStoreDec($this->user_session['uid']);
            //主营类目店铺数减1
            $store = M('Store')->getStore($_POST['store_id']);
            M('Sale_category')->setStoreDec($store['sale_category_id']);
            M('Sale_category')->setStoreDec($store['sale_category_fid']);
        }
        json_return($result['err_code'], $result['err_msg']);
    }

    //店铺重新开启
    public function store_open() {
        $store_id = intval(trim($_POST['store_id']));
        $result = M('Store')->change_status($store_id, $this->user_session['uid'], 1);
        if (empty($result['err_code'])) {
            //店铺数减1
            M('User')->setStoreDec($this->user_session['uid']);
            //主营类目店铺数减1
            $store = M('Store')->getStore($store_id);
            M('Sale_category')->setStoreDec($store['sale_category_id']);
            M('Sale_category')->setStoreDec($store['sale_category_fid']);

            $_SESSION['store'] = $store;
            $_SESSION['tmp_store_id'] = $store_id;
            $result['err_msg'] = option('config.site_url') . '/user.php?c=store&a=index';
        }
        json_return($result['err_code'], $result['err_msg']);
    }

    //设置店铺
    public function setting() {
        if (IS_POST) {
            $store = M('Store');

            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            if (isset($_POST['logo'])) {
                $logo = str_replace(array(option('config.site_url') . '/upload/images/', './upload/images/'), '', trim($_POST['logo']));
            } else {
                $logo = '';
            }

            $intro = isset($_POST['intro']) ? trim($_POST['intro']) : '';
            $linkman = isset($_POST['linkman']) ? trim($_POST['linkman']) : '';
            $qq = isset($_POST['qq']) ? trim($_POST['qq']) : '';

            $data = array();
            if ($name)
                $data['name'] = $name;
            if ($logo)
                $data['logo'] = $logo;
            $data['intro'] = $intro;
            $data['linkman'] = $linkman;
            $data['qq'] = $qq;

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $store->setting($where, $data);
            json_return(0, '店铺配置成功');
        }

        $this->display();
    }

    //微页面/杂志页更改：店铺logo
    public function update_store_logo() {
        if (IS_POST) {
            $store = M('Store');

            if (isset($_POST['store_logo'])) {
                $logo = getAttachment($_POST['store_logo']);
            } else {
                $logo = '';
            }
            $data = array();
            if ($logo) {
                $data['logo'] = $logo;
                $where = array();
                $where['store_id'] = $this->store_session['store_id'];

                $store->setting($where, $data);
                //替换session
                $_SESSION['store']['logo'] = getAttachmentUrl($logo);

                json_return(0, '修改店铺logo成功！');
            }
        }
    }

    //店铺导航
    public function storenav() {
        $nav = M('Store_nav');
        $store = M('Store');

        if (IS_POST) {
            $use_nav_pages = isset($_POST['use_nav_pages']) ? $_POST['use_nav_pages'] : array();
            $style_id = isset($_POST['style_id']) ? intval(trim($_POST['style_id'])) : 1; //样式 默认样式一
            $bgcolor = isset($_POST['bgcolor']) ? trim($_POST['bgcolor']) : '';
            $store_id = $this->store_session['store_id'];
            $nav_menus = isset($_POST['nav_menus']) ? $_POST['nav_menus'] : array();
            $date_added = time();
            if (!empty($nav_menus)) {
                //递归去除空的数组下标
                foreach ($nav_menus as $key => $value) {
                    foreach ($value as $k => $v) {
                        if ($k == 'submenu') {
                            foreach ($v as $j => $jv) {
                                foreach ($jv as $l => $lv) {
                                    if (empty($lv)) {
                                        unset($nav_menus[$key][$k][$j][$l]);
                                    }
                                }
                            }
                        } else if (empty($v)) {
                            unset($nav_menus[$key][$k]);
                        }
                    }
                }
                $nav_menus = serialize($nav_menus);
            }

            $store->setUseNavPage($store_id, implode(',', $use_nav_pages));

            $nav_info = $nav->getStoreNav($store_id);
            if (empty($nav_info)) {
                $result = $nav->add(array('store_id' => $store_id, 'style' => $style_id, 'bgcolor' => $bgcolor, 'data' => $nav_menus, 'date_added' => $date_added));
            } else {
                $result = $nav->edit(array('store_id' => $store_id), array('style' => $style_id, 'bgcolor' => $bgcolor, 'data' => $nav_menus, 'date_added' => $date_added));
            }

            if ($result) {
                json_return(0, '保存成功');
            } else {
                json_return(1001, '保存失败');
            }
        }

        parent::checkDrp();
        $this->display();
    }

    //开启/关闭店铺导航
    public function open_nav() {
        $store = M('Store');

        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = $store->openNav($this->store_session['store_id'], $status);
        if ($result) {
            echo true;
        } else {
            echo false;
        }
        exit;
    }

    //首页详细
    private function _index_content() {
        $product = M('Product');
        $wei_page = M('Wei_page');
        $store_analytics = M('Store_analytics');

        $date = date('Y-m-d', strtotime('-1 day'));
        $start_time = $date . ' 00:00:00';
        $end_time = $date . ' 23:59:59';
        $where = array();
        //昨日浏览pv
        $where['store_id'] = $this->store_session['store_id'];
        $where['_string'] = "visited_time >= '" . strtotime($start_time) . "' AND visited_time <= '" . strtotime($end_time) . "'";
        $store_pv_yesterday = $store_analytics->getTotal($where);
        //昨日浏览uv
        $store_uv_yesterday = $store_analytics->getTotal($where, true);
        //昨日到店pv
        $where['module'] = 'goods';
        $goods_pv_yesterday = $store_analytics->getTotal($where);
        //昨日到店uv
        $goods_uv_yesterday = $store_analytics->getTotal($where, true);

        $days = array();
        for ($i = 7; $i >= 1; $i--) {
            $day = date("Y-m-d ", strtotime('-' . $i . 'day'));
            $days[] = $day;
        }

        $days_7_pv = array();
        $days_7_uv = array();
        $days_7_goods_pv = array();
        $days_7_goods_uv = array();
        $tmp_days = array();
        foreach ($days as $day) {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $end_time = strtotime($day . ' 23:59:59');
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['_string'] = "visited_time >= '" . $start_time . "' AND visited_time <= '" . $end_time . "'";
            $days_7_pv[] = $store_analytics->getTotal($where);

            $days_7_uv[] = $store_analytics->getTotal($where, true);

            $where['module'] = 'goods';
            $days_7_goods_pv[] = $store_analytics->getTotal($where);

            $days_7_goods_uv[] = $store_analytics->getTotal($where, true);

            $tmp_days[] = "'" . $day . "'";
        }
        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_pv = '[' . implode(',', $days_7_pv) . ']';
        $days_7_uv = '[' . implode(',', $days_7_uv) . ']';
        $days_7_goods_pv = '[' . implode(',', $days_7_goods_pv) . ']';
        $days_7_goods_uv = '[' . implode(',', $days_7_goods_uv) . ']';

        $start_time = date('Y-m-d', strtotime('-7 day')) . ' 00:00:00';
        $end_time = date('Y-m-d', strtotime('-1 day')) . ' 23:59:59';
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['_string'] = "visited_time >= '" . strtotime($start_time) . "' AND visited_time <= '" . strtotime($end_time) . "'";
        $analytics = $store_analytics->getList($where);
        $this->assign('analytics', $analytics);

        //商品数量
        $product_total = $product->getTotalByStoreId($this->store_session['store_id']);
        $this->assign('product_total', $product_total);

        //微页面数量
        $wei_page_total = $wei_page->get_wei_page_total($this->store_session['store_id']);

        $store = M('Store');
        $store = $store->getStore($this->store_session['store_id']);
        $_SESSION['store']['approve'] = $store['approve'];
        $this->assign('store_session', $_SESSION['store']);

        $this->assign('wei_page_total', $wei_page_total);
        $this->assign('store_pv_yesterday', $store_pv_yesterday);
        $this->assign('store_uv_yesterday', $store_uv_yesterday);
        $this->assign('goods_pv_yesterday', $goods_pv_yesterday);
        $this->assign('goods_uv_yesterday', $goods_uv_yesterday);
        $this->assign('days', $days);
        $this->assign('days_7_pv', $days_7_pv);
        $this->assign('days_7_uv', $days_7_uv);
        $this->assign('days_7_goods_pv', $days_7_goods_pv);
        $this->assign('days_7_goods_uv', $days_7_goods_uv);
    }

    //店铺详细
    private function _setting_content() {
        $company = M('Company');
        $database_store = M('Store');

        $company = $company->getCompanyByUid($_SESSION['user']['uid']);

        //店铺主营类目
        $sale_category = $database_store->getSaleCategory($this->store_session['store_id'], $_SESSION['user']['uid']);
        $store = $database_store->getStoreById($this->store_session['store_id'], $_SESSION['user']['uid']);
        $this->assign('company', $company);
        $this->assign('store', $store);
        $this->assign('sale_category', $sale_category);
    }

    //店铺导航
    private function _storenav_content() {
        $store = M('Store');
        $nav = M('Store_nav');

        $store = $store->getStoreById($this->store_session['store_id'], $this->user_session['uid']);

        $nav = $nav->getStoreNav($this->store_session['store_id']);

        $use_nav_pages = $store['use_nav_pages'];
        if (!empty($use_nav_pages)) {
            $use_nav_pages = explode(',', $use_nav_pages);
        } else {
            $use_nav_pages = array();
        }
        $this->assign('use_nav_pages', $use_nav_pages);
        if (!empty($nav['data'])) {
            $this->assign('nav_menus', unserialize($nav['data']));
        }
        $style_id = !empty($nav['style']) ? $nav['style'] : 1;
        if ($style_id == 1) {
            $this->assign('style', '微信公众号自定义菜单样式');
        } else if ($style_id == 2) {
            $this->assign('style', 'APP导航模板');
        } else if ($style_id == 3) {
            $this->assign('style', '带购物车导航模板');
        }
        //菜单数量限制
        $shopnav_limit[1] = 3;
        $shopnav_limit[2] = 5;
        $shopnav_limit[3] = 4;

        $this->assign('shopnav_limit', $shopnav_limit);
        $this->assign('style_id', $style_id);
        $this->assign('nav', $nav);
        $this->assign('store', $store);

        parent::checkDrp();
        if (!empty($this->store_session['drp_supplier_id']) && empty($this->store_session['drp_level'])) {
            $this->assign('allow_store_drp', false);
        }
    }

    //店铺导航url选择-微页面
    private function _storenav_wei_page() {
        $wei_page = M('Wei_page');
        $wei_pages = $wei_page->get_list($this->store_session['store_id'], 8);
        $this->assign('wei_pages', $wei_pages['page_list']);
        $this->assign('page', $wei_pages['page']);
    }

    //店铺导航url选择-微页面
    private function _storenav_wei_page_category() {
        $wei_page_category = M('Wei_page_category');
        $wei_page_categories = $wei_page_category->get_list($this->store_session['store_id']);
        $this->assign('wei_page_categories', $wei_page_categories['cat_list'], 8);
        $this->assign('page', $wei_page_categories['page']);
    }

    //店铺导航url选择-商品
    private function _storenav_goods() {
        $product = M('Product');
        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
        $product_total = $product->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 8);
        $products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);

        $this->assign('products', $products);
        $this->assign('page', $page->show());
    }

    //店铺导航url选择-商品分类
    private function _storenav_goods_group() {
        $product_group = M('Product_group');
        $where = array();
        $product_groups = $product_group->get_list($this->store_session['store_id'], 8);

        $this->assign('product_groups', $product_groups['group_list']);
        $this->assign('page', $product_groups['page']);
    }

    //店铺名称唯一性检测
    public function store_name_check() {
        $store = M('Store');

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $unique = $store->getUniqueName($name);
        echo $unique;
        exit;
    }

    //开店协议
    public function readme() {
        $this->assign('readme_title', option('config.readme_title'));
        $this->assign('readme_content', option('config.readme_content'));
        $this->display();
    }

    public function service() {
        $this->display();
    }

    //客服列表
    public function _service_list() {
        $group_list = array();
        $where = "openid!='' AND store_id = {$_SESSION['store']['store_id']}";
        $group_list['service_list'] = D('Service')->where($where)->order('service_id DESC')->select();
        $this->assign('group_list', $group_list);
    }

    //客服信息编辑
    public function _service_edit() {
        $service_id = intval($_POST['service_id']);
        $where = "store_id = {$_SESSION['store']['store_id']} AND service_id = $service_id";

        $info = D('Service')->where($where)->order('service_id ASC')->find();
        $this->assign('info', $info);
    }

    public function _business_hours_list() {
        $where['store_id'] = $_SESSION['store']['store_id'];
        $list = M('Business_hour')->getAllList($where);
//        $store_arr = array();
//        foreach ($list['page_list'] as $v) {
//            $store_arr[] = $v['store_id'];
//        }
//        if ($store_arr) {
//            $where['store_id'] = array('in', $store_arr);
//            $store_list = M('Store')->getlist($where);
//
//            $new_store_list = array();
//            foreach ($store_list as $v) {
//                $new_store_list[$v['store_id']] = $v;
//            }
//            unset($store_list);
//            $this->assign('store_list', $new_store_list);
//        }
        $this->assign('list', $list);
    }

    //执行修改
    public function edit_service() {
        $store_id = $_SESSION['store']['store_id'];
        $where = "store_id = $store_id AND service_id = " . intval($_POST['service_id']);
        $_POST['status'] = 1;
        if (D('Service')->where($where)->data($_POST)->save()) {
            $this->syn_service($store_id);
            json_return(0, '修改成功');
        }
    }

    //删除客服
    public function del_service() {
        $store_id = $_SESSION['store']['store_id'];
        $service_id = intval($_POST['sid']);
        $where = "store_id = $store_id AND service_id = " . $service_id;

        if (D('Service')->where($where)->delete()) {
            $this->syn_service($store_id);
            json_return(0, '删除成功');
        }
    }

    //同步客服
    public function syn_service($store_id) {

        $url = IM_SERVER_PATH . '/api/app_service.php';
        $skey = get_encrypt_key(array('app_id' => option('config.im_appid')), option('config.im_appkey'));
        $where = "store_id = $store_id and status = 1";
        $data = D('Service')->where($where)->field('openid,nickname,avatar,intro')->select();

        $post_data = array();
        foreach ($data as $key => $val) {
            $post_data[$key]['openid'] = "{$val['openid']}";
            $post_data[$key]['nickname'] = "{$val['nickname']}";
            $post_data[$key]['desc'] = "{$val['intro']}";
            $post_data[$key]['avatar'] = "{$val['avatar']}";
        }

        curl_post($url, array('app_id' => option('config.im_appid'), 'label' => $store_id, 'key' => $skey, 'data' => $post_data));
    }

    //绑定客服二维码
    public function bind_qrcode() {
        $qrcode_id = $_SESSION['store']['store_id'] + 290000000;
        $qrcode_return = M('Recognition')->get_tmp_qrcode($qrcode_id);
        if ($qrcode_return['error_code']) {
            echo '<html><head></head><body>' . $qrcode_return['msg'] . '<br/><br/><font color="red">请关闭此窗口再打开重试。</font></body></html>';
        } else {
            $this->assign($qrcode_return);
            $this->display();
        }
    }

    public function select_template() {

        if (IS_POST) {
            $cat_id = $_REQUEST['cat_id'] + 0;
            $store_id = $_REQUEST['store_id'] + 0;
            $page_id = $_REQUEST['page_id'] + 0;
            $new_page_id = $_REQUEST['new_page_id'] + 0;

            if (!$page_id) {

                json_return(0, '未设置默认模板！');
            }

            if (!$cat_id || !$store_id) {

                json_return(0, '数据传递有误！');
            }

            $wei_page_cate_info = D('Wei_page_category')->where(array('cat_id' => $cat_id))->find();
            unset($wei_page_cate_info['cat_id']);
            $wei_page_cate_info['uid'] = $_SESSION['user']['uid'];
            $wei_page_cate_info['store_id'] = $store_id;
            D('Wei_page_category')->data($wei_page_cate_info)->add();

            if (D('Store')->where(array('store_id' => $store_id))->data(array('template_cat_id' => $cat_id, 'template_id' => $page_id))->save()) {
                $cate_info = D('Wei_page_category')->where(array('cat_id' => $cat_id))->find();
                $replace_info = D('Wei_page')->where(array('store_id' => $cate_info['store_id'], 'page_id' => $page_id))->find();
                unset($replace_info['page_id']);
                unset($replace_info['store_id']);
                unset($replace_info['is_home']);
                D('Wei_page')->where(array('is_home' => 1, 'store_id' => $store_id))->data($replace_info)->save();

                $field_list1 = M('Custom_field')->get_field($cate_info['store_id'], 'page', $page_id);
                $field_list2 = M('Custom_field')->get_field($cate_info['store_id'], 'page_cat', $cat_id);
                $field_list = array_merge($field_list1, $field_list2);
                if (!empty($field_list)) {
                    $data_fields = array();
                    foreach ($field_list as $key => $field) {
                        switch ($field['field_type']) {
                            case 'title': //标 题
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'tpl_shop': //抬头1
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'tpl_shop1': //抬头2
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'rich_text': //富文本
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'notice': //公告
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'line': //辅助线
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'white': //辅助空白
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'search': //商品搜索
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'store': //进入店铺
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'text_nav': //文本导航
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = array();

                                $text_navs = array();
                                foreach ($field['content'] as $nav) {
                                    $text_navs[] = array(
                                        'title' => $nav['title'],
                                        'name' => htmlspecialchars($nav['name'], ENT_QUOTES),
                                        'prefix' => $nav['prefix'],
                                        'url' => $nav['url']
                                    );
                                }
                                $data_fields[$key]['content'] = serialize($text_navs);
                                break;
                            case 'image_nav': //图片导航
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = array();

                                $image_navs = array();
                                foreach ($field['content'] as $nav) {
                                    $image_navs[] = array(
                                        'title' => $nav['title'],
                                        'name' => htmlspecialchars($nav['name'], ENT_QUOTES),
                                        'prefix' => $nav['prefix'],
                                        'url' => $nav['url'],
                                        'image' => $nav['image']
                                    );
                                }
                                $data_fields[$key]['content'] = serialize($image_navs);
                                break;
                            case 'link': //关联链接
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = array();

                                $links = array();
                                foreach ($field['content'] as $link) {
                                    
                                }
                                $data_fields[$key]['content'] = serialize($links);
                                break;
                            case 'image_ad': //图片广告
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = array();

                                $image_ads = array();
                                $image_ads['max_height'] = $field['content']['max_height'];
                                $image_ads['max_width'] = $field['content']['max_width'];
                                $image_ads['nav_list'] = array();
                                foreach ($field['content']['nav_list'] as $nav) {

                                    $image_ads['nav_list'][] = $nav;
                                }
                                $data_fields[$key]['content'] = serialize($image_ads);
                                break;
                            case 'goods': //商品
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = array();

                                $content = array();
                                $content['size'] = $field['content']['size']; //大小
                                $content['buy_btn'] = $field['content']['buy_btn']; //是否显示购买按钮
                                $content['buy_btn_type'] = $field['content']['buy_btn_type']; //购买按钮样式
                                $content['price'] = $field['content']['price']; //是否显示价格
                                $content['goods'] = $field['content']['goods'];

                                $data_fields[$key]['content'] = serialize($content);
                                break;
                            case 'component': //自定义模块
                                //暂不支持
                                break;
                            case 'coupons':
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;
                            case 'goods_group1':
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = serialize($field['content']);
                                break;

                            case 'goods_group2': //商品
                                $data_fields[$key]['store_id'] = $store_id;
                                $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                $data_fields[$key]['module_id'] = $new_page_id;
                                $data_fields[$key]['field_type'] = $field['field_type'];
                                $data_fields[$key]['content'] = array();

                                $content = array();
                                $content['size'] = $field['content']['size']; //大小
                                $content['buy_btn'] = $field['content']['buy_btn']; //是否显示购买按钮
                                $content['buy_btn_type'] = $field['content']['buy_btn_type']; //购买按钮样式
                                $content['price'] = $field['content']['price']; //是否显示价格
                                $content['goods'] = $field['content']['goods'];

                                $data_fields[$key]['content'] = serialize($content);
                                break;
                        }
                    }
                    $result = false;
                    if (!empty($data_fields)) {
                        D('Custom_field')->where(array('store_id' => $store_id))->delete();
                        $result = D('Custom_field')->data($data_fields)->addAll();
                    }
                    $data_fields = array();
                    //公共广告（仅支持图片广告）
                    $ad_list = M('Custom_field')->get_field($store_id, 'common_ad', $store_id);
                    if (!empty($ad_list)) {
                        foreach ($ad_list as $key => $field) {
                            switch ($field['field_type']) {
                                case 'image_ad':
                                    $data_fields[$key]['store_id'] = $store_id;
                                    $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                                    $data_fields[$key]['module_id'] = $store_id;
                                    $data_fields[$key]['field_type'] = $field['field_type'];
                                    $data_fields[$key]['content'] = array();

                                    $image_ads = array();
                                    $image_ads['max_height'] = $field['content']['max_height'];
                                    $image_ads['max_width'] = $field['content']['max_width'];
                                    $image_ads['nav_list'] = array();
                                    foreach ($field['content']['nav_list'] as $nav) {
                                        $nav['name'] = htmlspecialchars($nav['name'], ENT_QUOTES);

                                        $image_ads['nav_list'][] = $nav;
                                    }
                                    $data_fields[$key]['content'] = serialize($image_ads);
                                    break;
                            }
                        }
                        if (!empty($data_fields)) {
                            if (D('Custom_field')->data($data_fields)->addAll()) {
                                D('Store')->where(array('store_id' => $store_id))->data(array('open_ad' => 1, 'use_ad_pages' => $supplier['use_ad_pages']))->save();
                            }
                        }
                    }
                }

                return $result;
            }
            json_return(1, '添加成功！');
        } else {
            $admin_info = D('Admin')->find();
            $where['nickname'] = $admin_info['account'];
            $where['password'] = $admin_info['pwd'];
            $admin_info = D('User')->where($where)->find();
            $Map['uid'] = $admin_info['uid'];
            $store = D('Store')->where($Map)->find();

            $offical_list = D('Wei_page_category')->where(array('store_id' => $store['store_id']))->order('add_time asc')->select();
            $this->assign('cate_list', $offical_list);
            $this->display();
        }
    }

    //营业时间
    public function business_hours() {
        $this->display();
    }

    public function business_hours_add() {
        $data['store_id'] = $_SESSION['store']['store_id'];
        $data['business_time'] = $_POST['bus_val_str'];
        $result = M('Business_hour')->business_hour_add($data);
        json_return($result['err_code'], $result['info']);
    }

    //创建营业时间
    public function _business_hours_create() {
        $where['store_id'] = $_SESSION['store']['store_id'];
        $where['is_open'] = 1;
        $list = D('Business_hour')->where($where)->field('business_time')->select();
        foreach ($list as $k => $v) {
            $bus_time_arr = explode('-', $v['business_time']);
            $list[$k]['start_time'] = reset($bus_time_arr);
            $list[$k]['end_time'] = end($bus_time_arr);
            unset($list[$k]['business_time']);
        }
        $this->assign('time_list', $list);
    }

    //修改营业时间
    public function _edit_business_hours() {
        $id = $_POST['id'] + 0;
        $where['id'] = $id;
        $info = D('Business_hour')->where($where)->find();
        $info['start_time'] = reset(explode('-', $info['business_time']));
        $info['end_time'] = end(explode('-', $info['business_time']));
        $this->assign('info', $info);
    }

    public function edit_business_hours_act() {
        $id = $_POST['id'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        if (!$id || !$start_time || !$end_time) {
            json_return(1, '传递参数有误！');
        }

        $where['id'] = $id;
        $data['business_time'] = $start_time . '-' . $end_time;
        $result = M('Business_hour')->business_hour_edit($where, $data);
        json_return($result['err_code'], $result['err_msg']);
    }

    //删除营业时间
    public function del_business_hours() {
        $id = $_POST['sid'] + 0;
        if (!$id) {
            json_return(1, '传递参数有误！');
        }

        $where['id'] = $id;
        $result = D('Business_hour')->where($where)->delete();
        if ($result) {
            json_return(0, '删除成功！');
        } else {
            json_return(1, '删除失败！');
        }
    }

    //修改状态
    public function status_business_hours() {
        $sid = $_POST['sid'] + 0;
        if (!$sid) {
            json_return(1, '传递参数有误！');
        }
        $where['id'] = $sid;
        $result = M('Business_hour')->edit_status($where);
        json_return($result['err_code'], $result['err_msg']);
    }

}

?>