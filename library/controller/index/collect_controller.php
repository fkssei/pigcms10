<?php

/**
 * 收藏
 * User: pigcms_21
 * Date: 2015/3/3
 * Time: 14:41
 */
class collect_controller extends base_controller {

    function add() {
        if (empty($this->user_session['uid'])) {
            echo json_encode(array('status' => false, 'msg' => '请先登录', 'data' => array('error' => 'login')));
            exit;
        }

        $dataid = $_GET['id'];
        $type = $_GET['type'];


        if (empty($dataid)) {
            echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
            exit;
        }

        if (!in_array($type, array(1, 2))) {
            echo json_encode(array('status' => false, 'msg' => '收藏类型错误'));
            exit;
        }

        if ($type == 1) {
            $data = D('Product')->where(array('product_id' => $dataid, 'status' => 1))->find();
            if (empty($data)) {
                echo json_encode(array('status' => false, 'msg' => '未找到要收藏的产品'));
                exit;
            }
        } else {
            $data = D('Store')->where(array('store_id' => $dataid, 'status' => 1))->find();
            if (empty($data)) {
                echo json_encode(array('status' => false, 'msg' => '未找到要收藏的店铺'));
                exit;
            }
        }

        // 查看是否已经收藏过
        $user_collect = D('User_collect')->where(array('user_id' => $this->user_session['uid'], 'type' => $type, 'dataid' => $dataid))->find();
        if (!empty($user_collect)) {
            echo json_encode(array('status' => false, 'msg' => '已经收藏过了'));
            exit;
        }

        M('User_collect')->add($this->user_session['uid'], $dataid, $type);
        echo json_encode(array('status' => true, 'msg' => '收藏成功', 'data' => array('nexturl' => '')));
        exit;
    }

    //关注商品
    public function attention() {
        if (empty($this->user_session['uid'])) {
            echo json_encode(array('status' => false, 'msg' => '请先登录', 'data' => array('error' => 'login')));
            exit;
        }

        $data_id = $_GET['id'];
        $data_type = $_GET['type'];

        if (empty($data_id)) {
            echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
            exit;
        }

        if (!in_array($data_type, array(1, 2))) {
            echo json_encode(array('status' => false, 'msg' => '关注类型错误'));
            exit;
        }

        if ($data_type == 1) {
            $data = D('Product')->where(array('product_id' => $data_id, 'status' => 1))->find();
            if (empty($data)) {
                echo json_encode(array('status' => false, 'msg' => '未找到要关注的产品'));
                exit;
            }
        } else {
            $data = D('Store')->where(array('store_id' => $data_id, 'status' => 1))->find();
            if (empty($data)) {
                echo json_encode(array('status' => false, 'msg' => '未找到要关注的店铺'));
                exit;
            }
        }

        $attention_info = D('User_attention')->where(array('user_id' => $this->user_session['uid'], 'data_type' => $data_type, 'data_id' => $data_id))->find();
        if (!empty($attention_info)) {
            echo json_encode(array('status' => false, 'msg' => '已经关注过了'));
            exit;
        } else {
            M('User_attention')->add($this->user_session['uid'], $data_id, $data_type);
            echo json_encode(array('status' => true, 'msg' => '关注成功', 'data' => array('nexturl' => '')));
            exit;
        }
    }
    
    //取消关注
    function attention_cancel() {
    	if (empty($this->user_session['uid'])) {
    		echo json_encode(array('status' => false, 'msg' => '请先登录'));
    		exit;
    	}
    
    	$data_id = $_GET['id'];
    	$data_type = $_GET['type'];
    
    
    	if (empty($data_id)) {
    		echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
    		exit;
    	}
    
    	if (!in_array($data_type, array(1, 2))) {
    		echo json_encode(array('status' => false, 'msg' => '关注类型错误'));
    		exit;
    	}
    
    	if ($data_type == 1) {
    		$data = D('Product')->where(array('product_id' => $data_id, 'status' => 1))->find();
    		if (empty($data)) {
    			echo json_encode(array('status' => false, 'msg' => '未找到关注的产品'));
    			exit;
    		}
    	} else {
    		$data = D('Store')->where(array('store_id' => $data_id, 'status' => 1))->find();
    		if (empty($data)) {
    			echo json_encode(array('status' => false, 'msg' => '未找到关注的店铺'));
    			exit;
    		}
    	}
    
    	// 查看是否已经收藏过
    	$user_attention = D('User_attention')->where(array('user_id' => $this->user_session['uid'], 'data_type' => $data_type, 'data_id' => $data_id))->find();
    	if (empty($user_attention)) {
    		echo json_encode(array('status' => false, 'msg' => '未找到您的关注'));
    		exit;
    	}
    
    	M('User_attention')->cancel($this->user_session['uid'], $data_id, $data_type);
    	echo json_encode(array('status' => true, 'msg' => '取消关注成功', 'data' => array('nexturl' => 'refresh')));
    	exit;
    }
    
    

    function cancel() {
        if (empty($this->user_session['uid'])) {
            echo json_encode(array('status' => false, 'msg' => '请先登录'));
            exit;
        }

        $dataid = $_GET['id'];
        $type = $_GET['type'];


        if (empty($dataid)) {
            echo json_encode(array('status' => false, 'msg' => '缺少最基本的参数'));
            exit;
        }

        if (!in_array($type, array(1, 2))) {
            echo json_encode(array('status' => false, 'msg' => '收藏类型错误'));
            exit;
        }

        if ($type == 1) {
            $data = D('Product')->where(array('product_id' => $dataid, 'status' => 1))->find();
            if (empty($data)) {
                echo json_encode(array('status' => false, 'msg' => '未找到收藏的产品'));
                exit;
            }
        } else {
            $data = D('Store')->where(array('store_id' => $dataid, 'status' => 1))->find();
            if (empty($data)) {
                echo json_encode(array('status' => false, 'msg' => '未找到收藏的店铺'));
                exit;
            }
        }

        // 查看是否已经收藏过
        $user_collect = D('User_collect')->where(array('user_id' => $this->user_session['uid'], 'type' => $type, 'dataid' => $dataid))->find();
        if (empty($user_collect)) {
            echo json_encode(array('status' => false, 'msg' => '未找到您的收藏'));
            exit;
        }

        M('User_collect')->cancel($this->user_session['uid'], $dataid, $type);
        echo json_encode(array('status' => true, 'msg' => '取消收藏成功', 'data' => array('nexturl' => 'refresh')));
        exit;
    }

}