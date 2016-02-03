<?php
/**
 *  店铺
 */

define('PIGCMS_PATH', dirname(__FILE__).'/../');
require_once PIGCMS_PATH.'source/init.php';
require_once 'functions.php';

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $now = time();
    $timestamp = $_POST['request_time'];
    $sign_key = $_POST['sign_key'];
    unset($_POST['request_time']);
    unset($_POST['sign_key']);
    $_POST['salt'] = SIGN_SALT;
    if (!_checkSign($sign_key, $_POST)) {
        $error_code = 1003;
        $error_msg = '签名无效';
        $return_url = '';
    } else {
            $site_url = trim($_POST['site_url']);
            //处理同一域名是否有www
            if (stripos('://wwww.', $site_url) !== false) {
                $site_url2 = str_replace('://wwww.', '', $site_url);
            } else if (stripos('://wwww.', $site_url) === false) {
                $site_url2 = str_replace('://', '://www.', $site_url);
            }
            $store = M('Store');
            $stores = array();
            if (isset($_POST['type']) && !empty($_POST['type'])) {
                $type = explode(',', $_POST['type']);
                if (!empty($_POST['store_id'])) {
                    $where = array();
                    $where['_string'] = "store_id = '" . intval(trim($_POST['store_id'])) . "' AND token = '" . trim($_POST['token']) . "' AND status = 1 AND drp_supplier_id = 0 AND (source_site_url = '" . $site_url . "' OR source_site_url = '" . $site_url2 . "')";
                    $tmp_stores = D('Store')->where($where)->select();
                } else {
                    $where = array();
                    $where['_string'] = "token = '" . trim($_POST['token']) . "' AND drp_supplier_id = 0 AND status = 1 AND (source_site_url = '" . $site_url . "' OR source_site_url = '" . $site_url2 . "')";
                    $tmp_stores = D('Store')->where($where)->select();
                }
                if (empty($_POST['store_id'])) {
                    foreach ($tmp_stores as $key => $tmp_store) {
                        if (in_array('product', $type)) {
                            //店铺在售商品数
                            $where = array();
                            $where['store_id'] = $tmp_store['store_id'];
                            $where['quantity'] = array('>', 0);
                            $where['soldout'] = 0;
                            $product_count = D('Product')->field('product_id,name')->where($where)->count('product_id');
                        }

                        if (in_array('wei_page', $type)) {
                            //微页面数
                            $wei_page_count = D('Wei_page')->field('page_id,page_name')->where(array('store_id' => $tmp_store['store_id']))->count('page_id');
                        }
                        $stores[$key] = array(
                            'store_id' => $tmp_store['store_id'],
                            'name'     => $tmp_store['name'],
                            'url'      => option('config.wap_site_url') . '/home.php?id=' . $tmp_store['store_id']
                        );

                        if (in_array('product', $type)) {
                            $stores[$key]['product_count'] = $product_count; //商品数
                        }
                        if (in_array('wei_page', $type)) {
                            $stores[$key]['wei_page_count'] = $wei_page_count; //微页面数
                        }
                    }
                } else {
                    import('source.class.user_page');
                    $page_size = !empty($_POST['page_size']) ? intval(trim($_POST['page_size'])) : 10;
                    foreach ($tmp_stores as $key => $tmp_store) {
                        if (in_array('product', $type)) {
                            //店铺在售商品数
                            $where = array();
                            $where['store_id'] = $tmp_store['store_id'];
                            $where['quantity'] = array('>', 0);
                            $where['soldout'] = 0;
                            $product_count = D('Product')->field('product_id,name')->where($where)->count('product_id');
                            $page = new Page($product_count, $page_size);
                            $tmp_products = D('Product')->field('product_id,name')->where($where)->order('sort DESC, product_id DESC')->limit($page->firstRow . ',' . $page->listRows)->select();
                            $products = array();
                            foreach ($tmp_products as $tmp_product) {
                                $products[] = array(
                                    'product_id' => $tmp_product['product_id'],
                                    'name' => $tmp_product['name'],
                                    'url' => option('config.wap_site_url') . '/good.php?id=' . $tmp_product['product_id']
                                );
                            }
                        }
                        if (in_array('wei_page', $type)) {
                            //微页面数
                            $wei_page_count = D('Wei_page')->field('page_id,page_name')->where(array('store_id' => $tmp_store['store_id']))->count('page_id');
                            $page2 = new Page($wei_page_count, $page_size);
                            $tmp_wei_pages = D('Wei_page')->field('page_id,page_name')->where(array('store_id' => $tmp_store['store_id']))->order('page_id DESC')->limit($page2->firstRow . ',' . $page2->listRows)->select();
                            $wei_pages = array();
                            foreach ($tmp_wei_pages as $tmp_wei_page) {
                                $wei_pages[] = array(
                                    'page_id' => $tmp_wei_page['page_id'],
                                    'name' => $tmp_wei_page['page_name'],
                                    'url' => option('config.wap_site_url') . '/page.php?id=' . $tmp_wei_page['page_id']
                                );
                            }
                        }
                        $stores[$key] = array(
                            'store_id'  => $tmp_store['store_id'],
                            'name'      => $tmp_store['name'],
                            'url'       => option('config.wap_site_url') . '/home.php?id=' . $tmp_store['store_id']
                        );
                        if (in_array('product', $type)) {
                            $stores[$key]['product_count'] = $product_count; //商品数
                            $stores[$key]['products'] = $products; //商品
                        }
                        if (in_array('wei_page', $type)) {
                            $stores[$key]['wei_page_count'] = $wei_page_count; //微页面数
                            $stores[$key]['wei_pages'] = $wei_pages; //微页面
                        }
                    }
                }
            } else {
                $where = array();
                $where['_string'] = "token = '" . trim($_POST['token']) . "' AND drp_supplier_id = 0 AND status = 1 AND (source_site_url = '" . $site_url . "' OR source_site_url = '" . $site_url2 . "')";
                $stores = D('Store')->where($where)->select();
            }

            if (!empty($stores)) {
                $error_code = 0;
                $error_msg = '请求成功';
                $return_url = '';
            } else {
                $stores = '';
                $error_code = 1005;
                $error_msg = '店铺不存在';
                $return_url = '';
            }

    }
} else {
    $error_code = 1001;
    $error_msg = '请求失败';
    $return_url = '';
    $stores = '';
}
echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'stores' => $stores, 'return_url' => $return_url));
exit;
