<?php

class widget_controller extends base_controller {

    public function page() {
        if (!empty($_SESSION['system'])) {
            $page_result = M('Wei_page')->getAllList(8);
            $this->assign('is_system', true);
        } else {
            $page_result = M('Wei_page')->get_list($this->store_session['store_id'], 8);
        }

        $this->assign('wei_pages', $page_result['page_list']);
        $this->assign('page', $page_result['page']);
        if (IS_POST) {
            $this->display('ajax_page');
        } else {
            $this->display();
        }
    }

    public function pagecat() {
        if (!empty($_SESSION['system'])) {
            $wei_page_categories = M('Wei_page_category')->getAllList(8);
            $this->assign('is_system', true);
        } else {
            $wei_page_categories = M('Wei_page_category')->get_list($this->store_session['store_id'], 8);
        }
        $this->assign('wei_page_categories', $wei_page_categories['cat_list']);
        $this->assign('page', $wei_page_categories['page']);
        if (IS_POST) {
            $this->display('ajax_pagecat');
        } else {
            $this->display();
        }
    }

    public function good() {
        $product = M('Product');
        $where = array();
        if (!empty($_SESSION['system'])) {
            $this->assign('is_system', true);
        } else {
            $where['store_id'] = $this->store_session['store_id'];
        }
        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
        $product_total = $product->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 8);
        $products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);

        $this->assign('products', $products);
        $this->assign('page', $page->show());
        if ($_GET['type'] == 'more') {
            if (IS_POST) {
                $this->display('ajax_more_goods');
            } else {
                $this->display('more_goods');
            }
        } else {
            if (IS_POST) {
                $this->display('ajax_good');
            } else {
                $this->display();
            }
        }
    }

    //当前自营的商品
    public function do_selfgood() {
        $product = M('Product');
        $where = array();
        if (!empty($_SESSION['system'])) {
            $this->assign('is_system', true);
        } else {
            $where['store_id'] = $this->store_session['store_id'];
        }

        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
        $where['supplier_id'] = '0';
        $where['quantity'] = array('>', 0);
        $where['soldout'] = 0;
        $product_total = $product->getSellingTotal($where);

        import('source.class.user_page');
        $page = new Page($product_total, 8);
        $products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);

        $this->assign('products', $products);
        $this->assign('page', $page->show());
        if ($_GET['type'] == 'more') {
            if (IS_POST) {
                $this->display('ajax_more_goods');
            } else {
                $this->display('more_goods');
            }
        } else {
            if (IS_POST) {
                $this->display('ajax_good');
            } else {
                $this->display();
            }
        }
    }

    public function goodcat() {
        if (!empty($_SESSION['system'])) {
            $product_groups = M('Product_group')->getAllList(8);
            $this->assign('is_system', true);
        } else {
            $product_groups = M('Product_group')->get_list($this->store_session['store_id'], 8);
        }

        $this->assign('product_groups', $product_groups['group_list']);
        $this->assign('page', $product_groups['page']);
        if (IS_POST) {
            $this->display('ajax_goodcat');
        } else {
            $this->display();
        }
    }

    public function component() {
        if (!empty($_SESSION['system'])) {
            $custom_pages = M('Custom_page')->getAllList(8);
            $this->assign('is_system', true);
        } else {
            $custom_pages = M('Custom_page')->getPages($this->store_session['store_id'], 8);
        }
        $this->assign('pages', $custom_pages['pages']);
        $this->assign('page', $custom_pages['page']);
        if (IS_POST) {
            $this->display('ajax_component');
        } else {
            $this->display();
        }
    }

    //优惠券弹窗列表
    public function coupon() {
        $coupon = M('Coupon');
        $where = array();
//        if (!empty($_SESSION['system'])) {
//            $this->assign('is_system', true);
//        } else {
            $where['store_id'] = $this->store_session['store_id'];
        //}
        $where['status'] = 1;

        $coupon_total = $coupon->getCount($where);
        import('source.class.user_page');
        $page = new Page($product_total, 8);
        $coupons = $coupon->getList($where, '', $page->firstRow, $page->listRows);
        //coupon
        $this->assign('coupons', $coupons);
        $this->assign('page', $page->show());

        if ($_GET['type'] == 'more') {
            if (IS_POST) {
                $this->display('ajax_more_goods');
            } else {
                //$this->display('more_goods');
                $this->display('more_coupon');
            }
        } else {
            if (IS_POST) {
                $this->display('ajax_good');
            } else {
                $this->display();
            }
        }
    }

	
	//logo弹窗及列表
	    //当前自营的商品
    public function logo() {
        $product = M('Product');
        $where = array();
        if (!empty($_SESSION['system'])) {
            $this->assign('is_system', true);
        } else {
            $where['store_id'] = $this->store_session['store_id'];
        }

        if (!empty($_REQUEST['keyword'])) {
            $where['name'] = array('like', '%' . trim($_REQUEST['keyword']) . '%');
        }
        $where['supplier_id'] = '0';
        $where['quantity'] = array('>', 0);
        $where['soldout'] = 0;
        $product_total = $product->getSellingTotal($where);

        import('source.class.user_page');
        $page = new Page($product_total, 8);
        $products = $product->getSelling($where, '', '', $page->firstRow, $page->listRows);

        $this->assign('products', $products);
        $this->assign('page', $page->show());
        if ($_GET['type'] == 'more') {
            if (IS_POST) {
                $this->display('ajax_more_goods');
            } else {
                $this->display('more_goods');
            }
        } else {
            if (IS_POST) {
                $this->display('ajax_good');
            } else {
                $this->display();
            }
        }
    }
    
//    public function new_page_select(){
//        $this->display();
//    }
}

?>