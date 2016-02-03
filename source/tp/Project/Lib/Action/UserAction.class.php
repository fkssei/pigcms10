<?php

/*
 * 用户中心
 *
 * @  Writers    Jaty
 * @  BuildTime  2014/12/29 10:25
 * 
 */

class UserAction extends BaseAction {

    public function index() {

        //搜索
        if (!empty($_GET['keyword'])) {
            if ($_GET['searchtype'] == 'uid') {
                $condition_user['uid'] = $_GET['keyword'];
            } else if ($_GET['searchtype'] == 'nickname') {
                $condition_user['nickname'] = array('like', '%' . $_GET['keyword'] . '%');
            } else if ($_GET['searchtype'] == 'phone') {
                $condition_user['phone'] = array('like', '%' . $_GET['keyword'] . '%');
            }
        }

        $database_user = D('User');

        $count_user = $database_user->where($condition_user)->count();
        import('@.ORG.system_page');
        $p = new Page($count_user, 15);
        $user_list = $database_user->field(true)->where($condition_user)->order('`uid` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();

        if (!empty($user_list)) {
            import('ORG.Net.IpLocation');
            $IpLocation = new IpLocation();
            foreach ($user_list as &$value) {
                $last_location = $IpLocation->getlocation(long2ip($value['last_ip']));
                $value['last_ip_txt'] = iconv('GBK', 'UTF-8', $last_location['country']) . iconv('GBK', 'UTF-8', $last_location['area']);
            }
        }
        $this->assign('user_list', $user_list);
        $pagebar = $p->show();
        $this->assign('pagebar', $pagebar);

        $this->display();
    }

    public function edit() {
        $this->assign('bg_color', '#F3F3F3');

        $database_user = D('User');
        $condition_user['uid'] = intval($_GET['uid']);
        $now_user = $database_user->field(true)->where($condition_user)->find();
        if (empty($now_user)) {
            $this->frame_error_tips('没有找到该用户信息！');
        }
        $this->assign('now_user', $now_user);

        $this->display();
    }

    public function amend() {
        if (IS_POST) {
            $database_user = D('User');
            $condition_user['uid'] = intval($_POST['uid']);
            $now_user = $database_user->field(true)->where($condition_user)->find();
            if (empty($now_user)) {
                $this->error('没有找到该用户信息！');
            }
            $condition_user['uid'] = $now_user['uid'];
            $data_user['phone'] = $_POST['phone'];
            if ($_POST['pwd']) {
                $data_user['password'] = md5($_POST['pwd']);
            }
            $data_user['status'] = $_POST['status'];
            $data_user['intro'] = $_POST['intro'];

            if ($database_user->where($condition_user)->data($data_user)->save()) {
                $this->success('修改成功！');
            } else {
                $this->error('修改失败！请重试。');
            }
        } else {
            $this->error('非法访问！');
        }
    }

    //商家店铺
    public function stores() {
        $store = M('Store');
        $sale_category = M('SaleCategory');

        $uid = $this->_get('id');
        $tmp_stores = $store->field(array('store_id', 'uid', 'name', 'income', 'balance', 'unbalance', 'sale_category_id', 'status', "CONCAT('./upload/images/', logo) AS logo"))->where(array('uid' => $uid))->select();

        $stores = array();
        foreach ($tmp_stores as $store) {
            $category = $sale_category->where(array('cat_id' => $store['sale_category_id']))->getField('name');
            $stores[] = array(
                'store_id' => $store['store_id'],
                'uid' => $store['uid'],
                'name' => $store['name'],
                'logo' => $store['logo'],
                'sale_category' => $category,
                'income' => number_format($store['income'], 2, '.', ''),
                'balance' => number_format($store['balance'], 2, '.', ''),
                'unbalance' => number_format($store['unbalance'], 2, '.', ''),
                'status' => $store['status']
            );
        }

        $this->assign('stores', $stores);
        $this->display();
    }

    //切换店铺
    public function tab_store() {
        $uid = $this->_get('uid','trim,intval');
        if (!$uid) {
            $this->error('传递参数有误！');
        }
        $where['uid'] = $uid;
        $user_info = M('User')->where($where)->find();
        if (!$user_info) {
            $this->error('该用户不存在!');
        }

        $_SESSION['user'] = $user_info;
        redirect('/user.php?c=store&a=select');
    }

}