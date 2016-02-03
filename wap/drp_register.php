<?php
/**
 *  分销商注册
 */
require_once dirname(__FILE__).'/drp_check.php';

$store = M('Store');
if (IS_POST && $_POST['type'] == 'check_store') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    if ($store->checkStoreExist(array('name' => $name, 'status' => 1))) {
        echo false;
    } else {
        echo true;
    }
    exit;
} else if (IS_POST && $_POST['type'] == 'check_phone') {
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $user = M('User');
    if ($user->checkUser(array('phone' => trim($_POST['phone']), 'uid' => array('!=', $_SESSION['wap_user']['uid'])))) {
        echo false;
    } else {
        echo true;
    }
    exit;
}


$store_id = isset($_GET['id']) ? intval(trim($_GET['id'])) : '';

if (!empty($_GET['a']) && strtolower($_GET['a']) == 'share') {
    $product = M('Product');
    $product_image = M('Product_image');
    $product_sku = M('Product_sku');
    $product_to_group = M('Product_to_group');
    $product_to_property = M('Product_to_property');
    $product_to_property_value = M('Product_to_property_value');
    $product_qrcode_activity = M('Product_qrcode_activity');
    $product_custom_field = M('Product_custom_field');
    $store = M('Store');
    $store_supplier = M('Store_supplier');
    $user = M('User');
    $sale_category = M('Sale_category');
    $common_data = M('Common_data');

    $product_id = isset($_GET['product_id']) ? intval(trim($_GET['product_id'])) : 0;
    //判断是否有该店铺分销商
    $seller = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' => $_SESSION['wap_user']['uid']))->find();
    if (!empty($seller)) { //有店铺，添加此商品到分销商店铺
        $drp_level = $seller['drp_level']; //当前分销级别
        $product_info = D('Product')->where(array('product_id' => $product_id))->find();
        if (!empty($product_info)) {
            $data = $product_info;
            unset($data['product_id']);
            $data['name']                = mysql_real_escape_string($data['name']);
            $data['uid']                 = $_SESSION['wap_user']['uid'];
            $data['store_id']            = $seller['store_id'];
            $data['price']               = $product_info['min_fx_price'];
            $data['source_product_id']   = $product_id;
            $data['status']              = 1;
            $data['date_added']          = time();
            $data['supplier_id']         = $store_id;
            $data['pv']                  = 0;
            $data['delivery_address_id'] = 0;
            $data['sales']               = 0; //销量清零
            $data['original_product_id'] = !empty($product_info['original_product_id']) ? $product_info['original_product_id'] : $product_id; //分销商品原始id
            $data['is_fx_setting']       = 0;
            if (!empty($product_info['unified_price_setting'])) {
                $data['price']           = !empty($product_info['drp_level_' . $drp_level . '_price']) ? $product_info['drp_level_' . $drp_level . '_price'] : $product_info['price'];
                $data['cost_price']      = !empty($product_info['drp_level_' . ($drp_level + 1) . '_cost_price']) ? $product_info['drp_level_' . ($drp_level + 1) . '_cost_price'] : $product_info['cost_price'];
                $data['min_fx_price']    = !empty($product_info['drp_level_' . ($drp_level + 1) . '_price']) ? $product_info['drp_level_' . ($drp_level + 1) . '_price'] : $product_info['min_fx_price'];
                $data['max_fx_price']    = !empty($product_info['drp_level_' . ($drp_level + 1) . '_price']) ? $product_info['drp_level_' . ($drp_level + 1) . '_price'] : $product_info['max_fx_price'];
            }
            if ($new_product_id = $product->add($data)) {
                $product->setDrpSellerQty($data['original_product_id']); //被分销次数+1
                //商品图片
                $tmp_images = $product_image->getImages($product_id);
                $images = array();
                foreach ($tmp_images as $tmp_image) {
                    $images[] = $tmp_image['image'];
                }
                $product_image->add($new_product_id, $images);
                //商品自定义字段
                $tmp_fields = $product_custom_field->getFields($product_id);
                $fields = array();
                if (!empty($tmp_fields)) {
                    foreach ($tmp_fields as $tmp_field) {
                        $fields[] = array(
                            'name' => $tmp_field['field_name'],
                            'type' => $tmp_field['field_type'],
                            'multi_rows' => $tmp_field['multi_rows'],
                            'required' => $tmp_field['required']
                        );
                    }
                    $product_custom_field->add($product_id, $fields);
                }
                //商品属性名
                $property_names = $product_to_property->getPropertyNames($product_info['store_id'], $product_id);
                if (!empty($property_names)) {
                    foreach ($property_names as $property_name) {
                        $product_to_property->add(array('store_id' => $store_id, 'product_id' => $new_product_id, 'pid' => $property_name['pid'], 'order_by' => $property_name['order_by']));
                    }
                }
                //商品属性值
                $property_values = $product_to_property_value->getPropertyValues($product_info['store_id'], $product_id);
                if (!empty($property_values)) {
                    foreach ($property_values as $property_value) {
                        $product_to_property_value->add(array('store_id' => $store_id, 'product_id' => $new_product_id, 'pid' => $property_value['pid'], 'vid' => $property_value['vid'], 'order_by' => $property_value['order_by']));
                    }
                }
                //扫码活动
                $qrcode_activities = $product_qrcode_activity->getActivities($product_info['store_id'], $product_id);
                if (!empty($qrcode_activities)) {
                    foreach ($qrcode_activities as $qrcode_activitiy) {
                        $product_qrcode_activity->add(array('store_id' => $store_id, 'product_id' => $new_product_id, 'buy_type' => $qrcode_activitiy['buy_type'], 'type' => $qrcode_activitiy['type'], 'discount' => $qrcode_activitiy['discount'], 'price' => $qrcode_activitiy['price']));
                    }
                }
                //库存信息
                $tmp_product_skus = $product_sku->getSkus($product_id);
                if ($tmp_product_skus) {
                    $skus = array();
                    foreach ($tmp_product_skus as $tmp_product_sku) {
                        $tmp_sku = array(
                            'properties'   => $tmp_product_sku['properties'],
                            'quantity'     => $tmp_product_sku['quantity'],
                            'price'        => $tmp_product_sku['min_fx_price'],
                            'code'         => $tmp_product_sku['code'],
                            'sales'        => 0,
                            'cost_price'   => $tmp_product_sku['cost_price'],
                            'min_fx_price' => $tmp_product_sku['min_fx_price'],
                            'max_fx_price' => $tmp_product_sku['max_fx_price']
                        );
                        if (!empty($product_info['unified_price_setting'])) {
                            $tmp_sku['price']        = !empty($tmp_product_sku['drp_level_' . $drp_level . '_price']) ? $tmp_product_sku['drp_level_' . $drp_level . '_price'] : $tmp_product_sku['price'];
                            $tmp_sku['cost_price']   = !empty($tmp_product_sku['drp_level_' . ($drp_level + 1) . '_cost_price']) ? $tmp_product_sku['drp_level_' . ($drp_level + 1) . '_cost_price'] : $tmp_product_sku['cost_price'];
                            $tmp_sku['min_fx_price'] = !empty($tmp_product_sku['drp_level_' . ($drp_level + 1) . '_price']) ? $tmp_product_sku['drp_level_' . ($drp_level + 1) . '_price'] : $tmp_product_sku['min_fx_price'];
                            $tmp_sku['max_fx_price'] = !empty($tmp_product_sku['drp_level_' . ($drp_level + 1) . '_price']) ? $tmp_product_sku['drp_level_' . ($drp_level + 1) . '_price'] : $tmp_product_sku['max_fx_price'];
                            $tmp_sku['drp_level_1_cost_price'] = $tmp_product_sku['drp_level_1_cost_price'];
                            $tmp_sku['drp_level_2_cost_price'] = $tmp_product_sku['drp_level_2_cost_price'];
                            $tmp_sku['drp_level_3_cost_price'] = $tmp_product_sku['drp_level_3_cost_price'];
                            $tmp_sku['drp_level_1_price'] = $tmp_product_sku['drp_level_1_price'];
                            $tmp_sku['drp_level_2_price'] = $tmp_product_sku['drp_level_2_price'];
                            $tmp_sku['drp_level_3_price'] = $tmp_product_sku['drp_level_3_price'];
                        }
                        $skus[] = $tmp_sku;
                    }
                    $product_sku->add($new_product_id, $skus);
                }
                redirect('./drp_product_share.php?id=' . $new_product_id);
            }
        }
    }
}

//判断是否已经是分销商
if (!empty($_SESSION['wap_user']['uid'])) {
    $uid = $_SESSION['wap_user']['uid'];
    if (!empty($store_id)) {
        $store_info = $store->getUserDrpStore($uid, $store_id, 0);
    } else {
        $store_info = $store->getUserDrpStore($uid, 0, 0);
    }
    if ($store_info) { //已有分销店铺，跳转到分销管理页面
        $_SESSION['wap_drp_store'] = $store_info;
        $_SESSION['wap_user']['store_id'] = $store_info['store_id']; //切换店铺
        redirect('./drp_ucenter.php');
    } else {
        $store_info = $store->getStore($store_id);
        if ($store_info['uid'] == $uid) { //店铺拥有者不能分销
            redirect('./ucenter.php?id=' . $store_id);
        }
    }
}
//获取供货商分销商品
$product = M('Product');
$product_count = $product->supplierFxProductCount(array('store_id' => $store_id, 'is_fx' => 1, 'status' => 1));

$agreement = option('config.readme_content');

//判断用户是否设置密码
$user = M('User');
$userinfo = $user->getUserById($_SESSION['wap_user']['uid']);
$has_password = true;
if (empty($userinfo['password'])) {
    $has_password = false;
}
//分销商登陆地址
if (!empty($store_info['source_site_url']) && !empty($_SESSION['sync_user'])) {
    $admin_url = $store_info['source_site_url'] . '/api/weidian.php';
} else {
    $admin_url = option('config.site_url') . '/account.php';
}
//是否审核
$open_drp_approve = false;
if (!empty($store_info['open_drp_approve'])) {
    $open_drp_approve = true;
}

$nickname = !empty($userinfo['nickname']) ? $userinfo['nickname'] : '';

include display('drp_register');

echo ob_get_clean();