<?php
/**
 * 分销店铺
 * User: pigcms_21
 * Date: 2015/4/18
 * Time: 9:01
 */

require_once dirname(__FILE__).'/drp_check.php';

//分享配置 start
$share_conf     = array(
    'title'     => $_SESSION['wap_drp_store']['name'].'-分销管理', // 分享标题
    'desc'      => str_replace(array("\r","\n"), array('',''), !empty($_SESSION['wap_drp_store']['intro']) ? $_SESSION['wap_drp_store']['intro'] : $_SESSION['wap_drp_store']['name']), // 分享描述
    'link'      => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
    'imgUrl'    => $_SESSION['wap_drp_store']['logo'], // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share      = new WechatShare();
$shareData  = $share->getSgin($share_conf);
//分享配置 end

if (IS_GET && $_GET['a'] == 'edit') {
    if (empty($_SESSION['wap_drp_store'])) {
        pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
    }
    $store = $_SESSION['wap_drp_store'];

    //获取供货商分销商品
    $product = M('Product');
    $product_count = $product->supplierFxProductCount(array('store_id' => $store['drp_supplier_id'], 'is_fx' => 1, 'status' => 1));

    if (!empty($store['source_site_url'])) {
        $store_info = $store;
    } else {
        $store_info = M('Store')->getStore($store['store_id']);
    }
    if (!empty($store_info['source_site_url']) && !empty($_SESSION['sync_user'])) {
        $admin_url = $store_info['source_site_url'] . '/api/weidian.php';
    } else {
        $admin_url = option('config.site_url') . '/account.php';
    }

    include display('drp_store_edit');
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'edit') { //修改分销店铺
    if (empty($_SESSION['wap_drp_store'])) {
        json_return(1001, '店铺编辑失败');
    }
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $intro = isset($_POST['intro']) ? trim($_POST['intro']) : '';
    $data = array();
    $data['name'] = $name;
    $data['intro'] = $intro;
    $data['last_edit_time'] = time();
    if ($_SESSION['wap_drp_store']['name'] != $name) {
        $data['edit_name_count'] = $_SESSION['wap_drp_store']['edit_name_count'] + 1; //店铺名称修改次数
    }
    if (!empty($_SESSION['wap_drp_store'])) {
        if (D('Store')->where(array('store_id' => $_SESSION['wap_drp_store']['store_id']))->data($data)->save()) {
            if (isset($_SESSION['wap_drp_store']['name'])) {
                if ($_SESSION['wap_drp_store']['name'] != $name) {
                    $_SESSION['wap_drp_store']['edit_name_count'] += 1; //店铺名称修改次数
                }
                $_SESSION['wap_drp_store']['name'] = $name;
            }
            if (isset($_SESSION['wap_drp_store']['intro'])) {
                $_SESSION['wap_drp_store']['intro'] = $intro;
            }

            $home_page = M('Wei_page')->getHomePage($_SESSION['wap_drp_store']['store_id']);
            if (!empty($home_page)) {
                $page_id = $home_page['page_id'];
                setHomePage($_SESSION['wap_drp_store']['store_id'], $page_id);
            } else {
                //添加默认的店铺首页
                $database_page = D('Wei_page');
                $data_page['store_id'] = $_SESSION['wap_drp_store']['store_id'];
                $data_page['page_name'] = '店铺主页';
                $data_page['is_home'] = 1;
                $data_page['add_time'] = $_SERVER['REQUEST_TIME'];
                $data_page['has_custom'] = 1;
                $page_id = $database_page->data($data_page)->add();
                setHomePage($_SESSION['wap_drp_store']['store_id'], $page_id);
            }

            json_return(0, './drp_ucenter.php');
        } else {
            json_return(1001, '店铺编辑失败');
        }
    } else { //没有登录分销
        json_return(1000, './login.php');
    }
} else if (IS_POST && $_POST['type'] == 'add') { //添加分销店铺
    $product = M('Product');
    $product_image = M('Product_image');
    $product_sku = M('Product_sku');
    $product_group = M('Product_group');
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

    $supplier_id = isset($_POST['store_id']) ? intval(trim($_POST['store_id'])) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $pids = isset($_POST['pids']) ? explode(',', trim($_POST['pids'])) : array();
    $linkname = isset($_POST['truename']) ? trim($_POST['truename']) : '';
    $tel = isset($_POST['tel']) ? trim($_POST['tel']) : '';
    $qq = isset($_POST['qq']) ? trim($_POST['qq']) : '';
    $uid = $_SESSION['wap_user']['uid'];
    $haspassword = isset($_POST['haspassword']) ? trim($_POST['haspassword']) : '';
    $open_drp_approve = isset($_POST['open_drp_approve']) ? trim($_POST['open_drp_approve']) : false;
    //供货商店铺
    $supplier_store = $store->getStore($supplier_id);
    //获取供货商分销级别
    $drp_level = !empty($supplier_store['drp_level']) ? $supplier_store['drp_level'] : 0;
    //创建店铺
    $avatar = $user->getAvatarById($_SESSION['wap_user']['uid']);
    $drp_level = ($drp_level + 1);//分销级别
    $data = array();
    $data['uid']               = $uid;
    $data['name']              = $name;
    $data['sale_category_id']  = $supplier_store['sale_category_id'];
    $data['sale_category_fid'] = $supplier_store['sale_category_fid'];
    $data['linkman']           = $linkname;
    $data['tel']               = $tel;
    $data['status']            = 1;
    $data['qq']                = $qq;
    $data['drp_supplier_id']   = $supplier_id;
    $data['date_added']        = time();
    $data['drp_level']         = $drp_level;
    $data['logo']              = $avatar;
    //对接店铺
    if (!empty($_SESSION['sync_user'])) {
        $data['bind_weixin'] = 1; //已绑定微信
    }
    if ($open_drp_approve) {
        $data['drp_approve'] = 0; //需要审核
    }
    $result = $store->create($data);
    if (!empty($result['err_code'])) { //店铺添加成功
        $common_data->setStoreQty();
        if (empty($haspassword)) {
            //对接用户首次分销设置登录密码为手机号
            if ($user->setField(array('uid' => $uid), array('phone' => $tel, 'password' => md5($tel)))) {
                $_SESSION['wap_user']['phone'] = $tel;
            }
        }

        $store_id = $result['err_msg']['store_id']; //分销商id

        //对接店铺
        if (!empty($_SESSION['sync_user'])) { //更新source_site_url,payment_url,notify_url,oauth_url,is_seller,app_id,stores
            $tmp_data = array();
            $tmp_data['source_site_url'] = $supplier_store['source_site_url'];
            $tmp_data['payment_url']     = $supplier_store['payment_url'];
            $tmp_data['notify_url']      = $supplier_store['notify_url'];
            $tmp_data['oauth_url']       = $supplier_store['oauth_url'];
            $tmp_data['token']           = $supplier_store['token'];
            D('Store')->where(array('store_id' => $store_id))->data($tmp_data)->save();
        }

        //用户店铺数加1
        $user->setStoreInc($_SESSION['wap_user']['uid']);
        //设置为卖家
        $user->setSeller($_SESSION['wap_user']['uid'], 1);

        //主营类目店铺数加1
        $sale_category->setStoreInc($supplier_store['sale_category_id']);
        $sale_category->setStoreInc($supplier_store['sale_category_fid']);

        $current_seller = $store_supplier->getSeller(array('seller_id' => $store_id));

        if ($current_seller['supplier_id'] != $supplier_id) {
            $seller = $store_supplier->getSeller(array('seller_id' => $supplier_id)); //获取上级分销商信息
            if (empty($seller['type'])) { //全网分销的分销商
                $seller['supply_chain'] = 0;
                $seller['level'] = 0;
            }
            $seller['supply_chain'] = !empty($seller['supply_chain']) ? $seller['supply_chain'] : 0;
            $seller['level'] = !empty($seller['level']) ? $seller['level'] : 0;
            $supply_chain = !empty($supplier_id) ? $seller['supply_chain'] . ',' . $supplier_id : 0;
            $level = $seller['level'] + 1;
            $store_supplier->add(array('supplier_id' => $supplier_id, 'seller_id' => $store_id, 'supply_chain' => $supply_chain, 'level' => $level, 'type' => 1));//添加分销关联关系
        }
        if (empty($open_drp_approve)) {
            //添加分销商品
            $products = $product->supplierFxProducts(array('store_id' => $supplier_id, 'is_fx' => 1, 'status' => 1));
            $home_products = array();
            $step = 0;
            $fx_products = array();
            foreach ($products as $product_info) {
                if (!in_array($product_info['product_id'], $pids)) { //分销选择的商品
                    $product_id = $product_info['product_id'];
                    $data = $product_info;
                    unset($data['product_id']);
                    $data['name']                = mysql_real_escape_string($data['name']);
                    $data['uid']                 = $uid;
                    $data['store_id']            = $store_id;
                    $data['price']               = $product_info['min_fx_price'];
                    $data['is_fx']               = 0;
                    $data['source_product_id']   = $product_id;
                    $data['status']              = 1;
                    $data['date_added']          = time();
                    $data['supplier_id']         = $product_info['store_id'];
                    $data['pv']                  = 0;
                    $data['delivery_address_id'] = 0;
                    $data['sales']               = 0; //销量清零
                    $data['original_product_id'] = !empty($product_info['original_product_id']) ? $product_info['original_product_id'] : $product_id; //分销商品原始id
                    $data['is_fx_setting']       = 0;
                    if (!empty($product_info['unified_price_setting'])) {
                        $data['price']        = !empty($product_info['drp_level_' . $drp_level . '_price']) ? $product_info['drp_level_' . $drp_level . '_price'] : $product_info['price'];
                        $data['cost_price']   = !empty($product_info['drp_level_' . ($drp_level + 1) . '_cost_price']) ? $product_info['drp_level_' . ($drp_level + 1) . '_cost_price'] : $product_info['cost_price'];
                        $data['min_fx_price'] = !empty($product_info['drp_level_' . ($drp_level + 1) . '_price']) ? $product_info['drp_level_' . ($drp_level + 1) . '_price'] : $product_info['min_fx_price'];
                        $data['max_fx_price'] = !empty($product_info['drp_level_' . ($drp_level + 1) . '_price']) ? $product_info['drp_level_' . ($drp_level + 1) . '_price'] : $product_info['max_fx_price'];
                    }
                    if ($new_product_id = $product->add($data)) {

                        $fx_products[$product_id] = $new_product_id;

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
                        //商品分组
                        $groups = $product_group->get_all_list($supplier_id);
                        $to_groups = $product_to_group->getGroups($product_id);
                        $group_ids = array();
                        if ($groups && $to_groups) {
                            $to_group_ids = array();
                            foreach ($to_groups as $to_group) { //商品对应分组
                                $to_group_ids[] = $to_group['group_id'];
                            }

                            foreach ($groups as $group) {
                                if (in_array($group['group_id'], $to_group_ids)) { //有商品对应的分组
                                    $tmp_group = $group;
                                    unset($tmp_group['group_id']);
                                    $tmp_group['store_id'] = $store_id;
                                    $tmp_group['add_time'] = time();
                                    $group_id = $product_group->add($tmp_group); //copy分组
                                    $group_ids[$group['group_id']] = $group_id;
                                }
                            }

                            if (!empty($to_groups)) {
                                $group_products = array();
                                foreach ($to_groups as $to_group) {
                                    if (!empty($group_ids[$to_group['group_id']])) {
                                        if (empty($group_products[$group_ids[$to_group['group_id']]])) {
                                            $group_products[$group_ids[$to_group['group_id']]] = 0;
                                        } else {
                                            $group_products[$group_ids[$to_group['group_id']]] += 1;
                                        }
                                        $product_to_group->add(array('product_id' => $new_product_id, 'group_id' => $group_ids[$to_group['group_id']]));
                                    }
                                }
                                if (!empty($group_products)) { //更新分组下的商品数量
                                    foreach ($group_products as $group_id => $qty) {
                                        D('Product_group')->where(array('group_id' => $group_id))->data(array('product_count' => $qty))->save();
                                    }
                                }
                            }
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
                                    'properties' => $tmp_product_sku['properties'],
                                    'quantity' => $tmp_product_sku['quantity'],
                                    'price' => $tmp_product_sku['min_fx_price'],
                                    'code' => $tmp_product_sku['code'],
                                    'sales' => 0,
                                    'cost_price' => $tmp_product_sku['cost_price'],
                                    'min_fx_price' => $tmp_product_sku['min_fx_price'],
                                    'max_fx_price' => $tmp_product_sku['max_fx_price']
                                );
                                if (!empty($product_info['unified_price_setting'])) {
                                    $tmp_sku['price'] = !empty($tmp_product_sku['drp_level_' . $drp_level . '_price']) ? $tmp_product_sku['drp_level_' . $drp_level . '_price'] : $tmp_product_sku['price'];
                                    $tmp_sku['cost_price'] = !empty($tmp_product_sku['drp_level_' . ($drp_level + 1) . '_cost_price']) ? $tmp_product_sku['drp_level_' . ($drp_level + 1) . '_cost_price'] : $tmp_product_sku['cost_price'];
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
                    }
                }
            }
        }

        //copy供货商首页
        $database_page = D('Wei_page');
        $home_page = $database_page->where(array('store_id' => $supplier_id, 'is_home' => 1))->find();
        $data_page = $home_page;
        unset($data_page['page_id']);
        $data_page['store_id']  = $store_id;
        $data_page['page_name'] = '店铺主页';
        $data_page['add_time']  = $_SERVER['REQUEST_TIME'];
        $data_page['hits']      = 0;
        $page_id = $database_page->data($data_page)->add();

        if (!empty($page_id)) {
            if (empty($open_drp_approve)) {
                copyHomePage($store_id, $supplier_store, $page_id, $group_ids, $fx_products);
            }

            //print_r($data_fields);
            //默认首页
            /*$content = array();
            $content['size']         = 3;
            $content['buy_btn']      = 1;
            $content['buy_btn_type'] = 3;
            $content['price']        = 1;
            $content['goods']        = $home_products;
            $database_custom_field = D('Custom_field');
            $data_custom_field = array();
            $data_custom_field['store_id']    = $store_id;
            $data_custom_field['module_name'] = 'page';
            $data_custom_field['module_id']   = $page_id;
            $data_custom_field['field_type']  = 'goods';
            $data_custom_field['content']     = serialize($content);
            $database_custom_field->data(array('store_id' => $store_id, 'module_name' => 'page', 'module_id' => $page_id, 'field_type' => 'search', 'content' => serialize(array())))->add();
            $database_custom_field->data($data_custom_field)->add();*/
        } /*else { //富文本默认首页
            $database_custom_field = D('Custom_field');
            $data_custom_field['store_id'] = $store_id;
            $data_custom_field['module_name'] = 'page';
            $data_custom_field['module_id'] = $page_id;
            $data_custom_field['field_type'] = 'title';
            $data_custom_field['content'] = serialize(array('title'=>'初次认识微杂志','sub_title'=>date('Y-m-d H:i',$_SERVER['REQUEST_TIME'])));
            $database_custom_field->data($data_custom_field)->add();
            $data_custom_field['field_type'] = 'rich_text';
            $data_custom_field['content'] = serialize(array('content'=>'<p>感谢您使用'.option('config.site_name').'，在'.option('config.site_name').'里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration:underline;">下划线</span>、<span style="text-decoration:line-through;">删除线</span>、<span style="color:rgb(0,176,240);">文字颜色</span>、<span style="color:rgb(255,255,255);background-color:rgb(247,150,70);">背景色</span>、以及<span style="font-size:22px;">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class="firstRow"><td width="133" valign="top" style="word-break: break-all;">中奖客户</td><td width="133" valign="top" style="word-break:break-all;">发放奖品</td><td width="133" valign="top" style="word-break:break-all;">备注</td></tr><tr><td width="133" valign="top" style="word-break:break-all;">猪猪</td><td width="133" valign="top" style="word-break:break-all;">内测码</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(255,0,0);">已经发放</span></td></tr><tr><td width="133" valign="top" style="word-break:break-all;">大麦</td><td width="133" valign="top" style="word-break:break-all;">积分</td><td width="133" valign="top" style="word-break:break-all;"><span style="color:rgb(0,176,240);">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择'.option('config.site_name').'！</p>'));
            $database_custom_field->data($data_custom_field)->add();
        }*/

        //判断是否已经是分销商
        $flag = false;
        if (!empty($_SESSION['wap_user']['uid'])) {
            $uid = $_SESSION['wap_user']['uid'];
            if ($store_info = $store->getUserDrpStore($uid, $store_id, 0)) { //已有分销店铺，跳转到分销管理页面
                $_SESSION['wap_drp_store'] = $store_info;
                $flag = true;
            }

            $common_data->setDrpSellerQty();
        }
        if ($flag) {
            json_return(0, './drp_ucenter.php');
        } else {
            json_return(1001, '店铺创建失败');
        }
    } else {
        json_return(1001, '店铺创建失败');
    }
} else if (IS_GET && $_GET['a'] == 'view' && isset($_GET['level'])) {
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }
    $store_supplier = M('Store_supplier');
    $store_model = M('Store');
    $order = M('Order');
    $fx_order = M('Fx_order');

    $level = isset($_GET['level']) ? trim(trim($_GET['level'])) : 1;
    $levels = array(1 => '一', 2 => '二');
    $store = $_SESSION['wap_drp_store'];
    $store_url = option('config.wap_site_url') . '/home.php?id=' . $store['store_id'];

    //当前分销商级别
    $store_id = $store['store_id'];
    $seller = $store_supplier->getSeller(array('seller_id' => $store_id));
    $seller_level = $seller['level'];
    $sub_level = $seller_level + $level;

    $where = array();
    $where['level'] = $sub_level;
    $where['_string'] = 'FIND_IN_SET(' . $store_id . ', supply_chain)';
    $tmp_sub_sellers = $store_supplier->getSellers($where);
    $sub_sellers = array();
    foreach ($tmp_sub_sellers as $tmp_sub_seller) {
        $store_info = $store_model->getStore($tmp_sub_seller['seller_id']);
        //$order_total = $order->getOrderAmount(array('store_id' => $tmp_sub_seller['seller_id'], 'status' => array('in', array(2,3,4))));
        $order_total = $fx_order->getSales(array('store_id' => $tmp_sub_seller['seller_id'], 'status' => array('in', array(1,2,3,4))));
        $sub_sellers[] = array(
            'store_id'    => $tmp_sub_seller['seller_id'],
            'name'        => $store_info['name'],
            'order_total' => $order_total,
            'tel'         => $store_info['tel']
        );
    }

    include display('drp_store_level_view');
    echo ob_get_clean();

} else if (IS_GET && isset($_GET['level'])) { //下级分销店铺
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }
    $store_supplier = M('Store_supplier');
    $order = M('Order');
    $user = M('User');
    $fx_order = M('Fx_order');
    $product = M('Product');

    $level = isset($_GET['level']) ? trim(trim($_GET['level'])) : 1;

    $store = $_SESSION['wap_drp_store'];
    $levels = array(1 => '一', 2 => '二');
    //当前分销商级别
    $store_id = $store['store_id'];
    $seller = $store_supplier->getSeller(array('seller_id' => $store_id));
    $seller_level = $seller['level'];
    $sub_level = $seller_level + $level;
    $where = array();
    $where['level'] = $sub_level;
    $where['_string'] = 'FIND_IN_SET(' . $store_id . ', supply_chain)';
    $sub_sellers = $store_supplier->getSellers($where);
    $order_count = 0; //订单数量（已支付）
    $fans_count = 0; //粉丝数量
    $order_total = 0; //订单总额（已支付）
    foreach ($sub_sellers as $sub_seller) {
        //$tmp_order_count = $order->getOrderCount(array('store_id' => $sub_seller['seller_id'], 'status' => array('in', array(2,3,4))));
        $tmp_order_count = $fx_order->getOrderCount(array('store_id' => $sub_seller['seller_id'], 'status' => array('in', array(2,3,4))));
        $order_count += $tmp_order_count;
        $tmp_product_count = $product->getSellingTotal(array('store_id' => $sub_seller['seller_id']));
        $product_count += $tmp_product_count;
        //$tmp_order_total = $order->getOrderAmount(array('store_id' => $sub_seller['seller_id'], 'status' => array('in', array(2,3,4))));
        $tmp_order_total = $fx_order->getSales(array('store_id' => $sub_seller['seller_id'], 'status' => array('in', array(1,2,3,4))));
        $order_total += $tmp_order_total;
    }
    $sub_sellers = count($sub_sellers);

    include display('drp_store_level');
    echo ob_get_clean();

}  else if ($_GET['a'] == 'sales') {
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }
    $fx_order = M('Fx_order');
    $store = $_SESSION['wap_drp_store'];
    $type = !empty($_GET['type']) ? trim($_GET['type']) : '';
    if (strtolower($type) == 'today'){ //今日销售额
        //今日销售额 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
        //00:00-6:00
        $starttime = strtotime(date('Y-m-d') . ' 00:00:00');
        $stoptime = strtotime(date('Y-m-d') . ' 06:00:00');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $todaysaletotal_0_6 = $fx_order->getSales($where);
        if (!$todaysaletotal_0_6) {
            $todaysaletotal_0_6 = 0;
        }
        //6:00-12:00
        $starttime = strtotime(date('Y-m-d') . ' 06:00:00');
        $stoptime = strtotime(date('Y-m-d') . ' 12:00:00');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $todaysaletotal_6_12 = $fx_order->getSales($where);
        if (!$todaysaletotal_6_12) {
            $todaysaletotal_6_12 = 0;
        }
        //12:00-18:00
        $starttime = strtotime(date('Y-m-d') . ' 12:00:00');
        $stoptime = strtotime(date('Y-m-d') . ' 18:00:00');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $todaysaletotal_12_18 = $fx_order->getSales($where);
        if (!$todaysaletotal_12_18) {
            $todaysaletotal_12_18 = 0;
        }
        //18:00-24:00
        $starttime = strtotime(date('Y-m-d') . ' 18:00:00');
        $stoptime = strtotime(date('Y-m-d') . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $todaysaletotal_18_24 = $fx_order->getSales($where);
        if (!$todaysaletotal_18_24) {
            $todaysaletotal_18_24 = 0;
        }

        $todaysaletotal = "[" . number_format($todaysaletotal_0_6, 2, '.', '') . ',' . number_format($todaysaletotal_6_12, 2, '.', '') . ',' . number_format($todaysaletotal_12_18, 2, '.', '') . ',' . number_format($todaysaletotal_18_24, 2, '.', '') ."]";
        echo $todaysaletotal;
        exit;
    } else if (strtolower($type) == 'yesterday') { //昨日销售额
        //昨日销售额 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
        $date = date('Y-m-d' , strtotime('-1 day'));
        //00:00-6:00
        $starttime = strtotime($date . ' 00:00:00');
        $stoptime = strtotime($date . ' 06:00:00');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $yesterdaysaletotal_0_6 = $fx_order->getSales($where);
        if (!$yesterdaysaletotal_0_6) {
            $yesterdaysaletotal_0_6 = 0;
        }
        //6:00-12:00
        $starttime = strtotime($date . ' 06:00:00');
        $stoptime = strtotime($date . ' 12:00:00');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $yesterdaysaletotal_6_12 = $fx_order->getSales($where);
        if (!$yesterdaysaletotal_6_12) {
            $yesterdaysaletotal_6_12 = 0;
        }
        //12:00-18:00
        $starttime = strtotime($date . ' 12:00:00');
        $stoptime = strtotime($date . ' 18:00:00');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $yesterdaysaletotal_12_18 = $fx_order->getSales($where);
        if (!$yesterdaysaletotal_12_18) {
            $yesterdaysaletotal_12_18 = 0;
        }
        //18:00-24:00
        $starttime = strtotime($date . ' 18:00:00');
        $stoptime = strtotime($date . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $yesterdaysaletotal_18_24 = $fx_order->getSales($where);
        if (!$yesterdaysaletotal_18_24) {
            $yesterdaysaletotal_18_24 = 0;
        }

        $yesterdaysaletotal = "[" . number_format($yesterdaysaletotal_0_6, 2, '.', '') . ',' . number_format($yesterdaysaletotal_6_12, 2, '.', '') . ',' . number_format($yesterdaysaletotal_12_18, 2, '.', '') . ',' . number_format($yesterdaysaletotal_18_24, 2, '.', '') ."]";
        echo $yesterdaysaletotal;
        exit;
    } else if (strtolower($type) == 'week') {
        $date = date('Y-m-d');  //当前日期
        $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期

        //周一销售额
        $starttime = strtotime($now_start . ' 00:00:00');
        $stoptime = strtotime($now_start . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_1 = $fx_order->getSales($where);
        if (!$weeksaletotal_1) {
            $weeksaletotal_1 = 0;
        }
        //周二销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 00:00:00');
        $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_2 = $fx_order->getSales($where);
        if (!$weeksaletotal_2) {
            $weeksaletotal_2 = 0;
        }
        //周三销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 00:00:00');
        $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_3 = $fx_order->getSales($where);
        if (!$weeksaletotal_3) {
            $weeksaletotal_3 = 0;
        }
        //周四销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 00:00:00');
        $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_4 = $fx_order->getSales($where);
        if (!$weeksaletotal_4) {
            $weeksaletotal_4 = 0;
        }
        //周五销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 00:00:00');
        $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_5 = $fx_order->getSales($where);
        if (!$weeksaletotal_5) {
            $weeksaletotal_5 = 0;
        }
        //周六销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 00:00:00');
        $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_6 = $fx_order->getSales($where);
        if (!$weeksaletotal_6) {
            $weeksaletotal_6 = 0;
        }
        //周日销售额
        $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 00:00:00');
        $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $weeksaletotal_7 = $fx_order->getSales($where);
        if (!$weeksaletotal_7) {
            $weeksaletotal_7 = 0;
        }

        $weeksaletotal = "[" . number_format($weeksaletotal_1, 2, '.', '') . ',' . number_format($weeksaletotal_2, 2, '.', '') . ',' . number_format($weeksaletotal_3, 2, '.', '') . ',' . number_format($weeksaletotal_4, 2, '.', '') . ',' . number_format($weeksaletotal_5, 2, '.', '') . ',' . number_format($weeksaletotal_6, 2, '.', '') . ',' . number_format($weeksaletotal_7, 2, '.', '') ."]";
        echo $weeksaletotal;
        exit;
    } else if (strtolower($type) == 'month') { //当月销售额
        $month = date('m');
        $year = date('Y');
        //1-7日
        $starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
        $stoptime = strtotime($year . '-' . $month . '-07' . ' 00:00:00');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $monthsaletotal_1_7 = $fx_order->getSales($where);
        if (!$monthsaletotal_1_7) {
            $monthsaletotal_1_7 = 0;
        }
        //7-14日
        $starttime = strtotime($year . '-' . $month . '-07' . ' 00:00:00');
        $stoptime = strtotime($year . '-' . $month . '-14' . ' 00:00:00');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $monthsaletotal_7_14 = $fx_order->getSales($where);
        if (!$monthsaletotal_7_14) {
            $monthsaletotal_7_14 = 0;
        }
        //14-21日
        $starttime = strtotime($year . '-' . $month . '-14' . ' 00:00:00');
        $stoptime = strtotime($year . '-' . $month . '-21' . ' 00:00:00');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $monthsaletotal_14_21 = $fx_order->getSales($where);
        if (!$monthsaletotal_14_21) {
            $monthsaletotal_14_21 = 0;
        }
        //21-本月结束
        //当月最后一天
        $lastday = date('t',time());
        $starttime = strtotime($year . '-' . $month . '-21' . ' 00:00:00');
        $stoptime = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
        $where = array();
        $where['store_id'] = $store['store_id'];
        $where['status'] = array('in', array(1,2,3,4));
        $where['_string'] = "paid_time >= " . $starttime . " AND paid_time < " . $stoptime;
        $monthsaletotal_21_end = $fx_order->getSales($where);
        if (!$monthsaletotal_21_end) {
            $monthsaletotal_21_end = 0;
        }
        $data = array();
        $monthsaletotal = "[" . number_format($monthsaletotal_1_7, 2, '.', '') . ',' . number_format($monthsaletotal_7_14, 2, '.', '') . ',' . number_format($monthsaletotal_14_21, 2, '.', '') . ',' . number_format($monthsaletotal_21_end, 2, '.', '') ."]";
        $data['monthsaletotal'] = $monthsaletotal;
        $data['lastday'] = $lastday;
        echo json_encode(array('data' => $data));
        exit;
    }

    //店铺销售额
    $sales = $fx_order->getSales(array('store_id' => $store['store_id'], 'status' => array('in', array(1,2,3,4))));
    $store['sales'] = number_format($sales, 2, '.', '');

    include display('drp_store_sales');
    echo ob_get_clean();

} else if (strtolower($_GET['a']) == 'select') {
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }

    $store = $_SESSION['wap_drp_store'];
    $store_id = $store['store_id'];
    $store_model = M('Store');
    $fx_order = M('Fx_order');
    $store_supplier = M('Store_supplier');
    $financial_record = M('Financial_record');
    if (!empty($_GET['id'])) {
        $store_info = $store_model->getUserDrpStore($store['uid'], intval(trim($_GET['id'])), 0);
        if ($store_info = $store_model->getUserDrpStore($store['uid'], intval(trim($_GET['id'])), 0)) { //已有分销店铺，跳转到分销管理页面
            $_SESSION['wap_drp_store'] = $store_info;
            redirect('./drp_ucenter.php');
        } else {
            redirect('./drp_ucenter.php');
        }
    }

    //店铺销售额
    $sales = $fx_order->getSales(array('store_id' => $store['store_id'], 'status' => array('in', array(1,2,3,4))));
    $store['sales'] = number_format($sales, 2, '.', '');
    //店铺余额
    $balance = $financial_record->drpProfit(array('store_id' => $store['store_id']));
    $store['balance'] = number_format($balance, 2, '.', '');

    $drp_approve = true;
    //供货商
    if (!empty($store['drp_supplier_id'])) {
        $supplier = $store_model->getStore($store['drp_supplier_id']);
        $store['supplier'] = $supplier['name'];

        if (!empty($supplier['open_drp_approve']) && empty($store['drp_approve'])) { //需要审核，但未审核
            $drp_approve = false;
        }
    }
    $uid = $store['uid'];
    $stores = $store_model->getUserDrpStores($uid, 0, 0);

    include display('drp_store_select');
    echo ob_get_clean();

} else if ($_GET['a'] == 'account') {
    if (empty($_SESSION['wap_drp_store'])) {
        redirect('./ucenter.php?id=' . intval(trim($_COOKIE['wap_store_id'])));
    }

    $store = $_SESSION['wap_drp_store'];
    $store_id = $store['store_id'];
    $store_model = M('Store');
    $fx_order = M('Fx_order');
    $store_supplier = M('Store_supplier');
    $financial_record = M('Financial_record');
    $user = M('User');

    $store_info = $store_model->getStore($store_id);

    //店铺销售额
    $sales = $fx_order->getSales(array('store_id' => $store['store_id'], 'status' => array('in', array(1,2,3,4))));
    $store['sales'] = number_format($sales, 2, '.', '');
    //店铺余额
    //$balance = $financial_record->drpProfit(array('store_id' => $store['store_id']));
    //$store['balance'] = number_format($balance, 2, '.', '');
    $balance = !empty($store_info['drp_profit']) ? $store_info['drp_profit'] : 0;
    $store['balance'] = number_format($balance, 2, '.', '');

    $drp_approve = true;
    //供货商
    if (!empty($store['drp_supplier_id'])) {
        $supplier = $store_model->getStore($store['drp_supplier_id']);
        $store['supplier'] = $supplier['name'];

        if (!empty($supplier['open_drp_approve']) && empty($store['drp_approve'])) { //需要审核，但未审核
            $drp_approve = false;
        }
    }
    $uid = $store['uid'];
    $user_info = $user->checkUser(array('uid' => $uid));
    $phone = $user_info['phone'];
    $password = false;
    if (md5($phone) != $user_info['password']) {
        $password = true; //有新密码
    }
    $admin_url = '';
    //对接用户
    if (!empty($store_info['source_site_url'])) {
        $admin_url = $store_info['source_site_url']  . '/api/weidian.php';
    } else {
        $admin_url = option('config.site_url') . '/account.php';
    }

    include display('drp_store_account');
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'check_store') { //店铺名检测
    $store = M('Store');
    $where = array();
    if (!empty($_SESSION['wap_drp_store'])) {
        $where['store_id'] = array('!=', $_SESSION['wap_drp_store']['store_id']);
    }
    $where['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
    $where['status'] = 1;
    if ($store->checkStoreExist($where)) {
        echo false;
    } else {
        echo true;
    }
    exit;
} else if (strtolower($_GET['a']) == 'reset_pwd') { //重置为初始密码
    if (empty($_SESSION['wap_drp_store'])) {
        pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
    }
    $user = M('User');

    $store = $_SESSION['wap_drp_store'];
    $user_info = $user->checkUser(array('uid' => $store['uid']));
    if (D('User')->where(array('uid' => $user_info['uid']))->data(array('password' => md5($user_info['phone'])))->save()) {
        redirect('./drp_ucenter.php');
    } else {
        redirect('./drp_store.php?a=account');
    }
} else if (IS_GET && $_GET['a'] == 'logout') {
    $store_id = $_SESSION['wap_drp_store']['store_id'];
    unset($_SESSION['wap_drp_store']);
    redirect('./ucenter.php?id=' . $store_id);
}

function setHomePage($store_id, $page_id)
{
    $fx_products = $products = D('Product')->where(array('store_id' => $store_id, 'status' => 1, 'supplier_id' => array('>', 0)))->order('product_id DESC')->limit(15)->select();
    $home_products = array();
    if (!empty($fx_products)) {
        foreach ($fx_products as $fx_product) {
            $home_products[] = array(
                'id' => $fx_product['product_id'],
                'title' => htmlspecialchars($fx_product['name'], ENT_QUOTES),
                'price' => $fx_product['price'],
                'url' => option('config.wap_site_url') . '/good.php?id=' . $fx_product['product_id'],
                'image' => $fx_product['image']
            );
        }
    }
    $content = array();
    $content['size']         = 3;
    $content['buy_btn']      = 1;
    $content['buy_btn_type'] = 3;
    $content['price']        = 1;
    $content['goods']        = $home_products;
    $database_custom_field = D('Custom_field');
    $data_custom_field = array();
    $data_custom_field['store_id']    = $store_id;
    $data_custom_field['module_name'] = 'page';
    $data_custom_field['module_id']   = $page_id;
    $data_custom_field['field_type']  = 'goods';
    $data_custom_field['content']     = serialize($content);
    $search_module = $database_custom_field->where(array('module_id' => $page_id, 'store_id' => $store_id, 'field_type' => 'search'))->find();
    $home_module = $database_custom_field->where(array('module_id' => $page_id, 'store_id' => $store_id, 'field_type' => 'goods'))->find();
    if (empty($search_module) && empty($home_module)) {
        $database_custom_field->data(array('store_id' => $store_id, 'module_name' => 'page', 'module_id' => $page_id, 'field_type' => 'search', 'content' => serialize(array())))->add();
    }
    if (empty($home_module)) {
        $database_custom_field->data($data_custom_field)->add();
    } else {
        $database_custom_field->where(array('field_id' => $home_module['field_id']))->data($data_custom_field)->save();
    }
}

/**
 * @param $store_id
 * @param $supplier
 * @param $page_id
 * @param $group_ids
 * @param $fx_products
 * @return bool|int|string
 */
function copyHomePage($store_id, $supplier, $page_id, $group_ids, $fx_products)
{
    //供货商微页面
    $homePage = D('Wei_page')->where(array('is_home' =>1, 'store_id' => $supplier['store_id']))->find();
    //微杂志的自定义字段
    if($homePage['has_custom']){
        $field_list = M('Custom_field')->get_field($supplier['store_id'],'page',$homePage['page_id']);
        if (!empty($field_list)) {
            $data_fields = array();
            foreach ($field_list as $key => $field) {
                switch($field['field_type']){
                    case 'title': //标题
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = serialize($field['content']);
                        break;
                    case 'rich_text': //富文本
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = serialize($field['content']);
                        break;
                    case 'notice': //公告
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = serialize($field['content']);
                        break;
                    case 'line': //辅助线
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = serialize($field['content']);
                        break;
                    case 'white': //辅助空白
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = serialize($field['content']);
                        break;
                    case 'search': //商品搜索
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = serialize($field['content']);
                        break;
                    case 'store': //进入店铺
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = serialize($field['content']);
                        break;
                    case 'text_nav': //文本导航
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = array();

                        $text_navs = array();
                        foreach ($field['content'] as $nav) {
                            switch ($nav['prefix']) {
                                case '商品分组':
                                    $params = convertUrlQuery($nav['url']);
                                    $group_id = !empty($params['id']) ? $params['id'] : '';
                                    if (!empty($group_id) && !empty($group_ids[$group_id])) { //分组id
                                        $my_group_id = $group_ids[$group_id];
                                        $nav['url'] = preg_replace('/goodcat\.php\?id=(\d+)/is', 'goodcat.php?id=' . $my_group_id, $nav['url']);
                                    } else {
                                        continue 2;
                                    }
                                    break;
                                case '商品':
                                    $params = convertUrlQuery($nav['url']);
                                    if (!empty($params['id'])) { //商品id
                                        $product_id = $params['id'];
                                        if (empty($fx_products[$product_id])) {
                                            $my_product_id = $fx_products[$product_id];
                                            $nav['url'] = preg_replace('/good\.php\?id=(\d+)/is', 'good.php?id=' . $my_product_id, $nav['url']);
                                        } else { //商品不存在或非分销商品
                                            //$nav['url'] = '#';
                                            continue 2;
                                        }
                                    }
                                    break;
                                case '店铺主页':
                                    $nav['url'] = preg_replace('/home\.php\?id=(\d+)/is', 'home.php?id=' . $store_id, $nav['url']);
                                    break;
                                case '会员主页':
                                    $nav['url'] = preg_replace('/ucenter\.php\?id=(\d+)/is', 'ucenter.php?id=' . $store_id, $nav['url']);
                                    break;
                                case '外链': //过滤站内链接
                                    if (stripos($nav['url'], option('config.site_url')) !== false) {
                                        //$nav['url'] = '#';
                                        continue 2;
                                    }
                                    break;
                                case '微页面':
                                    //$nav['url'] = '#';
                                    continue 2;
                                    break;
                                case '微页面分类':
                                    //$nav['url'] = '#';
                                    continue 2;
                                    break;
                            }
                            $text_navs[] = array(
                                'title'  => $nav['title'],
                                'name'   => htmlspecialchars($nav['name'], ENT_QUOTES),
                                'prefix' => $nav['prefix'],
                                'url'    => $nav['url']
                            );
                        }
                        $data_fields[$key]['content'] = serialize($text_navs);
                        break;
                    case 'image_nav': //图片导航
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = array();

                        $image_navs = array();
                        foreach ($field['content'] as $nav) {
                            switch ($nav['prefix']) {
                                case '商品分组':
                                    $params = convertUrlQuery($nav['url']);
                                    $group_id = !empty($params['id']) ? $params['id'] : '';
                                    if (!empty($group_id) && !empty($group_ids[$group_id])) { //分组id
                                        $my_group_id = $group_ids[$group_id];
                                        $nav['url'] = preg_replace('/goodcat\.php\?id=(\d+)/is', 'goodcat.php?id=' . $my_group_id, $nav['url']);
                                    } else {
                                        $nav['url'] = '#';
                                    }
                                    break;
                                case '商品':
                                    $params = convertUrlQuery($nav['url']);
                                    if (!empty($params['id'])) { //商品id
                                        $product_id = $params['id'];
                                        if (empty($fx_products[$product_id])) {
                                            $my_product_id = $fx_products[$product_id];
                                            $nav['url'] = preg_replace('/good\.php\?id=(\d+)/is', 'good.php?id=' . $my_product_id, $nav['url']);
                                        } else { //商品不存在或非分销商品
                                            $nav['url'] = '#';
                                        }
                                    }
                                    break;
                                case '店铺主页':
                                    $nav['url'] = preg_replace('/home\.php\?id=(\d+)/is', 'home.php?id=' . $store_id, $nav['url']);
                                    break;
                                case '会员主页':
                                    $nav['url'] = preg_replace('/ucenter\.php\?id=(\d+)/is', 'ucenter.php?id=' . $store_id, $nav['url']);
                                    break;
                                case '外链': //过滤站内链接
                                    if (stripos($nav['url'], option('config.site_url')) !== false) {
                                        $nav['url'] = '#';
                                    }
                                    break;
                                case '微页面':
                                    $nav['url'] = '#';
                                    break;
                                case '微页面分类':
                                    $nav['url'] = '#';
                                    break;
                            }
                            $image_navs[] = array(
                                'title'  => $nav['title'],
                                'name'   => htmlspecialchars($nav['name'], ENT_QUOTES),
                                'prefix' => $nav['prefix'],
                                'url'    => $nav['url'],
                                'image'  => $nav['image']
                            );
                        }
                        $data_fields[$key]['content'] = serialize($image_navs);
                        break;
                    case 'link': //关联链接
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = array();

                        $links = array();
                        foreach ($field['content'] as $link) {
                            switch ($link['prefix']) {
                                case '微页面分类':
                                    $links[] = array(
                                        'id'     => $store_id,
                                        'number' => $link['number'],
                                        'name'   => $link['name'],
                                        'url'    => '#',
                                        'prefix' => $link['prefix'],
                                        'type'   => $link['type'],
                                        'widget' => $link['widget'],
                                        'title'  => $link['title']
                                    );
                                    break;
                                case '商品分组':
                                    if (!empty($group_ids[$link['id']])) {
                                        $link['id'] = $group_ids[$link['id']];
                                        $link['url'] = preg_replace('/goodcat\.php\?id=(\d+)/is', 'goodcat.php?id=' . $link['id'], $link['url']);
                                    } else {
                                        $link['id'] =  $store_id;
                                        $link['url'] = '#';
                                    }
                                    $links[] = array(
                                        'id'     => $link['id'],
                                        'number' => $link['number'],
                                        'name'   => $link['name'],
                                        'url'    => $link['url'],
                                        'prefix' => $link['prefix'],
                                        'type'   => $link['type'],
                                        'widget' => $link['widget'],
                                        'title'  => $link['title']
                                    );
                                    break;
                                case '外链':
                                    if (stripos($link['url'], option('config.site_url')) !== false) {
                                        $link['url'] = '#';
                                    }
                                    $links[] = array(
                                        'name'   => $link['name'],
                                        'url'    => $link['url'],
                                        'prefix' => $link['prefix'],
                                        'type'   => $link['type'],
                                        'title'  => $link['title']
                                    );
                                    break;
                                case '':
                                    $links[] = array(
                                        'name'   => $link['name'],
                                        'url'    => $link['url'],
                                        'prefix' => $link['prefix'],
                                        'title'  => $link['title']
                                    );
                                    break;
                            }

                        }
                        $data_fields[$key]['content'] = serialize($links);
                        break;
                    case 'image_ad': //图片广告
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = array();

                        $image_ads = array();
                        $image_ads['max_height'] = $field['content']['max_height'];
                        $image_ads['max_width']  = $field['content']['max_width'];
                        $image_ads['nav_list']   = array();
                        foreach ($field['content']['nav_list'] as $nav) {
                            switch ($nav['prefix']) {
                                case '商品分组':
                                    $params = convertUrlQuery($nav['url']);
                                    $group_id = !empty($params['id']) ? $params['id'] : '';
                                    if (!empty($group_id) && !empty($group_ids[$group_id])) { //分组id
                                        $my_group_id = $group_ids[$group_id];
                                        $nav['url'] = preg_replace('/goodcat\.php\?id=(\d+)/is', 'goodcat.php?id=' . $my_group_id, $nav['url']);
                                    } else {
                                        $nav['url'] = '#';
                                    }
                                    break;
                                case '商品':
                                    $params = convertUrlQuery($nav['url']);
                                    if (!empty($params['id'])) { //商品id
                                        $product_id = $params['id'];
                                        if (empty($fx_products[$product_id])) {
                                            $my_product_id = $fx_products[$product_id];
                                            $nav['url'] = preg_replace('/good\.php\?id=(\d+)/is', 'good.php?id=' . $my_product_id, $nav['url']);
                                        } else { //商品不存在或非分销商品
                                            $nav['url'] = '#';
                                        }
                                    }
                                    break;
                                case '店铺主页':
                                    $nav['url'] = preg_replace('/home\.php\?id=(\d+)/is', 'home.php?id=' . $store_id, $nav['url']);
                                    break;
                                case '会员主页':
                                    $nav['url'] = preg_replace('/ucenter\.php\?id=(\d+)/is', 'ucenter.php?id=' . $store_id, $nav['url']);
                                    break;
                                case '微页面':
                                    $nav['url'] = '#';
                                    break;
                                case '微页面分类':
                                    $nav['url'] = '#';
                                    break;
                                case '外链':
                                    if (stripos($nav['url'], option('config.site_url')) !== false) {
                                        $nav['url'] = '#';
                                    }
                                    break;
                            }
                            $image_ads['nav_list'][] = $nav;
                        }
                        $data_fields[$key]['content'] = serialize($image_ads);
                        break;
                    case 'goods': //商品
                        $data_fields[$key]['store_id']    = $store_id;
                        $data_fields[$key]['module_name'] = htmlspecialchars($field['module_name'], ENT_QUOTES);
                        $data_fields[$key]['module_id']   = $page_id;
                        $data_fields[$key]['field_type']  = $field['field_type'];
                        $data_fields[$key]['content']     = array();

                        $content = array();
                        $content['size']         = $field['content']['size']; //大小
                        $content['buy_btn']      = $field['content']['buy_btn']; //是否显示购买按钮
                        $content['buy_btn_type'] = $field['content']['buy_btn_type']; //购买按钮样式
                        $content['price']        = $field['content']['price']; //是否显示价格

                        $goods = array();
                        if (!empty($field['content']['goods'])) {
                            $good_qty = count($field['content']['goods']); //首页商品数量
                            $not_fx_goods = array(); //首页非分销商品
                            $is_fx_goods = array(); //所有分销商品
                            $i = 0;
                            foreach ($field['content']['goods'] as $key2 => $good) {
                                if (!empty($fx_products[$good['id']])) { //分销商品
                                    $goods[$i]['id']    = $fx_products[$good['id']];
                                    $goods[$i]['title'] = htmlspecialchars($good['title'], ENT_QUOTES);
                                    $goods[$i]['image'] = $good['image'];
                                    $tmp_product = M('Product')->get(array('product_id' => $fx_products[$good['id']]), 'price');
                                    $goods[$i]['price'] = !empty($tmp_product['price']) ? $tmp_product['price'] : $good['price'];
                                    $goods[$i]['url']   = preg_replace('/good\.php\?id=(\d+)/is', 'good.php?id=' . $fx_products[$good['id']], $good['url']);
                                    $is_fx_goods = $fx_products;
                                    unset($is_fx_goods[$good['id']]);
                                    $i++;
                                } else { //首页非分销商品
                                    $not_fx_goods[] = $good['id'];
                                }
                            }
                            if (!empty($not_fx_goods) && !empty($is_fx_goods)) { //首页有非分销商品
                                $not_fx_good_qty = count($not_fx_goods); //首页非分销商品数量
                                $j = 0;
                                foreach ($is_fx_goods as $good) {
                                    if ($j < $not_fx_good_qty) { //首页非分销商品所占位置使用非首页分销商品替换，同时保持首页原商品个数
                                        $tmp_product = M('Product')->get(array('product_id' => $good), 'price,name,image');
                                        if ($tmp_product) {
                                            $goods[$i]['id']    = $good;
                                            $goods[$i]['title'] = htmlspecialchars($tmp_product['name'], ENT_QUOTES);
                                            $goods[$i]['image'] = $tmp_product['image'];
                                            $goods[$i]['price'] = $tmp_product['price'];
                                            $goods[$i]['url']   = option('config.wap_site_url') . '/good.php?id=' . $good;
                                            $i++;
                                        }
                                    }
                                    $j++;
                                }
                            }
                        }
                        $content['goods'] = $goods;
                        $data_fields[$key]['content'] = serialize($content);
                        break;
                    case 'component': //自定义模块
                        //暂不支持
                        break;
                }
            }
            $result = false;
            if (!empty($data_fields)) {
                $result = D('Custom_field')->data($data_fields)->addAll();
            }
            $data_fields = array();
            //公共广告（仅支持图片广告）
            if (!empty($supplier['open_ad'])) {
                $ad_list = M('Custom_field')->get_field($supplier['store_id'], 'common_ad', $supplier['store_id']);
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
                                    switch ($nav['prefix']) {
                                        case '商品分组':
                                            $params = convertUrlQuery($nav['url']);
                                            $group_id = !empty($params['id']) ? $params['id'] : '';
                                            if (!empty($group_id) && !empty($group_ids[$group_id])) { //分组id
                                                $my_group_id = $group_ids[$group_id];
                                                $nav['url'] = preg_replace('/goodcat\.php\?id=(\d+)/is', 'goodcat.php?id=' . $my_group_id, $nav['url']);
                                            } else {
                                                $nav['url'] = '#';
                                            }
                                            break;
                                        case '商品':
                                            $params = convertUrlQuery($nav['url']);
                                            if (!empty($params['id'])) { //商品id
                                                $product_id = $params['id'];
                                                if (empty($fx_products[$product_id])) {
                                                    $my_product_id = $fx_products[$product_id];
                                                    $nav['url'] = preg_replace('/good\.php\?id=(\d+)/is', 'good.php?id=' . $my_product_id, $nav['url']);
                                                } else { //商品不存在或非分销商品
                                                    $nav['url'] = '#';
                                                }
                                            }
                                            break;
                                        case '店铺主页':
                                            $nav['url'] = preg_replace('/home\.php\?id=(\d+)/is', 'home.php?id=' . $store_id, $nav['url']);
                                            break;
                                        case '会员主页':
                                            $nav['url'] = preg_replace('/ucenter\.php\?id=(\d+)/is', 'ucenter.php?id=' . $store_id, $nav['url']);
                                            break;
                                        case '微页面':
                                            $nav['url'] = '#';
                                            break;
                                        case '微页面分类':
                                            $nav['url'] = '#';
                                            break;
                                        case '外链':
                                            if (stripos($nav['url'], option('config.site_url')) !== false) {
                                                $nav['url'] = '#';
                                            }
                                            break;
                                    }
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
    }
}