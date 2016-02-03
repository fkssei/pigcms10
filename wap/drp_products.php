<?php
/**
 * 分销商品
 * User: pigcms_21
 * Date: 2015/4/17
 * Time: 16:32
 */
require_once dirname(__FILE__).'/drp_check.php';

if (IS_POST && $_POST['type'] == 'get') {
    $product = M('Product');
    //已经是分销（修改分销商品）
    if (!empty($_SESSION['wap_drp_store'])) {
        //获取分销商已分销的商品(不含删除状态)
        $tmp_fx_products = $product->availableFxProducts($_SESSION['wap_drp_store']['store_id']);
        $fx_products = array();
        foreach ($tmp_fx_products as $tmp_product) {
            $fx_products[] = $tmp_product['source_product_id'];
        }
        $fx_products = !empty($fx_products) ? array_unique($fx_products) : $fx_products;
    }
    //获取供货商分销商品
    $store_id = isset($_POST['store_id']) ? intval(trim($_POST['store_id'])) : 0;
    $product_count = $product->supplierFxProductCount(array('store_id' => $store_id, 'is_fx' => 1, 'status' => 1));
    import('source.class.user_page');
    $pagesize = !empty($_POST['pagesize']) ? intval($_POST['pagesize']) : 20;
    $page = new Page($product_count, $pagesize);
    $products = $product->supplierFxProducts(array('store_id' => $store_id, 'is_fx' => 1, 'status' => 1), $page->firstRow, $page->listRows);
    $data = '';
    if ($products) {
        foreach ($products as $product) {
            $class = '';
            if (!empty($fx_products) && in_array($product['product_id'], $fx_products)) {
                $class = ' current';
            } else if (empty($_SESSION['wap_drp_store']) || (!empty($_SESSION['wap_drp_store']) && $_SESSION['wap_drp_store']['drp_supplier_id'] != $store_id)) { //添加分销店铺（默认全选）
                $class = ' current';
            }
            $data .= '<div class="item' . $class . '" name="columns" style="margin-bottom: 10px; zoom: 1; opacity: 1;" pid="' . $product['product_id'] .'">';
            $data .= '    <div>';
            $data .= '        <img src="' . $product['image'] . '" />';
            $data .= '        <h5 style="font-size: 12px;height:50px;text-align:left;padding: 0 5px;">' . $product['name'] . '</h5>';
            $data .= '        <ul class="percent" style="width:auto;">';
            $data .= '            <li style="padding: 0 5px;font-size:12px">成本价: ￥' . $product['cost_price'] . '</li>';
            $data .= '            <li style="padding: 0 5px;font-size:12px">建议售价: ￥' . $product['min_fx_price'] . ' - ' . $product['max_fx_price'] . '</li>';
            $data .= '            <li style="padding: 0 5px;font-size: 12px">分销利润：￥' . number_format(($product['min_fx_price'] - $product['cost_price']), 2, '.', '') . ' - ' . number_format(($product['max_fx_price'] - $product['cost_price']), 2, '.', '') . '</li>';
            $data .= '        </ul>';
            $data .= '    </div>';
            $data .= '</div>';
        }
    }
    echo $data;
    exit;
} else if (IS_POST && $_POST['type'] == 'set_drp') { //设置分销
    $product = M('Product');
    $product_image = M('Product_image');
    $product_sku = M('Product_sku');
    $product_to_group = M('Product_to_group');
    $product_to_property = M('Product_to_property');
    $product_to_property_value = M('Product_to_property_value');
    $product_qrcode_activity = M('Product_qrcode_activity');
    $product_custom_field = M('Product_custom_field');
    $store = M('Store');

    $drp_level = $_SESSION['wap_drp_store']['drp_level'];

    $product_id = intval(trim($_POST['product_id']));
    //判断商品是否已经被分销
    $product_info = $product->get(array('store_id' => $_SESSION['wap_drp_store']['store_id'], 'source_product_id' => $product_id), '*');
    if (!empty($product_info)) {
        $result = D('Product')->where(array('product_id' => $product_info['product_id'], 'store_id' => $_SESSION['wap_drp_store']['store_id']))->data(array('status' => 1))->save(); //设置为仓库中
        if ($result) {
            json_return(0, '商品分销成功');
        } else {
            json_return(1001, '商品分销失败');
        }
    } else { //没有被分销，则设置分销
        $product_info = $product->get(array('store_id' => $_SESSION['wap_drp_store']['drp_supplier_id'], 'product_id' => $product_id), '*');
        $data = $product_info;
        unset($data['product_id']);
        $data['uid']                 = $_SESSION['wap_drp_store']['uid'];
        $data['name']                = mysql_real_escape_string($data['name']);
        $data['store_id']            = $_SESSION['wap_drp_store']['store_id'];
        $data['price']               = $product_info['min_fx_price'];
        $data['is_fx']               = 0;
        $data['source_product_id']   = $product_id;
        $data['status']              = 1;
        $data['date_added']          = time();
        $data['supplier_id']         = $product_info['store_id'];
        $data['pv']                  = 0;
        $data['delivery_address_id'] = 0;
        $data['sales']               = 0; //销量清零
        $data['group_id']            = 0;
        $data['is_fx_setting']       = 0;
        $data['original_product_id'] = !empty($product_info['original_product_id']) ? $product_info['original_product_id'] : $product_id; //分销商品原始id
        if (!empty($product_info['unified_price_setting'])) {
            $data['price']        = !empty($product_info['drp_level_' . $drp_level . '_price']) ? $product_info['drp_level_' . $drp_level . '_price'] : $product_info['price'];
            $data['cost_price']   = !empty($product_info['drp_level_' . ($drp_level + 1) . '_cost_price']) ? $product_info['drp_level_' . ($drp_level + 1) . '_cost_price'] : $product_info['cost_price'];
            $data['min_fx_price'] = !empty($product_info['drp_level_' . ($drp_level + 1) . '_price']) ? $product_info['drp_level_' . ($drp_level + 1) . '_price'] : $product_info['min_fx_price'];
            $data['max_fx_price'] = !empty($product_info['drp_level_' . ($drp_level + 1) . '_price']) ? $product_info['drp_level_' . ($drp_level + 1) . '_price'] : $product_info['max_fx_price'];
        }
        if ($new_product_id = $product->add($data)) {
            $product->setDrpSellerQty($data['original_product_id']); //被分销次数+1
            //商品图片
            $tmp_images = $product_image->getImages($product_id);
            $images = array();
            foreach ($tmp_images as $tmp_image) {
                $images[] =  $tmp_image['image'];
            }
            $product_image->add($new_product_id, $images);
            //商品自定义字段
            $tmp_fields = $product_custom_field->getFields($product_id);
            $fields = array();
            if (!empty($tmp_fields)) {
                foreach ($tmp_fields as $tmp_field) {
                    $fields[] = array(
                        'name'       => $tmp_field['field_name'],
                        'type'       => $tmp_field['field_type'],
                        'multi_rows' => $tmp_field['multi_rows'],
                        'required'   => $tmp_field['required']
                    );
                }
                $product_custom_field->add($product_id, $fields);
            }
            //商品分组
            /*$groups = $product_to_group->getGroups($product_id);
            if (!empty($groups)) {
                foreach ($groups as $group) {
                    $product_to_group->add(array('product_id' => $new_product_id, 'group_id' => $group['group_id']));
                }
            }*/
            //商品属性名
            $property_names = $product_to_property->getPropertyNames($product_info['store_id'], $product_id);
            if (!empty($property_names)) {
                foreach ($property_names as $property_name) {
                    $product_to_property->add(array('store_id' => $_SESSION['wap_drp_store']['store_id'], 'product_id' => $new_product_id, 'pid' => $property_name['pid'], 'order_by' => $property_name['order_by']));
                }
            }
            //商品属性值
            $property_values = $product_to_property_value->getPropertyValues($product_info['store_id'], $product_id);
            if (!empty($property_values)) {
                foreach ($property_values as $property_value) {
                    $product_to_property_value->add(array('store_id' => $_SESSION['wap_drp_store']['store_id'], 'product_id' => $new_product_id, 'pid' => $property_value['pid'], 'vid' => $property_value['vid'], 'order_by' => $property_value['order_by']));
                }
            }
            //扫码活动
            $qrcode_activities = $product_qrcode_activity->getActivities($product_info['store_id'], $product_id);
            if (!empty($qrcode_activities)) {
                foreach ($qrcode_activities as $qrcode_activitiy) {
                    $product_qrcode_activity->add(array('store_id' => $_SESSION['wap_drp_store']['store_id'], 'product_id' => $new_product_id, 'buy_type' => $qrcode_activitiy['buy_type'], 'type' => $qrcode_activitiy['type'], 'discount' => $qrcode_activitiy['discount'], 'price' => $qrcode_activitiy['price']));
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
                        $tmp_sku['price'] = !empty($tmp_product_sku['drp_level_' . $drp_level . '_price']) ? $tmp_product_sku['drp_level_' . $drp_level . '_price'] : $tmp_product_sku['price'];
                        $tmp_sku['cost_price'] = !empty($tmp_product_sku['drp_level_' . ($drp_level + 1) . '_cost_price']) ? $tmp_product_sku['drp_level_' . ($drp_level + 1)  . '_cost_price'] : $tmp_product_sku['cost_price'];
                        $tmp_sku['min_fx_price'] = !empty($tmp_product_sku['drp_level_' . ($drp_level + 1)  . '_price']) ? $tmp_product_sku['drp_level_' . ($drp_level + 1)  . '_price'] : $tmp_product_sku['min_fx_price'];
                        $tmp_sku['max_fx_price'] = !empty($tmp_product_sku['drp_level_' . ($drp_level + 1)  . '_price']) ? $tmp_product_sku['drp_level_' . ($drp_level + 1)  . '_price'] : $tmp_product_sku['max_fx_price'];
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
            json_return(0, '已设置分销');
        } else {
            json_return(1001, '商品分销失败');
        }
    }

} else if (IS_POST && $_POST['type'] == 'cancel_drp') { //取消分销
    $product = M('Product');
    $product_id = intval(trim($_POST['product_id']));
    //判断商品是否已经被分销
    $product_info = $product->get(array('store_id' => $_SESSION['wap_drp_store']['store_id'], 'source_product_id' => $product_id));
    if (!empty($product_info)) {
        $result = D('Product')->where(array('product_id' => $product_info['product_id'], 'store_id' => $_SESSION['wap_drp_store']['store_id']))->data(array('status' => 2))->save(); //设置为删除状态
    } else {
        $result = true;
    }
    json_return(0, '已取消分销');
}