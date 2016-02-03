<?php

/*
 * 后台管理基础类
 *
 * @  Writers    Jaty
 * @  BuildTime  2014/11/05 15:28
 * 
 */

class IndexAction extends BaseAction {

    public function index() {
        $database_system_menu = D('System_menu');
        $condition_system_menu['status'] = 1;
        $condition_system_menu['show'] = 1;
        $menu_list = $database_system_menu->field(true)->where($condition_system_menu)->order('`sort` DESC,`fid` ASC,`id` ASC')->select();
        foreach ($menu_list as $key => $value) {
            if ($value['fid'] == 0) {
                $system_menu[$value['id']] = $value;
            } else {
                $system_menu[$value['fid']]['menu_list'][] = $value;
            }
        }
        $this->assign('system_menu', $system_menu);
        $this->display();
    }

    public function main() {
        $server_info = array(
            '运行环境' => PHP_OS . ' ' . $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            'MYSQL版本' => mysql_get_client_info(),
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . '秒',
            '磁盘剩余空间 ' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        );
        $this->assign('server_info', $server_info);

        //用户总数
        $user = M('User');
        $website_user_count = $user->count('uid');
        //商户总数
        $website_merchant_count = $user->where(array('is_seller' => 1))->count('uid');
        //店铺总数
        $store = M('Store');
        $website_merchant_store_count = $store->count('store_id');
        //订单总数
        $order = M('Order');
        $website_merchant_order_count = $order->count('order_id');
        //商品数
        $product = M('Product');
        $website_merchant_goods_count = $product->count('product_id');
        //昨日新增用户
        $where = array();
        $date = date('Y-m-d', strtotime('-1 day'));
        $start_time = $date . ' 00:00:00';
        $end_time = $date . ' 23:59:59';
        $where['_string'] = "reg_time >= '" . strtotime($start_time) . "' AND reg_time <= '" . strtotime($end_time) . "'";
        $yesterday_add_user_count = $user->where($where)->count('uid');
        //昨日新增店铺
        $where = array();
        $where['_string'] = "date_added >= '" . strtotime($start_time) . "' AND date_added <= '" . strtotime($end_time) . "'";
        $yesterday_add_store_count = $user->where($where)->count('uid');
        //未付款订单
        $not_paid_order_count = $order->where(array('status' => 1))->count('order_id');
        //未发货订单
        $not_send_order_count = $order->where(array('status' => 2))->count('order_id');
        //已发货订单
        $send_order_count = $order->where(array('status' => 3))->count('order_id');
        //昨日新增订单
        $where = array();
        $where['_string'] = "add_time >= '" . strtotime($start_time) . "' AND add_time <= '" . strtotime($end_time) . "'";
        $yesterday_ordered_count = $order->where($where)->count('order_id');
        //上架商品
        $selling_product_count = $product->where(array('status' => 1))->count('product_id');
        //昨日新增商品
        $where = array();
        $where['_string'] = "date_added >= '" . strtotime($start_time) . "' AND date_added <= '" . strtotime($end_time) . "'";
        $yesterday_add_product_count = $product->where($where)->count('product_id');

        $this->assign('website_user_count', $website_user_count);
        $this->assign('website_merchant_count', $website_merchant_count);
        $this->assign('website_merchant_store_count', $website_merchant_store_count);
        $this->assign('website_merchant_order_count', $website_merchant_order_count);
        $this->assign('website_merchant_goods_count', $website_merchant_goods_count);
        $this->assign('yesterday_add_user_count', $yesterday_add_user_count);
        $this->assign('yesterday_add_store_count', $yesterday_add_store_count);
        $this->assign('not_paid_order_count', $not_paid_order_count);
        $this->assign('not_send_order_count', $not_send_order_count);
        $this->assign('send_order_count', $send_order_count);
        $this->assign('yesterday_ordered_count', $yesterday_ordered_count);
        $this->assign('selling_product_count', $selling_product_count);
        $this->assign('yesterday_add_product_count', $yesterday_add_product_count);
        $this->display();
    }

    public function pass() {
        $this->display();
    }

    public function amend_pass() {
        $old_pass = $this->_post('old_pass');
        $new_pass = $this->_post('new_pass');
        $re_pass = $this->_post('re_pass');
        if ($old_pass == '') {
            $this->error('请填写旧密码！');
        } else if ($new_pass != $re_pass) {
            $this->error('两次新密码填写不一致！');
        } else if ($old_pass == $new_pass) {
            $this->error('新旧密码不能一样！');
        }

        $database_admin = D('Admin');
        $condition_admin['id'] = $this->system_session['id'];
        $admin = $database_admin->field('`id`,`pwd`')->where($condition_admin)->find();
        if ($admin['pwd'] != md5($old_pass)) {
            $this->error('旧密码错误！');
        } else {
            $data_admin['id'] = $admin['id'];
            $data_admin['pwd'] = md5($new_pass);
            if ($database_admin->data($data_admin)->save()) {
                $this->success('密码修改成功！');
            } else {
                $this->error('密码修改失败！请重试。');
            }
        }
    }

    public function profile() {
        $database_admin = D('Admin');
        $condition_admin['id'] = $this->system_session['id'];
        $admin = $database_admin->where($condition_admin)->find();
        $this->assign('admin', $admin);
        $this->display();
    }

    public function amend_profile() {
        $database_admin = D('Admin');
        $data_admin['id'] = $this->system_session['id'];
        $data_admin['realname'] = $this->_post('realname');
        $data_admin['email'] = $this->_post('email');
        $data_admin['qq'] = $this->_post('qq');
        $data_admin['phone'] = $this->_post('phone');
        if ($database_admin->data($data_admin)->save()) {
            $this->success('资料修改成功！');
        } else {
            $this->error('资料修改失败！请检查是否有修改内容后再重试。');
        }
    }

    public function cache() {
        import('ORG.Util.Dir');
        Dir::delDirnotself('./cache');
        $this->frame_main_ok_tips('清除缓存成功！');
    }

    public function offical_tore() {
        if (!$_SESSION['system']) {
            $this->error('帐户未登陆，请重新登陆！');
        }

        $data['nickname'] = $_SESSION['system']['account'];
        $data['password'] = $_SESSION['system']['pwd'];
        $data['phone'] = $_SESSION['system']['phone'];

        $admin_info = D('Admin')->find();
        $where['admin_id'] = $admin_info['id'];
        // $where['password'] = md5($data['nickname']);
        //$where['phone'] = $data['phone'];
        $offical_store_user = D('User')->where($where)->find();
        if (!$offical_store_user) {
            $data['admin_id'] = $_SESSION['system']['id'];
            $result = D('User')->add_user($data);
            if (!$result) {
                $_SESSION['user'] = $result['err_msg'];
            }
        } else {
            if ($offical_store_user['password'] != $data['password']) {
                D('User')->where($where)->data(array('password' => $data['password']))->save();
            }
            $_SESSION['user'] = $offical_store_user;
        }
        setcookie('session', serialize($_SESSION), $_SERVER['REQUEST_TIME'] + 10000000, '/');
        redirect('/user.php?c=store&a=select');
    }

}