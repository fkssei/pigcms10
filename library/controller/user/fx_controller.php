<?php
class fx_controller extends base_controller
{
	public function __construct()
	{
		parent::__construct();

        if (!$this->enabled_drp()) {
            redirect('store:index');
        }

        //是否允许设置商品再次分销
        if ((!empty($this->store_session['drp_supplier_id']) && $this->checkDrp(true))) {
            $fx_again = true;
        } else {
            $fx_again = false;
        }
        $is_supplier = false;
        if (((!empty($this->store_session['drp_supplier_id']) && $this->checkDrp(true))) || empty($this->store_session['drp_supplier_id'])) {
            $is_supplier = true;
        }
        $this->assign('fx_again', $fx_again);
        $this->assign('is_supplier', $is_supplier);
	}

    public function load()
    {
        $action = strtolower(trim($_POST['page']));
        $start_time = isset($_POST['start_time']) ? trim($_POST['start_time']) : '';
        $stop_time = isset($_POST['stop_time']) ? trim($_POST['stop_time']) : '';
        $store_id = isset($_POST['store_id']) ? trim($_POST['store_id']) : $this->store_session['store_id'];
        if (empty($action)) pigcms_tips('非法访问！', 'none');
        switch ($action) {
            case 'index_content':
                $this->_index_content();
                break;
            case 'market_content':
                $this->_market_content();
                break;
            case 'goods_content':
                $this->_goods_content();
                break;
            case 'orders_content':
                $this->_orders_content();
                break;
            case 'order_detail_content':
                $this->_order_detail_content();
                break;
            case 'pay_order_content':
                $this->_pay_order_content();
                break;
            case 'supplier_content':
                $this->_supplier_content();
                break;
            case 'supplier_goods_content':
                $this->_supplier_goods_content();
                break;
            case 'goods_fx_setting_content':
                $this->_goods_fx_setting_content();
                break;
            case 'supplier_market_content':
                $this->_supplier_market_content();
                break;
            case 'edit_goods_content':
                $this->_edit_goods_content();
                break;
            case 'seller_content':
                $this->_seller_content();
                break;
            case 'statistics_content':
                $this->_statistics_content(array('start_time' => $start_time, 'stop_time' => $stop_time, 'store_id' => $store_id));
                break;
            case 'setting_content':
                $this->_setting_content();
                break;
        }
        $this->display($_POST['page']);
    }

	public function index()
	{
        $this->display();
	}

    private function _index_content()
    {
        $store = M('Store');
        $product = M('Product');
        $fx_order = M('Fx_order');
        $financial_record = M('Financial_record');

        $fx_product_count = $product->fxProductCount(array('store_id' => $this->store_session['store_id'], 'supplier_id' => array('>', 0), 'status' => array('<', 2)));

        //店铺销售额
        $sales = $fx_order->getSales(array('store_id' => $this->store_session['store_id'], 'status' => array('in', array(1,2,3,4))));
        $sales = !empty($sales) ? $sales : '0.00';
        $sales = number_format($sales, 2, '.', '');

        //店铺佣金
        //$profit = $financial_record->drpProfit(array('store_id' => $this->store_session['store_id']));
        $store = $store->getStore($this->store_session['store_id']);
        $profit = !empty($store['drp_profit']) ? $store['drp_profit'] : 0;
        $profit = number_format($profit, 2, '.', '');

        //七天销售额、佣金
        $days_7_sales = array();
        $days_7_profis = array();
        $days = array();
        $tmp_days = array();
        for($i=7; $i>=1; $i--){
            $day = date("Y-m-d",strtotime('-'.$i.'day'));
            $days[] = $day;
        }
        foreach ($days as $day) {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $stop_time = strtotime($day . ' 23:59:59');
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['status'] = array('in', array(1,2,3,4));
            $where['_string'] = "paid_time >= " . $start_time . " AND paid_time < " . $stop_time;
            $tmp_days_7_sales = $fx_order->getSales($where);
            $days_7_sales[] = !empty($tmp_days_7_sales) ? number_format($tmp_days_7_sales, 2, '.', '') : 0;

            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            $where['_string'] = "add_time >= " . $start_time . " AND add_time < " . $stop_time;
            $tmp_days_7_profits = $financial_record->drpProfit($where);
            $days_7_profits[] = !empty($tmp_days_7_profits) ? number_format($tmp_days_7_profits, 2, '.', '') : 0;

            $tmp_days[] = "'" . $day . "'";
        }
        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_sales = '[' . implode(',', $days_7_sales) . ']';
        $days_7_profits = '[' . implode(',', $days_7_profits) . ']';

        $this->assign('fx_product_count', $fx_product_count);
        $this->assign('sales', $sales);
        $this->assign('profit', $profit);
        $this->assign('days', $days);
        $this->assign('days_7_sales', $days_7_sales);
        $this->assign('days_7_profits', $days_7_profits);
    }

    //商品市场
    public function market()
    {
        //分销处理
        if (IS_POST && strtolower(trim($_POST['type'])) == 'fx') {
            $store = M('Store');
            $product = M('Product');
            $product_image = M('Product_image');
            $product_sku = M('Product_sku');
            $product_to_group = M('Product_to_group');
            $product_to_property = M('Product_to_property');
            $product_to_property_value = M('Product_to_property_value');
            $product_qrcode_activity = M('Product_qrcode_activity');
            $product_custom_field = M('Product_custom_field');
            //$seller_fx_product = M('Seller_fx_product');
            $store_supplier = M('Store_supplier');

            $products = isset($_POST['product_ids']) ? $_POST['product_ids'] : array();
            $address_id = 0;

            foreach ($products as $product_id) {
                $product_info = $product->get(array('product_id' => $product_id, 'is_fx' => 1), '*');
                $data = $product_info;
                unset($data['product_id']);
                $data['name']     = mysql_real_escape_string($data['name']);
                $data['uid']      = $this->user_session['uid'];
                $data['store_id'] = $this->store_session['store_id'];
                if (!empty($product_info['unified_price_setting'])) {
                    $data['price']        = !empty($product_info['drp_level_' . $this->store_session['drp_level'] . '_price']) ? $product_info['drp_level_' . $this->store_session['drp_level'] . '_price'] : $product_info['price'];
                    $data['cost_price']   = !empty($product_info['drp_level_' . $this->store_session['drp_level'] . '_cost_price']) ? $product_info['drp_level_' . $this->store_session['drp_level'] . '_cost_price'] : $product_info['cost_price'];
                    $data['min_fx_price'] = !empty($product_info['drp_level_' . ($this->store_session['drp_level'] + 1) . '_price']) ? $product_info['drp_level_' . ($this->store_session['drp_level'] + 1) . '_price'] : $product_info['min_fx_price'];
                    $data['max_fx_price'] = !empty($product_info['drp_level_' . ($this->store_session['drp_level'] + 1) . '_price']) ? $product_info['drp_level_' . ($this->store_session['drp_level'] + 1) . '_price'] : $product_info['max_fx_price'];
                } else {
                    $data['price'] = $product_info['min_fx_price'];
                }
                $data['is_fx'] = 0;
                $data['source_product_id'] = $product_id;
                $data['status'] = 0; //仓库中
                $data['date_added'] = time();
                $data['supplier_id'] = $product_info['store_id'];
                $data['pv'] = 0;
                $data['delivery_address_id'] = $address_id;
                $data['sales'] = 0; //销量清零
                if (!empty($product_info['original_product_id'])) {
                    $data['original_product_id'] = $product_info['original_product_id'];
                } else {
                    $data['original_product_id'] = $product_id;
                }
                $data['is_fx_setting'] = 0;
                if ($new_product_id = $product->add($data)) {
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
                            $product_to_property->add(array('store_id' => $this->store_session['store_id'], 'product_id' => $new_product_id, 'pid' => $property_name['pid'], 'order_by' => $property_name['order_by']));
                        }
                    }
                    //商品属性值
                    $property_values = $product_to_property_value->getPropertyValues($product_info['store_id'], $product_id);
                    if (!empty($property_values)) {
                        foreach ($property_values as $property_value) {
                            $product_to_property_value->add(array('store_id' => $this->store_session['store_id'], 'product_id' => $new_product_id, 'pid' => $property_value['pid'], 'vid' => $property_value['vid'], 'order_by' => $property_value['order_by']));
                        }
                    }
                    //扫码活动
                    $qrcode_activities = $product_qrcode_activity->getActivities($product_info['store_id'], $product_id);
                    if (!empty($qrcode_activities)) {
                        foreach ($qrcode_activities as $qrcode_activitiy) {
                            $product_qrcode_activity->add(array('store_id' => $this->store_session['store_id'], 'product_id' => $new_product_id, 'buy_type' => $qrcode_activitiy['buy_type'], 'type' => $qrcode_activitiy['type'], 'discount' => $qrcode_activitiy['discount'], 'price' => $qrcode_activitiy['price']));
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
                                'code'         => $tmp_product_sku['code'],
                                'sales'        => 0,
                                'drp_level_1_cost_price' => $tmp_product_sku['drp_level_1_cost_price'],
                                'drp_level_2_cost_price' => $tmp_product_sku['drp_level_2_cost_price'],
                                'drp_level_3_cost_price' => $tmp_product_sku['drp_level_3_cost_price'],
                                'drp_level_1_price' => $tmp_product_sku['drp_level_1_price'],
                                'drp_level_2_price' => $tmp_product_sku['drp_level_2_price'],
                                'drp_level_3_price' => $tmp_product_sku['drp_level_3_price'],
                            );
                            if (!empty($product_info['unified_price_setting'])) {
                                $tmp_sku['price'] = $tmp_product_sku['drp_level_' . ($_SESSION['store']['drp_level']) . '_price'];
                                $tmp_sku['cost_price'] = !empty($tmp_product_sku['drp_level_' . ($_SESSION['store']['drp_level'] + 1) . '_cost_price']) ? $tmp_product_sku['drp_level_' . ($_SESSION['store']['drp_level'] + 1) . '_cost_price'] : $tmp_product_sku['cost_price'];
                                $tmp_sku['min_fx_price'] = !empty($tmp_product_sku['drp_level_' . ($_SESSION['store']['drp_level'] + 1) . '_price']) ? $tmp_product_sku['drp_level_' . ($_SESSION['store']['drp_level'] + 1) . '_price'] : $tmp_product_sku['min_fx_price'];
                                $tmp_sku['max_fx_price'] = !empty($tmp_product_sku['drp_level_' . ($_SESSION['store']['drp_level'] + 1) . '_price']) ? $tmp_product_sku['drp_level_' . ($_SESSION['store']['drp_level'] + 1) . '_price'] : $tmp_product_sku['max_fx_price'];
                            } else {
                                $tmp_sku['price'] = $tmp_product_sku['min_fx_price'];
                                $tmp_sku['cost_price'] = $tmp_product_sku['cost_price'];
                                $tmp_sku['min_fx_price'] = $tmp_product_sku['min_fx_price'];
                                $tmp_sku['max_fx_price'] = $tmp_product_sku['max_fx_price'];
                            }
                            $skus[] = $tmp_sku;
                        }
                        $product_sku->add($new_product_id, $skus);
                    }
                    if (!$store_supplier->suppliers(array('supplier_id' => $product_info['store_id'], 'seller_id' => $this->store_session['store_id']))) {
                        $store_supplier->add(array('supplier_id' => $product_info['store_id'], 'seller_id' => $this->store_session['store_id']));
                    } else {
                        $current_seller = $store_supplier->getSeller(array('seller_id' => $this->store_session['store_id']));

                        $seller = $store_supplier->getSeller(array('seller_id' => $product_info['store_id'])); //获取上级分销商信息
                        if (empty($seller['type'])) { //全网分销的分销商
                            $seller['supply_chain'] = 0;
                            $seller['level'] = 0;
                        }
                        $seller['supply_chain'] = !empty($seller['supply_chain']) ? $seller['supply_chain'] : 0;
                        $seller['level'] = !empty($seller['level']) ? $seller['level'] : 0;
                        $supply_chain = !empty($product_info['store_id']) ? $seller['supply_chain'] . ',' . $product_info['store_id'] : 0;
                        $level = $seller['level'] + 1;
                        if ($current_seller['supplier_id'] != $product_info['store_id']) {
                            $store_supplier->add(array('supplier_id' => $product_info['store_id'], 'seller_id' => $this->store_session['store_id'], 'supply_chain' => $supply_chain, 'level' => $level, 'type' => 1));//添加分销关联关系
                            $_SESSION['store']['drp_supplier_id'] = $product_info['store_id'];
                            //供货商店铺
                            $supplier_store = $store->getStore($product_info['store_id']);
                            //获取供货商分销级别
                            $drp_level = !empty($supplier_store['drp_level']) ? $supplier_store['drp_level'] : 0;
                            D('Store')->where(array('store_id' => $this->store_session['store_id']))->data(array('drp_supplier_id' => $product_info['store_id'], 'drp_level' => ($drp_level + 1)))->save();
                        }
                    }
                }
            }
            json_return(0, '分销成功');
            exit;
        }
        $this->display();
    }

    private function _market_content()
    {
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');
        $store_supplier = M('Store_supplier');

        $order_by_field = 'is_fx';
        $order_by_method = 'DESC';
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

        $where = array();
        //排他分销商
        $seller = $store_supplier->getSeller(array('seller_id' => $this->store_session['store_id'], 'type' => 1));
        if (!empty($seller) || !$this->checkFx(true)) { //排他分销(是分销商或没有开启全网分销)
            $where['store_id'] = $this->store_session['drp_supplier_id'];
        } else { //全网分销
            if (!empty($_SESSION['sync_store'])) { //对接店铺不能参与全网分销
                $where['store_id'] = -1;
            } else {
                $where['store_id'] = array('!=', $this->store_session['store_id']);
            }
            $where['supplier_id'] = 0;
            $where['fx_type'] = 0; //分销类型(全网分销)
        }
        $where['is_fx'] = 1; //设置分销的商品
        if (!empty($_POST['category_id'])) {
            $where['category_id'] = intval(trim($_POST['category_id']));
        }
        if (!empty($_POST['category_fid'])) {
            $where['category_fid'] = intval(trim($_POST['category_fid']));
        }
        if ($keyword) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }
        //排除当前用户的商品
        $where['uid'] = array('!=', $this->user_session['uid']);
        $product_total = $product->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 15);
        $products = $product->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);

        //商品分类
        $category = M('Product_category');
        $categories = $category->getCategories();

        $tmp_fx_products = $product->fxProducts($this->store_session['store_id']);
        $fx_products = array();
        foreach ($tmp_fx_products as $tmp_fx_product) {
            $fx_products[] = $tmp_fx_product['source_product_id'];
        }
        $this->assign('page', $page->show());
        $this->assign('products', $products);
        $this->assign('categories', $categories);
        $this->assign('fx_products', $fx_products);
        $this->assign('product_total', $product_total);
    }

    //已分销商品
    public function goods()
    {
        $this->display();
    }

    private function _goods_content()
    {
        $product = M('Product');
        $store = M('Store');
        $user_address = M('User_address');

        $product_count = $product->fxProductCount(array('store_id' => $this->store_session['store_id'], 'supplier_id' => array('>', 0), 'status' => array('<', 2)));
        import('source.class.user_page');
        $page = new Page($product_count, 15);
        $tmp_products = $product->fxProducts($this->store_session['store_id'], $page->firstRow, $page->listRows);
        $products = array();
        foreach ($tmp_products as $tmp_product) {
            $supplier = $store->getStore($tmp_product['supplier_id']);
            if (!empty($tmp_product['delivery_address_id'])) {
                import('source.class.area');
                $address = $user_address->getAddress($tmp_product['delivery_address_id']);
                $address_obj = new area();
                $province = $address_obj->get_name($address['province']);
                $city = $address_obj->get_name($address['city']);
                $area = $address_obj->get_name($address['area']);
                $delivery_address = $province . ' ' . $city . ' ' . $area . ' ' . $address['address'];
            } else {
                $delivery_address = '使用买家收货地址';
            }
            $source_product = $product->get(array('product_id' => $tmp_product['source_product_id']), 'cost_price');
            $products[] = array(
                'store_id'            => $tmp_product['store_id'],
                'product_id'          => $tmp_product['product_id'],
                'name'                => $tmp_product['name'],
                'image'               => getAttachmentUrl($tmp_product['image']),
                'cost_price'          => $source_product['cost_price'],
                'supplier'            => $supplier['name'],
                'delivery_address'    => $delivery_address,
                'delivery_address_id' => $tmp_product['delivery_address_id'],
                'is_fx_setting'       => $tmp_product['is_fx_setting']
            );
        }

        $this->assign('products', $products);
        $this->assign('page', $page->show());
    }

    //编辑分销商品
    public function edit_goods()
    {
        $this->display();
    }

    private function _edit_goods_content()
    {
        $product = M('Product');
        $category = M('Product_category');
        $product_property = M('Product_property');
        $product_property_value = M('Product_property_value');
        $product_to_property = M('Product_to_property');
        $product_to_property_value = M('Product_to_property_value');
        $product_sku = M('Product_sku');

        $id = isset($_POST['id']) ? intval(trim($_POST['id'])) : 0;

        $product = $product->get(array('product_id' => $id, 'store_id' => $this->store_session['store_id']));
        $category = $category->getCategory($product['category_id']);
        $product['category'] = $category['cat_name'];

        $pids = $product_to_property->getPids($this->store_session['store_id'], $id);
        if (!empty($pids[0]['pid'])) {
            $pid = $pids[0]['pid'];
            $name = $product_property->getName($pid);
            $vids = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid);
            if (!empty($pids[1]['pid']) && !empty($pids[2]['pid'])) {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                $pid2 = $pids[2]['pid'];
                $name2 = $product_property->getName($pid2);
                $vids2 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid2);
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html .= '        <th class="th-price" style="width: 70px;text-align: center">成本价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                foreach ($vids as $key => $vid) {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1) {
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        foreach ($vids2 as $key2 => $vid2) {
                            $properties = $pid . ':' . $vid['vid']. ';' . $pid1 . ':' . $vid1['vid'] . ';' . $pid2 . ':' . $vid2['vid'];
                            $sku = $product_sku->getSku($id, $properties);
                            $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $value2 = $product_property_value->getValue($pid2, $vid2['vid']);
                            if($key1 == 0 && $key2 == 0) {
                                $html .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                            }
                            if($key2 == 0) {
                                $html .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                            }
                            $html .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html .= '        <td style="text-align: center">' . $sku['cost_price'] . '</td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10"> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini" maxlength="10"></td>';
                            $html .= '    </tr>';
                        }
                    }
                }
            } else if (!empty($pids[1]['pid'])) {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                foreach ($vids as $key => $vid) {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1) {
                        $properties = $pid . ':' . $vid['vid']. ';' . $pid1 . ':' . $vid1['vid'];
                        $sku = $product_sku->getSku($id, $properties);
                        $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        if($key1 == 0) {
                            $html .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                        }
                        $html .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                        $html .= '        <td style="text-align: center">' . $sku['cost_price'] . '</td>';
                        $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price input-mini"  maxlength="10" /></td>';
                        $html .= '    </tr>';
                    }
                }
            } else {
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                foreach ($vids as $key => $vid) {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $properties = $pid . ':' . $vid['vid'];
                    $sku = $product_sku->getSku($id, $properties);
                    $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $html .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html .= '        <td style="text-align: center">' . $sku['cost_price'] . '</td>';
                    $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price input-mini" maxlength="10" /></td>';
                    $html .= '    </tr>';
                }
            }
            $html .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-price" href="javascript:;">价格</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
        }

        $this->assign('sku_content', $html);
        $this->assign('product', $product);
    }

    //采购清单
    public function orders()
    {
        if (IS_POST && strtolower($_POST['type'] == 'pay')) {
            $fx_order = M('Fx_order');
            $order_id = isset($_POST['order_id']) ? trim($_POST['order_id']) : 0;
            $trade_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
            $where = array();
            $where['_string'] = 'fx_order_id IN(' . $order_id . ')';
            if ($fx_order->edit($where, array('fx_trade_no' => $trade_no))) {
                json_return(0, url('pay_order', array('trade_no' => $trade_no)));
            } else {
                json_return(1001, '操作失败');
            }
        }
        $this->display();
    }

    private function _orders_content()
    {
        $store = M('Store');
        $store_supplier = M('Store_supplier');
        $order = M('Fx_order');
        $order_product = M('Fx_order_product');

        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        if (!empty($_POST['order_no'])) {
            $where['order_no'] = $_POST['order_no'];
        }
        if (!empty($_POST['fx_order_no'])) {
            $where['fx_order_no'] = $_POST['fx_order_no'];
        }
        if (!empty($_POST['delivery_user'])) {
            $where['delivery_user'] = $_POST['delivery_user'];
        }
        if (!empty($_POST['supplier_id'])) {
            $where['supplier_id'] = $_POST['supplier_id'];
        }
        if (!empty($_POST['status'])) {
            $where['status'] = $_POST['status'];
        }
        if (!empty($_POST['delivery_tel'])) {
            $where['delivery_tel'] = $_POST['delivery_tel'];
        }
        if (!empty($_POST['start_time']) && !empty($_POST['stop_time'])) {
            $where['_string'] = "`add_time` >= " . strtotime($_POST['start_time']) . " AND `add_time` <= " . strtotime($_POST['stop_time']);
        } else if (!empty($_POST['start_time'])) {
            $where['add_time'] = array('>=', strtotime($_POST['start_time']));
        } else if (!empty($_POST['stop_time'])) {
            $where['add_time'] = array('<=', strtotime($_POST['stop_time']));
        }
        $order_count = $order->getOrderCount($where);
        import('source.class.user_page');
        $page = new Page($order_count, 15);
        $tmp_orders = $order->getOrders($where, $page->firstRow, $page->listRows);
        $orders = array();
        foreach ($tmp_orders as $tmp_order) {
            $supplier = $store->getStore($tmp_order['supplier_id']);
            $supplier_name = $supplier['name'];
            $products = $order_product->getFxProducts($tmp_order['fx_order_id']);
            $orders[] = array(
                'fx_order_id' => $tmp_order['fx_order_id'],
                'fx_order_no' => $tmp_order['fx_order_no'],
                'order_no' => $tmp_order['order_no'],
                'total'    => $tmp_order['cost_total'],
                'supplier_id' => $tmp_order['supplier_id'],
                'supplier' => $supplier_name,
                'products' => $products,
                'add_time' => date('Y-m-d H:i:s', $tmp_order['add_time']),
                'delivery_user' => $tmp_order['delivery_user'],
                'delivery_tel'  => $tmp_order['delivery_tel'],
                'status'   => $order->status_text($tmp_order['status']),
                'status_id' => $tmp_order['status']
            );
        }
        $suppliers = $store_supplier->suppliers(array('seller_id' => $this->store_session['store_id']));

        $status = $order->status();

        $this->assign('orders', $orders);
        $this->assign('page', $page->show());
        $this->assign('suppliers', $suppliers);
        $this->assign('status', $status);
    }

    //订单详细
    public function order_detail()
    {
        $this->display();
    }

    private function _order_detail_content()
    {
        $fx_order = M('Fx_order');
        $order = M('Order');
        $order_product = M('Order_product');
        $fx_order_product = M('Fx_order_product');
        $user = M('User');
        $product = M('Product');
        $store = M('Store');
        $package = M('Order_package');

        $fx_order_id = intval(trim($_POST['order_id']));
        $fx_order_info = $fx_order->getOrder($this->store_session['store_id'], $fx_order_id);
        $order_id = $fx_order_info['order_id'];
        $order_info = $order->getOrder($this->store_session['store_id'], $order_id);
        $fx_order_info['shipping_method'] = $order_info['shipping_method'];
        $fx_order_info['address'] = $order_info['address'];
        $fx_order_info['payment_method'] = $order_info['payment_method']; //买家付款方式
        $fx_order_info['buyer_paid_time'] = $order_info['paid_time']; //买家付款时间
        $fx_order_info['comment'] = $order_info['comment']; //买家留言
        //分销利润
        $fx_profit = number_format($fx_order_info['total'] - $fx_order_info['cost_total'], 2, '.', '');
        $fx_order_info['fx_profit'] = $fx_profit;
        $tmp_products = $fx_order_product->getFxProducts($fx_order_id);
        $products = array();
        $comment_count = 0;
        $product_count = 0;

        $order_products = $order_product->getProducts($order_id);
        foreach ($tmp_products as $tmp_product) {
            $product_info = $product->get(array('product_id' => $tmp_product['product_id']));
            $products[] = array(
                'product_id'        => $tmp_product['product_id'],
                'name'              => $product_info['name'],
                'cost_price'        => $tmp_product['cost_price'],
                'pro_price'         => $tmp_product['price'],
                'pro_num'           => $tmp_product['quantity'],
                'sku_data'          => $tmp_product['sku_data'],
                'image'             => $product_info['image'],
                'comment'           => $tmp_product['comment'],
                'is_fx'             => $tmp_product['is_fx'],
            );
            if (!empty($tmp_product['comment'])) {
                $comment_count++;
            }
            $product_count++;
        }
        if (empty($order_info['uid'])) {
            $is_fans = false;
        } else {
            $is_fans = $user->isWeixinFans($order_info['uid']);
        }

        //供货商
        $supplier = $store->getStore($fx_order_info['supplier_id']);

        $payment_method = $order->getPaymentMethod();
        $status = $fx_order->status_text();

        //获取分销商给供货商下的订单
        $seller_order_info = $order->getSellerOrder($this->user_session['uid'], $fx_order_id);
        $packages = array();
        if (!empty($seller_order_info)) {
            //包裹
            $packages = $package->getPackages(array('order_id' => $seller_order_info['order_id'], 'store_id' => $fx_order_info['supplier_id']));
        }

        $this->assign('order', $fx_order_info);
        $this->assign('products', $products);
        $this->assign('is_fans', $is_fans);
        $this->assign('payment_method', $payment_method);
        $this->assign('rows', $comment_count + $product_count);
        $this->assign('comment_count', $comment_count);
        $this->assign('status', $status);
        $this->assign('supplier', $supplier['name']);
        $this->assign('packages', $packages);
    }

    //订单付款(分销商)
    public function pay_order()
    {
        $order = M('Order');
        $order_product = M('Order_product');
        $fx_order = M('Fx_order');
        $fx_order_product = M('Fx_order_product');
        $store = M('Store');
        $financial_record = M('Financial_record');
        $store_supplier = M('Store_supplier');
        $product_model = M('Product');
        $product_sku = M('Product_sku');

        if (IS_POST) {
            $data = array();
            $total = isset($_POST['total']) ? floatval($_POST['total']) : 0; //付款总金额
            $data['total'] = intval($total);
            $data['order_id'] = isset($_POST['order_id']) ? $_POST['order_id'] : '';
            $data['supplier_id'] = isset($_POST['supplier_id']) ? intval($_POST['supplier_id']) : 0;
            $data['seller_id'] = isset($_POST['seller_id']) ? intval($_POST['seller_id']) : 0;
            $data['trade_no'] = isset($_POST['trade_no']) ? trim($_POST['trade_no']) : '';
            $data['salt'] = 'pigcms-weidian-fx-order-pay-to-supplier';
            $timestamp = isset($_POST['timestamp']) ? intval($_POST['timestamp']) : 0;
            $hash = isset($_POST['hash']) ? trim($_POST['hash']) : '';
            ksort($data);
            $hash_new = sha1(http_build_query($data));
            $now = time();
            if (($now - $timestamp) > 360) {
                json_return(1001, '请求已过期');
            } else if ($hash != $hash_new) {
                json_return(1002, '参数无效');
            } else {
                //付款给供货商
                $fx_order_id = explode(',', $data['order_id']); //合并支付会出现多个订单ID
                $supplier = $store->getStore($data['supplier_id']); //供货商
                //如果store_supplier中的seller_id字段值中有当前供货商并且type分销类型为1，则表示当前供货商同时也是分销商，则为其供货商添加分销订单
                $seller_info = $store_supplier->getSeller(array('seller_id' => $data['supplier_id'], 'type' => 1));
                if (!empty($seller_info)) {
                    $is_supplier = false;
                } else {
                    $is_supplier = true;
                }
                $seller = $store->getStore($this->store_session['store_id']); //分销商
                if ($total > 0) {
                    //供货商不可用余额和收入加商品成本
                    if ($store->setUnBalanceInc($data['supplier_id'], $total) && $store->setIncomeInc($data['supplier_id'], $total)) {
                        foreach ($fx_order_id as $id) {
                            //修改分销订单状态为等待供货商发货并且关联供货商订单id
                            $fx_order->edit(array('fx_order_id' => $id), array('status' => 2, 'paid_time' => time()));
                            $fx_order_info = $fx_order->getOrder($this->store_session['store_id'], $id); //分销订单详细
                            $order_id = $fx_order_info['order_id']; //主订单ID
                            //主订单分销商品
                            $fx_products = $order_product->getFxProducts($order_id, $id, $is_supplier);
                            $order_info = $order->getOrder($this->store_session['store_id'], $order_id);
                            $order_trade_no = $order_info['trade_no']; //主订单交易号
                            unset($order_info['order_id']);
                            $order_info['order_no']       = date('YmdHis',time()).mt_rand(100000,999999);
                            $order_info['store_id']       = $data['supplier_id'];
                            $order_info['trade_no']       = date('YmdHis',time()).mt_rand(100000,999999);
                            $order_info['third_id']       = '';
                            $order_info['uid']            = $this->user_session['uid']; //下单用户（分销商）
                            $order_info['session_id']     = '';
                            $order_info['postage']        = $fx_order_info['postage'];
                            $order_info['sub_total']      = $fx_order_info['cost_sub_total'];
                            $order_info['total']          = $fx_order_info['cost_total'];
                            $order_info['status']         = 2; //未发货
                            $order_info['pro_count']      = 0; //商品种类数量
                            $order_info['pro_num']        = $fx_order_info['quantity']; //商品件数
                            $order_info['payment_method'] = 'balance';
                            $order_info['type']           = 3; //分销订单
                            $order_info['add_time']       = time();
                            $order_info['paid_time']      = time();
                            $order_info['sent_time']      = 0;
                            $order_info['cancel_time']    = 0;
                            $order_info['complate_time']  = 0;
                            $order_info['refund_time']    = 0;
                            $order_info['star']           = 0;
                            $order_info['pay_money']      = $fx_order_info['cost_total'];
                            $order_info['cancel_method']  = 0;
                            $order_info['float_amount']   = 0;
                            $order_info['is_fx']          = 0;
                            $order_info['fx_order_id']    = $id; //关联分销商订单id（fx_order）
                            $order_info['user_order_id']  = $fx_order_info['user_order_id'];
                            if ($new_order_id = $order->add($order_info)) { //向供货商提交一个新订单
                                $suppliers = array();
                                foreach ($fx_products as $key => $fx_product) {
                                    unset($fx_product['pigcms_id']);
                                    //获取分销商品的来源
                                    $product_info = $product_model->get(array('product_id' => $fx_product['product_id']), 'source_product_id,original_product_id');
                                    if (!empty($product_info['source_product_id'])) {
                                        $fx_product['product_id'] = $product_info['source_product_id'];

                                        $properties = ''; //商品属性字符串
                                        if (!empty($fx_product['sku_data'])) {
                                            $sku_data = unserialize($fx_product['sku_data']);
                                            $skus = array();
                                            foreach($sku_data as $sku) {
                                                $skus[] = $sku['pid'] . ':' . $sku['vid'];
                                            }
                                            $properties = implode(';', $skus);
                                        }
                                        if (!empty($properties)) { //有属性
                                            $sku = $product_sku->getSku($fx_product['product_id'], $properties);
                                            $fx_product['pro_price'] = $sku['cost_price']; //分销来源商品的成本价格
                                            $fx_product['sku_id'] = $sku['sku_id'];
                                        } else { //无属性
                                            $source_product_info = $product_model->get(array('product_id' => $fx_product['product_id']), 'price,cost_price');
                                            $fx_product['pro_price'] = $source_product_info['cost_price']; //分销来源商品的成本价格
                                        }
                                    }

                                    $fx_product['order_id']          = $new_order_id;
                                    $fx_product['pro_price']         = $fx_product['price'];
                                    $fx_product['is_packaged']       = 0;
                                    $fx_product['in_package_status'] = 0;
                                    //判断是否是店铺自有商品
                                    $super_product_info = $product_model->get(array('product_id' => $product_info['source_product_id']), 'source_product_id,original_product_id');
                                    if (empty($seller_info) || empty($super_product_info['source_product_id'])) { //供货商或商品供货商
                                        $fx_product['is_fx']             = 0;
                                    } else {
                                        $fx_product['is_fx']             = 1;
                                    }
                                    unset($fx_product['price']);
                                    $order_product->add($fx_product); //添加新订单商
                                    $fx_products[$key]['pro_price'] = $fx_product['pro_price'];
                                    $fx_products[$key]['source_product_id'] = $fx_product['product_id'];
                                    $suppliers[] = $fx_product['supplier_id'];
                                }
                                //修改订单供货商
                                $suppliers = array_unique($suppliers);
                                $suppliers = implode(',', $suppliers);
                                D('Order')->where(array('order_id' => $new_order_id))->data(array('suppliers' => $suppliers))->save();

                                //添加供货商财务记录（收入）
                                $data_record = array();
                                $data_record['store_id']         = $data['supplier_id'];
                                $data_record['order_id'] 		 = $new_order_id;
                                $data_record['order_no'] 		 = $order_info['order_no'];
                                $data_record['income']  		 = $fx_order_info['cost_total'];
                                $data_record['type']    		 = 5; //分销
                                $data_record['balance']     	 = $supplier['income'];
                                $data_record['payment_method']   = 'balance';
                                $data_record['trade_no']         = $order_info['trade_no'];
                                $data_record['add_time']         = time();
                                $data_record['status']           = 1;
                                $data_record['user_order_id']    = $order_info['user_order_id'];
                                $financial_record_id = D('Financial_record')->data($data_record)->add();

                                //判断供货商，如果上级供货商是分销商，添加分销订单
                                if (!empty($seller_info)) {
                                    $cost_sub_total = 0;
                                    $sub_total = 0;
                                    $tmp_fx_products = array();
                                    foreach ($fx_products as $k => $fx_product) {
                                        $properties = ''; //商品属性字符串
                                        if (!empty($fx_product['sku_data'])) {
                                            $sku_data = unserialize($fx_product['sku_data']);
                                            $skus = array();
                                            foreach($sku_data as $sku) {
                                                $skus[] = $sku['pid'] . ':' . $sku['vid'];
                                            }
                                            $properties = implode(';', $skus);
                                        }
                                        //获取分销商品的来源
                                        $product_info = $product_model->get(array('product_id' => $fx_product['product_id']), 'source_product_id,original_product_id');
                                        $source_product_id = $product_info['source_product_id']; //分销来源商品
                                        $original_product_id = $product_info['original_product_id'];
                                        if (empty($source_product_id) || $original_product_id == $source_product_id) { //商品供货商或商品供货商为上级分销商
                                            unset($fx_products[$k]);
                                            continue;
                                        }
                                        $tmp_fx_product = $fx_product;
                                        if (!empty($seller_info) && !empty($product_info['original_product_id'])) {
                                            $product_info = $product_model->get(array('product_id' => $source_product_id), 'source_product_id,original_product_id');
                                            $source_product_id = $product_info['source_product_id']; //分销来源商品
                                        }
                                        if (!empty($properties)) { //有属性
                                            $sku = $product_sku->getSku($source_product_id, $properties);
                                            //$price = $sku['price'];
                                            $cost_price = $sku['cost_price']; //分销来源商品的成本价格
                                            $sku_id = $sku['sku_id'];
                                        } else { //无属性
                                            $source_product_info = $product_model->get(array('product_id' => $source_product_id), 'price,cost_price');
                                            //$price = $source_product_info['price'];
                                            $cost_price = $source_product_info['cost_price']; //分销来源商品的成本价格
                                            $sku_id = 0;
                                        }
                                        $cost_sub_total += $cost_price;
                                        $sub_total += $fx_product['pro_price'];
                                        $tmp_fx_product['product_id'] = $source_product_id;
                                        $tmp_fx_product['price'] = $fx_product['pro_price'];
                                        $tmp_fx_product['cost_price'] = $cost_price;
                                        $tmp_fx_product['sku_id'] = $sku_id;
                                        $tmp_fx_product['original_product_id'] = $original_product_id;
                                        $tmp_fx_products[] = $tmp_fx_product;
                                    }
                                    if (!empty($fx_products)) {
                                        $fx_order_no = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999); //分销订单号
                                        //运费
                                        $fx_postages = array();
                                        if (!empty($order_info['fx_postage'])) {
                                            $fx_postages = unserialize($order_info['fx_postage']);
                                        }
                                        $postage = !empty($fx_postages[$seller_info['supplier_id']]) ? $fx_postages[$seller_info['supplier_id']] : 0;
                                        $data2 = array(
                                            'fx_order_no'      => $fx_order_no,
                                            'uid'              => $order_info['uid'],
                                            'order_id'         => $new_order_id,
                                            'order_no'         => $order_info['order_no'],
                                            'supplier_id'      => $seller_info['supplier_id'],
                                            'store_id'         => $data['supplier_id'],
                                            'quantity'         => $fx_order_info['quantity'],
                                            'sub_total'        => $sub_total,
                                            'cost_sub_total'   => $cost_sub_total,
                                            'postage'          => $postage,
                                            'total'            => ($sub_total + $postage),
                                            'cost_total'       => ($cost_sub_total + $postage),
                                            'delivery_user'    => $order_info['address_user'],
                                            'delivery_tel'     => $order_info['address_tel'],
                                            'delivery_address' => $order_info['address'],
                                            'add_time'         => time(),
                                            'user_order_id'    => $order_info['user_order_id']
                                        );
                                        if ($fx_order_id = $fx_order->add($data2)) { //添加分销商订单
                                            foreach ($tmp_fx_products as $tmp_fx_product) {
                                                if (!empty($tmp_fx_product['product_id'])) {
                                                    $product_info = D('Product')->field('store_id, original_product_id')->where(array('product_id' => $tmp_fx_product['original_product_id']))->find();
                                                    $tmp_supplier_id = $product_info['store_id'];
                                                    $fx_order_product->add(array('fx_order_id' => $fx_order_id, 'product_id' => $tmp_fx_product['product_id'], 'source_product_id' => $tmp_fx_product['source_product_id'], 'price' => $tmp_fx_product['price'], 'cost_price' => $tmp_fx_product['cost_price'], 'quantity' => $tmp_fx_product['pro_num'], 'sku_id' => $tmp_fx_product['sku_id'], 'sku_data' => $tmp_fx_product['sku_data'], 'comment' => $tmp_fx_product['comment']));
                                                }
                                            }
                                            if (!empty($tmp_supplier_id)) { //修改订单，设置分销商
                                                D('Fx_order')->where(array('fx_order_id' => $fx_order_id))->data(array('suppliers' => $tmp_supplier_id))->save();
                                            }
                                        }
                                        //获取分销利润
                                        if (!empty($financial_record_id) && !empty($data2['cost_total'])) {
                                            $profit = $data2['total'] - $data2['cost_total'];
                                            if ($profit > 0) {
                                                D('Financial_record')->where(array('pigcms_id' => $financial_record_id))->data(array('profit' => $profit))->save();
                                            }
                                        }
                                    }
                                }

                                //分销商不可用余额和收入减商品成本
                                if ($store->setUnBalanceDec($this->store_session['store_id'], $fx_order_info['cost_total']) && $store->setIncomeDec($this->store_session['store_id'], $fx_order_info['cost_total'])) {
                                    //添加分销商财务记录（支出）
                                    $order_no = $order_info['order_no'];
                                    $data_record = array();
                                    $data_record['store_id']         = $this->store_session['store_id'];
                                    $data_record['order_id'] 		 = $order_id;
                                    $data_record['order_no'] 		 = $order_no;
                                    $data_record['income']  		 = (0 - $fx_order_info['cost_total']);
                                    $data_record['type']    		 = 5; //分销
                                    $data_record['balance']     	 = $seller['income'];
                                    $data_record['payment_method']   = 'balance';
                                    $data_record['trade_no']         = $order_trade_no;
                                    $data_record['add_time']         = time();
                                    $data_record['status']           = 1;
                                    $data_record['user_order_id']    = $order_info['user_order_id'];
                                    D('Financial_record')->data($data_record)->add();
                                } else { //操作失败，记录日志文件
                                    $supplier_name = $supplier['name'];
                                    $seller_name = $seller['name'];
                                    $dir = './upload/pay/';
                                    if(!is_readable($dir))
                                    {
                                        is_file($dir) or mkdir($dir, 0777);
                                    }
                                    file_put_contents($dir . 'error.txt', '[' . date('Y-m-d H:i:s') . '] 付款给供货商失败，订单类型：分销，订单ID：' . $order_id . '，交易单号：' . $order_trade_no . '，供货商（收款方）：' . $supplier_name . '，分销商（付款方）：' . $seller_name . '，付款金额：' . $fx_order_info['cost_total'] . '元，请手动从 ' . $seller_name . ' 账户余额中减' . $fx_order_info['cost_total'] . '元' . PHP_EOL, FILE_APPEND );
                                    json_return(1005, '付款失败，请联系客服处理，交易单号：' . $order_trade_no);
                                }
                            }
                        }
                        json_return(0, '付款成功，等待供货商发货');
                    } else {
                        json_return(1004, '付款失败');
                    }
                } else {
                    json_return(1003, '付款金额无效');
                }
            }
        }

        $trade_no = isset($_GET['trade_no']) ? trim($_GET['trade_no']) : '';
        if (empty($trade_no)) {
            $html = '<div class="error-wrap"><h1>很抱歉，未找到交易号</h1><div class="description"></div><div class="error-code">错误代码： 10001</div><div class="action"><a href="javascript:window.history.go(-1);" class="ui-btn ui-btn-primary">返回</a></div></div>';
            $this->assign('trade_no_error', $html);
        } else if (!$fx_order->getOrderCount(array('fx_trade_no' => $trade_no))) {
            $html = '<div class="error-wrap"><h1>很抱歉，未找到交易号 ' . $trade_no . ' 关联的支付信息</h1><div class="description"></div><div class="error-code">错误代码： 10002</div><div class="action"><a href="javascript:window.history.go(-1);" class="ui-btn ui-btn-primary">返回</a></div></div>';
            $this->assign('trade_no_error', $html);
        }
        $this->assign('trade_no', $trade_no);
        $this->display();
    }

    private function _pay_order_content()
    {
        $store = M('Store');
        $fx_order = M('Fx_order');
        $order_product = M('Fx_order_product');

        $trade_no = isset($_POST['trade_no']) ? trim($_POST['trade_no']) : '';
        $tmp_orders = $fx_order->getOrders(array('fx_trade_no' => $trade_no));
        $orders = array();
        $total = 0;
        $sub_total = 0;
        $postage = 0;
        $supplier_id = 0;
        $seller_id = 0;
        $supplier_name = '';
        $pay = true;
        foreach ($tmp_orders as $tmp_order) {
            $supplier = $store->getStore($tmp_order['supplier_id']);
            $supplier_id = $tmp_order['supplier_id'];
            $seller_id = $tmp_order['store_id'];
            $supplier_name = $supplier['name'];
            $products = $order_product->getFxProducts($tmp_order['fx_order_id']);
            $orders[] = array(
                'fx_order_id' => $tmp_order['fx_order_id'],
                'fx_order_no' => option('config.orderid_prefix') . $tmp_order['fx_order_no'],
                'postage'     => $tmp_order['postage'],
                'total'       => $tmp_order['total'],
                'cost_total'  => $tmp_order['cost_total'],
                'supplier'    => $supplier_name,
                'products'    => $products
             );
            $total += $tmp_order['cost_total'];
            if ($tmp_order['status'] !=1) {
                $pay = false;
            }
            $postage += $tmp_order['postage'];
        }

        $this->assign('trade_no', $trade_no);
        $this->assign('orders', $orders);
        $this->assign('total', number_format($total, 2, '.', ''));
        $this->assign('supplier', $supplier_name);
        $this->assign('supplier_id', $supplier_id);
        $this->assign('seller_id', $seller_id);
        $this->assign('pay', $pay);
        $this->assign('postage', number_format($postage, 2, '.', ''));
    }

    //我的供货商
    public function supplier()
    {
        $this->display();
    }

    private function _supplier_content()
    {
        $store_supplier = M('Store_supplier');
        $store = M('Store');

        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

        $where = array();
        $where['ss.seller_id'] = $this->store_session['store_id'];
        if (!empty($keyword)) {
            $where['s.name'] = array('like' => '%' . $keyword . '%');
        }
        if (!empty($_SESSION['store_sync'])) {
            $where['ss.type'] = 1;
        }
        $supplier_count = $store_supplier->supplier_count($where);
        import('source.class.user_page');
        $page = new Page($supplier_count, 15);
        $suppliers = $store_supplier->suppliers($where, $page->firstRow, $page->listRows);

        $this->assign('suppliers', $suppliers);
        $this->assign('page', $page->show());
    }

    //我的商品
    public function supplier_goods()
    {
        $this->display();
    }

    private function _supplier_goods_content()
    {
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');

        $order_by_field = isset($_POST['orderbyfield']) ? $_POST['orderbyfield'] : '';
        $order_by_method = isset($_POST['orderbymethod']) ? $_POST['orderbymethod'] : '';
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        if ($keyword) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }
        $where['buy_way'] = 1; //站内商品
        $where['is_fx'] = 0;
        $where['supplier_id'] = 0;
        $product_total = $product->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 15);
        $products = $product->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);

        $this->assign('page', $page->show());
        $this->assign('products', $products);
    }

    //商品市场
    public function supplier_market()
    {
        if (IS_POST) {
            $product = M('Product');

            $products = isset($_POST['products']) ? trim($_POST['products']) : '';
            if (!empty($products) && $product->fxCancel(array('store_id' => $this->store_session['store_id'], 'product_id' => array('in', explode(',', $products))))) {
                $products = explode(',', $products);
                foreach ($products as $product_id) {
                    $product_info = $product->get(array('product_id' => $product_id), 'store_id,product_id,source_product_id,original_product_id');
                    if (!empty($product_info) && $this->store_session['store_id'] == $product_info['store_id'] && empty($product_info['original_product_id'])) {
                        //$product->edit(array('original_product_id' => $product_info['product_id']), array('status' => 2)); //修改状态为删除
                        $this->_cancel_fx_product($product_info['product_id']);
                    } else if (!empty($product_info) && $this->store_session['store_id'] == $product_info['store_id'] && !empty($product_info['original_product_id'])) {
                        //递归处理下级分销商分销的该商品
                        $this->_cancel_fx_product($product_info['product_id']);
                    }
                }

                json_return(0, '操作成功');
            } else {
                json_return(1001, '操作失败');
            }
        }
        $this->display();
    }

    //同步微页面商品
    private function _sync_wei_page_goods($product_id, $store_id = '')
    {
        $product_id = !is_array($product_id) ? array($product_id) : $product_id;
        //删除微页面的商品
        if (empty($store_id)) {
            $store_id = $this->store_session['store_id'];
        }
        $fields = D('Custom_field')->where(array('store_id' => $store_id, 'field_type' => 'goods'))->select();
        if ($fields) {
            foreach ($fields as $field) {
                $products = unserialize($field['content']);
                if (!empty($products) && !empty($products['goods'])) {
                    $new_products = array();
                    foreach($products['goods'] as $product){
                        if (!in_array($product['id'], $product_id)) {
                            $new_products[] = $product;
                        }
                    }
                    $products['goods'] = $new_products;
                    $content = serialize($products);
                    D('Custom_field')->where(array('field_id' => $field['field_id']))->data(array('content' => $content))->save();
                }
            }
        }
    }

    //递归取消商品分销
    private function _cancel_fx_product($product_id)
    {
        /*$tmp_product_info = $product->get(array('source_product_id' => $product_id), 'store_id,product_id,source_product_id,original_product_id');
        if (!empty($tmp_product_info)) {
            $product->edit(array('product_id' => $tmp_product_info['product_id']), array('status' => 2)); //修改状态为删除
            $this->_supplier_content($tmp_product_info['product_id'], $tmp_product_info['store_id']);
            $this->_cancel_fx_product($product, $tmp_product_info['product_id']);
        }*/
        $products = D('Product')->where(array('source_product_id' => $product_id))->select();
        if (!empty($products)) {
            foreach ($products as $product) {
                M('Product')->edit(array('product_id' => $product['product_id']), array('status' => 2)); //修改状态为删除
                $this->_sync_wei_page_goods($product['product_id'], $product['store_id']);
                $this->_cancel_fx_product($product['product_id']);
            }
        }
    }

    private function _supplier_market_content()
    {
        $product = M('Product');
        $product_group = M('Product_group');
        $product_to_group = M('Product_to_group');

        $order_by_field = 'is_fx';
        $order_by_method = 'DESC';
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';

        $where = array();
        $where['store_id'] = $this->store_session['store_id'];
        $where['is_fx'] = 1;
        $where['supplier_id'] = 0;
        if (!empty($_POST['category_id'])) {
            $where['category_id'] = intval(trim($_POST['category_id']));
        }
        if (!empty($_POST['category_fid'])) {
            $where['category_fid'] = intval(trim($_POST['category_fid']));
        }
        if ($keyword) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }
        $product_total = $product->getSellingTotal($where);
        import('source.class.user_page');
        $page = new Page($product_total, 15);
        $products = $product->getSelling($where, $order_by_field, $order_by_method, $page->firstRow, $page->listRows);

        //商品分类
        $category = M('Product_category');
        $categories = $category->getCategories();

        $this->assign('page', $page->show());
        $this->assign('products', $products);
        $this->assign('categories', $categories);
    }

    //我的分销商
    public function seller()
    {
        $this->display();
    }

    private function _seller_content()
    {
        $store_supplier = M('Store_supplier');
        $store = M('Store');
        $fx_order = M('Fx_order');
        $financial_record = M('Financial_record');

        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $approve = isset($_POST['approve']) ? trim($_POST['approve']) : '*';

        $where = array();
        $where['ss.supplier_id'] = $this->store_session['store_id'];
        $where['s.status'] = 1;
        if ($keyword != ''                                                                                                                                                                           ) {
            $where['s.name'] = array('like' => '%' . $keyword . '%');
        }
        if (is_numeric($approve) || $approve != '*') {
            $where['s.drp_approve'] = $approve;
        }
        if (!empty($_SESSION['store_sync'])) {
            $where['ss.type'] = 1;
        }
        $seller_count = $store_supplier->seller_count($where);
        import('source.class.user_page');
        $page = new Page($seller_count, 15);
        $tmp_sellers = $store_supplier->sellers($where, $page->firstRow, $page->listRows);
        $sellers = array();
        foreach ($tmp_sellers as $tmp_seller) {
            $sales = $fx_order->getSales(array('store_id' => $tmp_seller['store_id'], 'status' => array('in', array(1,2,3,4))));
            //$profit = $financial_record->drpProfit(array('store_id' => $tmp_seller['store_id']));
            $profit = $tmp_seller['drp_profit'];
            $sellers[] = array(
                'store_id'       => $tmp_seller['store_id'],
                'name'           => $tmp_seller['name'],
                'service_tel'    => $tmp_seller['service_tel'],
                'service_qq'     => $tmp_seller['service_qq'],
                'service_weixin' => $tmp_seller['service_weixin'],
                'drp_approve'    => $tmp_seller['drp_approve'],
                'status'         => $tmp_seller['status'],
                'sales'          => !empty($sales) ? number_format($sales, 2, '.', '') : '0.00',
                'profit'         => !empty($profit) ? number_format($profit, 2, '.', '') : '0.00'
            );
        }

        $this->assign('sellers', $sellers);
        $this->assign('page', $page->show());
    }

    //设置分销
    public function goods_fx_setting()
    {
        if (IS_POST) {
            $product = M('Product');
            $product_sku = M('Product_sku');

            $product_id = !empty($_POST['product_id']) ? intval(trim($_POST['product_id'])) : 0;
            $cost_price = !empty($_POST['cost_price']) ? floatval(trim($_POST['cost_price'])) : 0;
            $min_fx_price = !empty($_POST['min_fx_price']) ? floatval(trim($_POST['min_fx_price'])) : 0;
            $max_fx_price = !empty($_POST['max_fx_price']) ? floatval(trim($_POST['max_fx_price'])) : 0;
            $is_recommend = !empty($_POST['is_recommend']) ? intval(trim($_POST['is_recommend'])) : 0;
            $unified_price_setting = !empty($_POST['unified_price_setting']) ? $_POST['unified_price_setting'] : 0;
            $is_fx_setting = 1;
            $skus = !empty($_POST['skus']) ? $_POST['skus'] : array();
            $fx_type = 0; //分销类型 0全网、1排他
            if (strtolower(trim($_GET['role'])) == 'seller' || !empty($this->store_session['drp_supplier_id'])) {
                $fx_type = 1;
            }
            $data = array(
                'cost_price'    => $cost_price,
                'min_fx_price'  => $min_fx_price,
                'max_fx_price'  => $max_fx_price,
                'is_recommend'  => $is_recommend,
                'is_fx'         => 1,
                'fx_type'       => $fx_type,
                'is_fx_setting' => $is_fx_setting,
                'unified_price_setting' => $unified_price_setting
            );
            $product_info = M('Product')->get(array('product_id' => $product_id, 'store_id' => $_SESSION['store']['store_id']));
            //分销级别
            if (!empty($_SESSION['store']['drp_level'])) {
                $drp_level = $_SESSION['store']['drp_level'] + 1;
            } else {
                $drp_level = 1;
            }
            if (!empty($unified_price_setting) && empty($product_info['source_product_id'])) {
                $data['cost_price'] = !empty($_POST['drp_level_' . $drp_level . '_cost_price']) ? $_POST['drp_level_' . $drp_level . '_cost_price'] : 0;
                $data['min_fx_price'] = !empty($_POST['drp_level_' . $drp_level . '_price']) ? $_POST['drp_level_' . $drp_level . '_price'] : 0;
                $data['max_fx_price'] = !empty($_POST['drp_level_' . $drp_level . '_price']) ? $_POST['drp_level_' . $drp_level . '_price'] : 0;
                $data['drp_level_1_cost_price'] = !empty($_POST['drp_level_1_cost_price']) ? $_POST['drp_level_1_cost_price'] : 0;
                $data['drp_level_2_cost_price'] = !empty($_POST['drp_level_2_cost_price']) ? $_POST['drp_level_2_cost_price'] : 0;
                $data['drp_level_3_cost_price'] = !empty($_POST['drp_level_3_cost_price']) ? $_POST['drp_level_3_cost_price'] : 0;
                $data['drp_level_1_price'] = !empty($_POST['drp_level_1_price']) ? $_POST['drp_level_1_price'] : 0;
                $data['drp_level_2_price'] = !empty($_POST['drp_level_2_price']) ? $_POST['drp_level_2_price'] : 0;
                $data['drp_level_3_price'] = !empty($_POST['drp_level_3_price']) ? $_POST['drp_level_3_price'] : 0;
            }
            if ($product->fxEdit($product_id, $data)) {
                if (!empty($skus)) {
                    $product_sku->fxEdit($product_id, $skus, $unified_price_setting);
                }
                if (strtolower(trim($_GET['role'])) == 'seller') {
                    json_return(0, url('goods'));
                } else {
                    json_return(0, url('supplier_market'));
                }
            } else {
                json_return(1001, '保存失败');
            }
        }
        $this->display();
    }

    private function _goods_fx_setting_content()
    {
        $product = M('Product');
        $category = M('Product_category');
        $product_property = M('Product_property');
        $product_property_value = M('Product_property_value');
        $product_to_property = M('Product_to_property');
        $product_to_property_value = M('Product_to_property_value');
        $product_sku = M('Product_sku');

        $id = isset($_POST['id']) ? intval(trim($_POST['id'])) : 0;

        $product = $product->get(array('product_id' => $id, 'store_id' => $this->store_session['store_id']));
        if (!empty($product['supplier_id'])) { //分销商
            $edit_cost_price = false;
            $readonly = '';
        } else { //供货商
            $edit_cost_price = true;
            $readonly = '';
        }
        if (!empty($product['category_id']) && !empty($product['category_fid'])) {
            $parent_category = $category->getCategory($product['category_fid']);
            $category = $category->getCategory($product['category_id']);
            $product['category'] = $parent_category['cat_name'] . ' - ' . $category['cat_name'];
        } else if ($product['category_fid']) {
            $category = $category->getCategory($product['category_fid']);
            $product['category'] = $category['cat_name'];
        } else {
            $category = $category->getCategory($product['category_id']);
            $product['category'] = !empty($category['cat_name']) ? $category['cat_name'] : '其它';
        }

        /*$pids = $product_to_property->getPids($this->store_session['store_id'], $id);
        if (!empty($pids[0]['pid'])) {
            $pid = $pids[0]['pid'];
            $name = $product_property->getName($pid);
            $vids = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid);
            if (!empty($pids[1]['pid']) && !empty($pids[2]['pid'])) {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                $pid2 = $pids[2]['pid'];
                $name2 = $product_property->getName($pid2);
                $vids2 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid2);
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="80">' . $name . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                $html .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                $html .= '        <th class="th-price" style="width: 70px;text-align: center">成本价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                foreach ($vids as $key => $vid) {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1) {
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        foreach ($vids2 as $key2 => $vid2) {
                            $properties = $pid . ':' . $vid['vid']. ';' . $pid1 . ':' . $vid1['vid'] . ';' . $pid2 . ':' . $vid2['vid'];
                            $sku = $product_sku->getSku($id, $properties);
                            $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $value2 = $product_property_value->getValue($pid2, $vid2['vid']);
                            if($key1 == 0 && $key2 == 0) {
                                $html .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                            }
                            if($key2 == 0) {
                                $html .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                            }
                            $html .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" value="' . $sku['price'] . '" maxlength="10" ' . $readonly . ' /></td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" data-min-price="' . ($sku['price'] > 0 ? $sku['price'] : '') . '" value="' . ($sku['price'] > 0 ? $sku['price'] : '') . '" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini" maxlength="10" data-max-price="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" value="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" /></td>';
                            $html .= '    </tr>';
                        }
                    }
                }
            } else if (!empty($pids[1]['pid'])) {
                $pid1 = $pids[1]['pid'];
                $name1 = $product_property->getName($pid1);
                $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">成本 + 利润 = 分销价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                foreach ($vids as $key => $vid) {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    foreach ($vids1 as $key1 => $vid1) {
                        $properties = $pid . ':' . $vid['vid']. ';' . $pid1 . ':' . $vid1['vid'];
                        $sku = $product_sku->getSku($id, $properties);
                        $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                        $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                        if($key1 == 0) {
                            $html .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                        }
                        $html .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                        $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" value="' . $sku['price'] . '" maxlength="10" ' . $readonly . ' />';
                        $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" data-min-price="' . ($sku['price'] > 0 ? $sku['price'] : '') . '" value="' . ($sku['price'] > 0 ? $sku['price'] : '') . '" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini"  maxlength="10" data-max-price="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" value="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" /></td>';
                        $html .= '    </tr>';
                    }
                }
            } else {
                $html = '<thead>';
                $html .= '    <tr>';
                $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                $html .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                $html .= '    </tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                foreach ($vids as $key => $vid) {
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $properties = $pid . ':' . $vid['vid'];
                    $sku = $product_sku->getSku($id, $properties);
                    $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                    $value = $product_property_value->getValue($pid, $vid['vid']);
                    $html .= '        <td class="text-center" width="50">' . $value . '</td>';
                    $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" value="' . $sku['price'] . '" maxlength="10" ' . $readonly . ' /></td>';
                    $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" data-min-price="' . ($sku['price'] > 0 ? $sku['price'] : '') . '" value="' . ($sku['price'] > 0 ? $sku['price'] : '') . '" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini" maxlength="10" data-max-price="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" value="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" /></td>';
                    $html .= '    </tr>';
                }
            }
            $html .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-price" href="javascript:;">价格</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
        }*/
        if ($product['supplier_id']) { //分销商品
            $product_id = $id;
            $id = $product['source_product_id'];
            $pids = $product_to_property->getPids($product['supplier_id'], $id);
            if (!empty($pids[0]['pid'])) {
                $pid = $pids[0]['pid'];
                $name = $product_property->getName($pid);
                $vids = $product_to_property_value->getVids($product['supplier_id'], $id, $pid);
                if (!empty($pids[1]['pid']) && !empty($pids[2]['pid'])) {
                    $pid1 = $pids[1]['pid'];
                    $name1 = $product_property->getName($pid1);
                    $vids1 = $product_to_property_value->getVids($product['supplier_id'], $id, $pid1);
                    $pid2 = $pids[2]['pid'];
                    $name2 = $product_property->getName($pid2);
                    $vids2 = $product_to_property_value->getVids($product['supplier_id'], $id, $pid2);
                    $html = '<thead>';
                    $html .= '    <tr>';
                    $html .= '        <th class="text-center" width="80">' . $name . '</th>';
                    $html .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                    $html .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                    $html .= '        <th class="th-price" style="width: 70px;text-align: center">成本价（元）</th>';
                    $html .= '        <th class="th-price" style="width: 105px;text-align: center">建议售价（元）</th>';
                    $html .= '    </tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                    foreach ($vids as $key => $vid) {
                        $value = $product_property_value->getValue($pid, $vid['vid']);
                        foreach ($vids1 as $key1 => $vid1) {
                            $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                            foreach ($vids2 as $key2 => $vid2) {
                                $properties = $pid . ':' . $vid['vid']. ';' . $pid1 . ':' . $vid1['vid'] . ';' . $pid2 . ':' . $vid2['vid'];
                                $sku = $product_sku->getSku($id, $properties);
                                $sku2 = $product_sku->getSku($product_id, $properties);
                                $html .= '    <tr class="sku" sku-id="' . $sku2['sku_id'] . '" properties="' . $sku2['properties'] . '">';
                                $value2 = $product_property_value->getValue($pid2, $vid2['vid']);
                                if($key1 == 0 && $key2 == 0) {
                                    $html .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                                }
                                if($key2 == 0) {
                                    $html .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                                }
                                $html .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                                if (!empty($product['unified_price_setting'])) { //供货商统一定价
                                    if (($_SESSION['store']['drp_level'] + 1) > 3) {
                                        $next_drp_level = 3;
                                    } else {
                                        $next_drp_level = $_SESSION['store']['drp_level'] + 1;
                                    }
                                    $html .= '        <td style="text-align: center">' . $sku2['drp_level_' . $next_drp_level . '_cost_price'] . '<input type="hidden" name="cost_sku_price" class="js-cost-price input-mini" value="' . $sku2['drp_level_' . $next_drp_level . '_cost_price'] . '" /></td>';
                                    $html .= '        <td style="text-align: center">' . $sku2['drp_level_' . $next_drp_level . '_price'] . '<input type="hidden" name="sku_price" class="js-price js-fx-min-price input-mini" value="' . $sku2['drp_level_' . $next_drp_level . '_price'] . '" /><input type="hidden" name="sku_price" class="js-price js-fx-max-price input-mini" value="' . $sku2['drp_level_' . $next_drp_level . '_price'] . '" /></td>';
                                } else {
                                    $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['cost_price'] . '" data-max-cost-price="' . $sku['max_fx_price'] . '"  value="' . $sku['cost_price'] . '" maxlength="10" ' . $readonly . ' /></td>';
                                    $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" data-min-price="' . ($sku['min_fx_price'] > 0 ? $sku['min_fx_price'] : '') . '" value="' . ($sku['min_fx_price'] > 0 ? $sku['min_fx_price'] : '') . '" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini" maxlength="10" data-max-price="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" value="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" /></td>';
                                }
                                $html .= '    </tr>';
                            }
                        }
                    }
                } else if (!empty($pids[1]['pid'])) {
                    $pid1 = $pids[1]['pid'];
                    $name1 = $product_property->getName($pid1);
                    $vids1 = $product_to_property_value->getVids($product['supplier_id'], $id, $pid1);
                    $html = '<thead>';
                    $html .= '    <tr>';
                    $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                    $html .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                    $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                    $html .= '        <th class="th-price" style="width: 105px;text-align: center">建议售价（元）</th>';
                    $html .= '    </tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                    foreach ($vids as $key => $vid) {
                        $value = $product_property_value->getValue($pid, $vid['vid']);
                        foreach ($vids1 as $key1 => $vid1) {
                            $properties = $pid . ':' . $vid['vid']. ';' . $pid1 . ':' . $vid1['vid'];
                            $sku = $product_sku->getSku($id, $properties);
                            $sku2 = $product_sku->getSku($product_id, $properties);
                            $html .= '    <tr class="sku" sku-id="' . $sku2['sku_id'] . '" properties="' . $sku2['properties'] . '">';
                            $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                            if($key1 == 0) {
                                $html .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                            }
                            $html .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                            if (!empty($product['unified_price_setting'])) { //供货商统一定价
                                if (($_SESSION['store']['drp_level'] + 1) > 3) {
                                    $next_drp_level = 3;
                                } else {
                                    $next_drp_level = $_SESSION['store']['drp_level'] + 1;
                                }
                                $html .= '        <td style="text-align: center">' . $sku2['drp_level_' . $next_drp_level . '_cost_price'] . '<input type="hidden" name="cost_sku_price" class="js-cost-price input-mini" value="' . $sku2['drp_level_' . $next_drp_level . '_cost_price'] . '" /></td>';
                                $html .= '        <td style="text-align: center">' . $sku2['drp_level_' . $next_drp_level . '_price'] . '<input type="hidden" name="sku_price" class="js-price js-fx-min-price input-mini" value="' . $sku2['drp_level_' . $next_drp_level . '_price'] . '" /><input type="hidden" name="sku_price" class="js-price js-fx-max-price input-mini" value="' . $sku2['drp_level_' . $next_drp_level . '_price'] . '" /></td>';
                            } else {
                                $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['cost_price'] . '" data-max-cost-price="' . $sku['max_fx_price'] . '" value="' . $sku['cost_price'] . '" maxlength="10" ' . $readonly . ' /></td>';
                                $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" data-min-price="' . ($sku['min_fx_price'] > 0 ? $sku['min_fx_price'] : '') . '" value="' . ($sku['min_fx_price'] > 0 ? $sku['min_fx_price'] : '') . '" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini"  maxlength="10" data-max-price="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" value="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" /></td>';
                            }
                            $html .= '    </tr>';
                        }
                    }
                } else {
                    $html = '<thead>';
                    $html .= '    <tr>';
                    $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                    $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                    $html .= '        <th class="th-price" style="width: 105px;text-align: center">建议售价（元）</th>';
                    $html .= '    </tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                    foreach ($vids as $key => $vid) {
                        $value = $product_property_value->getValue($pid, $vid['vid']);
                        $properties = $pid . ':' . $vid['vid'];
                        $sku = $product_sku->getSku($id, $properties);
                        $sku2 = $product_sku->getSku($product_id, $properties);
                        $html .= '    <tr class="sku" sku-id="' . $sku2['sku_id'] . '" properties="' . $sku2['properties'] . '">';
                        $value = $product_property_value->getValue($pid, $vid['vid']);
                        $html .= '        <td class="text-center" width="50">' . $value . '</td>';
                        if (!empty($product['unified_price_setting'])) { //供货商统一定价
                            if (($_SESSION['store']['drp_level'] + 1) > 3) {
                                $next_drp_level = 3;
                            } else {
                                $next_drp_level = $_SESSION['store']['drp_level'] + 1;
                            }
                            $html .= '        <td style="text-align: center">' . $sku2['drp_level_' . $next_drp_level . '_cost_price'] . '<input type="hidden" name="cost_sku_price" class="js-cost-price input-mini" value="' . $sku2['drp_level_' . $next_drp_level . '_cost_price'] . '" /></td>';
                            $html .= '        <td style="text-align: center">' . $sku2['drp_level_' . $next_drp_level . '_price'] . '<input type="hidden" name="sku_price" class="js-price js-fx-min-price input-mini" value="' . $sku2['drp_level_' . $next_drp_level . '_price'] . '" /><input type="hidden" name="sku_price" class="js-price js-fx-max-price input-mini" value="' . $sku2['drp_level_' . $next_drp_level . '_price'] . '" /></td>';
                        } else {
                            $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" data-min-cost-price="' . $sku['cost_price'] . '" data-max-cost-price="' . $sku['max_fx_price'] . '" value="' . $sku['cost_price'] . '" maxlength="10" ' . $readonly . ' /></td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" data-min-price="' . ($sku['min_fx_price'] > 0 ? $sku['min_fx_price'] : '') . '" value="' . ($sku['min_fx_price'] > 0 ? $sku['min_fx_price'] : '') . '" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini" maxlength="10" data-max-price="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" value="' . ($sku['max_fx_price'] > 0 ? $sku['max_fx_price'] : '') . '" /></td>';
                        }
                        $html .= '    </tr>';
                    }
                }
                $html .= '</tbody>';
                if (empty($product['unified_price_setting'])) { //供货商统一定价
                    $html .= '<tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-cost" href="javascript:;">成本价</a>&nbsp;&nbsp;<a class="js-batch-price" href="javascript:;">分销价</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
                }
            }
        } else {
            $pids = $product_to_property->getPids($this->store_session['store_id'], $id);
            if (!empty($pids[0]['pid'])) {
                $pid = $pids[0]['pid'];
                $name = $product_property->getName($pid);
                $vids = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid);
                if (!empty($pids[1]['pid']) && !empty($pids[2]['pid'])) {
                    $pid1 = $pids[1]['pid'];
                    $name1 = $product_property->getName($pid1);
                    $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                    $pid2 = $pids[2]['pid'];
                    $name2 = $product_property->getName($pid2);
                    $vids2 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid2);
                    $html = '<thead>';
                    $html .= '    <tr>';
                    $html .= '        <th class="text-center" width="80">' . $name . '</th>';
                    $html .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                    $html .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                    $html .= '        <th class="th-price" style="width: 70px;text-align: center">成本价（元）</th>';
                    $html .= '        <th class="th-price" style="width: 105px;text-align: center">建议售价（元）</th>';
                    $html .= '    </tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';
                    $html2 = '<thead>';
                    $html2 .= '    <tr>';
                    $html2 .= '        <th class="text-center" width="80">' . $name . '</th>';
                    $html2 .= '        <th class="text-center" width="80">' . $name1 . '</th>';
                    $html2 .= '        <th class="text-center" width="80">' . $name2 . '</th>';
                    $html2 .= '        <th class="th-price" style="width: 70px;text-align: center">成本价（元）</th>';
                    $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                    $html2 .= '    </tr>';
                    $html2 .= '</thead>';
                    $html2 .= '<tbody>';
                    foreach ($vids as $key => $vid) {
                        $value = $product_property_value->getValue($pid, $vid['vid']);
                        foreach ($vids1 as $key1 => $vid1) {
                            $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                            foreach ($vids2 as $key2 => $vid2) {
                                $properties = $pid . ':' . $vid['vid']. ';' . $pid1 . ':' . $vid1['vid'] . ';' . $pid2 . ':' . $vid2['vid'];
                                $sku = $product_sku->getSku($id, $properties);
                                $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                                $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                                $value2 = $product_property_value->getValue($pid2, $vid2['vid']);
                                if($key1 == 0 && $key2 == 0) {
                                    $html .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                                    $html2 .= '    <td class="text-center" rowspan="' . count($vids1) * count($vids2) . '">' . $value . '</td>';
                                }
                                if($key2 == 0) {
                                    $html .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                                    $html2 .= '    <td class="text-center" rowspan="' . count($vids2) . '">' . $value1 . '</td>';
                                }
                                $html .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                                $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini"  maxlength="10" /></td>';
                                $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini" maxlength="10" /></td>';
                                $html .= '    </tr>';

                                $html2 .= '        <td class="text-center" width="50">' . $value2 . '</td>';
                                $html2 .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini"  maxlength="10" /></td>';
                                $html2 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-price input-mini" maxlength="10" /></td>';
                                $html2 .= '    </tr>';
                            }
                        }
                    }
                } else if (!empty($pids[1]['pid'])) {
                    $pid1 = $pids[1]['pid'];
                    $name1 = $product_property->getName($pid1);
                    $vids1 = $product_to_property_value->getVids($this->store_session['store_id'], $id, $pid1);
                    $html = '<thead>';
                    $html .= '    <tr>';
                    $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                    $html .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                    $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                    $html .= '        <th class="th-price" style="width: 105px;text-align: center">建议售价（元）</th>';
                    $html .= '    </tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';

                    $html2 = '<thead>';
                    $html2 .= '    <tr>';
                    $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                    $html2 .= '        <th class="text-center" width="50">' . $name1 . '</th>';
                    $html2 .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                    $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                    $html2 .= '    </tr>';
                    $html2 .= '</thead>';
                    $html2 .= '<tbody>';
                    foreach ($vids as $key => $vid) {
                        $value = $product_property_value->getValue($pid, $vid['vid']);
                        foreach ($vids1 as $key1 => $vid1) {
                            $properties = $pid . ':' . $vid['vid']. ';' . $pid1 . ':' . $vid1['vid'];
                            $sku = $product_sku->getSku($id, $properties);
                            $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                            $value1 = $product_property_value->getValue($pid1, $vid1['vid']);
                            if($key1 == 0) {
                                $html .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                                $html2 .= '    <td class="text-center" rowspan="' . count($vids1) . '">' . $value . '</td>';
                            }
                            $html .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                            $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" maxlength="10" />';
                            $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini"  maxlength="10" /></td>';
                            $html .= '    </tr>';

                            $html2 .= '        <td class="text-center" width="50">' . $value1 . '</td>';
                            $html2 .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" maxlength="10" />';
                            $html2 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-price input-mini" maxlength="10" /></td>';
                            $html2 .= '    </tr>';
                        }
                    }
                } else {
                    $html = '<thead>';
                    $html .= '    <tr>';
                    $html .= '        <th class="text-center" width="50">' . $name . '</th>';
                    $html .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                    $html .= '        <th class="th-price" style="width: 105px;text-align: center">建议售价（元）</th>';
                    $html .= '    </tr>';
                    $html .= '</thead>';
                    $html .= '<tbody>';

                    $html2 = '<thead>';
                    $html2 .= '    <tr>';
                    $html2 .= '        <th class="text-center" width="50">' . $name . '</th>';
                    $html2 .= '        <th class="th-price" style="text-align: center">成本价（元）</th>';
                    $html2 .= '        <th class="th-price" style="width: 105px;text-align: center">分销价（元）</th>';
                    $html2 .= '    </tr>';
                    $html2 .= '</thead>';
                    $html2 .= '<tbody>';
                    foreach ($vids as $key => $vid) {
                        $value = $product_property_value->getValue($pid, $vid['vid']);
                        $properties = $pid . ':' . $vid['vid'];
                        $sku = $product_sku->getSku($id, $properties);
                        $html .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                        $html2 .= '    <tr class="sku" sku-id="' . $sku['sku_id'] . '" properties="' . $sku['properties'] . '">';
                        $value = $product_property_value->getValue($pid, $vid['vid']);
                        $html .= '        <td class="text-center" width="50">' . $value . '</td>';
                        $html .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" maxlength="10" /></td>';
                        $html .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-min-price input-mini" maxlength="10" /> - <input type="text" name="sku_price" class="js-price js-fx-max-price input-mini" maxlength="10" /></td>';
                        $html .= '    </tr>';

                        $html2 .= '        <td class="text-center" width="50">' . $value . '</td>';
                        $html2 .= '        <td style="text-align: center"><input type="text" name="cost_sku_price" class="js-cost-price input-mini" maxlength="10" /></td>';
                        $html2 .= '        <td style="text-align: center"><input type="text" name="sku_price" class="js-price js-fx-price input-mini" maxlength="10" /></td>';
                        $html2 .= '    </tr>';
                    }
                }
                $html .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts">批量设置： <span class="js-batch-type"><a class="js-batch-cost" href="javascript:;">成本价</a>&nbsp;&nbsp;<a class="js-batch-price" href="javascript:;">分销价</a></span><span class="js-batch-form" style="display:none;"></span></div></td></tr></tfoot>';
                $html2 .= '</tbody><tfoot><tr><td colspan="6"><div class="batch-opts2">批量设置： <span class="js-batch-type2"><a class="js-batch-cost2" href="javascript:;">成本价</a>&nbsp;&nbsp;<a class="js-batch-price2" href="javascript:;">分销价</a></span><span class="js-batch-form2" style="display:none;"></span></div></td></tr></tfoot>';
            }
        }
        $this->assign('edit_cost_price', $edit_cost_price);
        $this->assign('sku_content', $html);
        $this->assign('sku_content2', $html2);
        if (!empty($product['source_product_id'])) {
            $source_product = M('Product')->get(array('product_id' => $product['source_product_id'], 'store_id' => $product['supplier_id']));
            $min_fx_price = $source_product['min_fx_price'];
            $max_fx_price = $source_product['max_fx_price'];
            $cost_price = $source_product['cost_price'];

            if (!empty($product['unified_price_setting'])) {
                if (($_SESSION['store']['drp_level'] + 1) > 3) {
                    $next_drp_level = 3;
                } else {
                    $next_drp_level = $_SESSION['store']['drp_level'] + 1;
                }
                $cost_price = $source_product['drp_level_' . $next_drp_level . '_cost_price'];
                $min_fx_price = $source_product['drp_level_' . $next_drp_level . '_price'];
                $max_fx_price = $source_product['drp_level_' . $next_drp_level . '_price'];
            }
        } else {
            $min_fx_price = $product['min_fx_price'];
            $max_fx_price = $product['max_fx_price'];
            $cost_price = $product['cost_price'];
        }
        $this->assign('product', $product);
        $this->assign('min_fx_price', $min_fx_price);
        $this->assign('max_fx_price', $max_fx_price);
        $this->assign('cost_price', $cost_price);
        if (empty($product['supplier_id'])) {
            $is_supplier = true;
        } else {
            $is_supplier = false;
        }
        $this->assign('is_supplier', $is_supplier);
        $this->assign('drp_level', $_SESSION['store']['drp_level']);
    }

    public function delivery_address()
    {
        import('source.class.area');
        $user_address = M('User_address');

        if (IS_POST && !empty($_POST['type'])) {
            $data = array();
            $data['name']     = isset($_POST['name']) ? trim($_POST['name']) : '';
            $data['tel']      = isset($_POST['tel']) ? trim($_POST['tel']) : '';
            $data['province'] = isset($_POST['province']) ? intval(trim($_POST['province'])) : '';
            $data['city']     = isset($_POST['city']) ? intval(trim($_POST['city'])) : '';
            $data['area']     = isset($_POST['area']) ? intval(trim($_POST['area'])) : '';
            $data['address']  = isset($_POST['address']) ? trim($_POST['address']) : '';
            $data['zipcode']  = isset($_POST['zipcode']) ? intval(trim($_POST['zipcode'])) : '';
            $data['add_time'] = time();
            $data['uid']      = $this->user_session['uid'];
            if ($address_id = $user_address->add($data)) {
                $address = new area();
                $address_detail = array();
                $address_detail['address_id'] = $address_id;
                $address_detail['province']   = $address->get_name($data['province']);
                $address_detail['city']       = $address->get_name($data['city']);
                $address_detail['area']       = $address->get_name($data['area']);
                $address_detail['address']    = $data['address'];
                json_return(0, $address_detail);
            } else {
                json_return(1001, '收货地址添加失败');
            }
        }
        //收货地址
        $tmp_addresses = $user_address->getMyAddress($this->user_session['uid']);
        $addresses = array();
        $address = new area();
        foreach ($tmp_addresses as $tmp_address) {
            $province = $address->get_name($tmp_address['province']);
            $city = $address->get_name($tmp_address['city']);
            $area = $address->get_name($tmp_address['area']);
            $addresses[] = array(
                'address_id' => $tmp_address['address_id'],
                'province'   => $province,
                'city'       => $city,
                'area'       => $area,
                'address'    => $tmp_address['address']
            );
        }
        echo json_encode($addresses);
        exit;
    }

    //客服联系方式
    public function service()
    {
        if (IS_POST && strtolower($_POST['type']) == 'check') {
            $store = M('Store');
            $store = $store->getStore($this->store_session['store_id']);
            if (empty($store['service_tel']) && empty($store['service_qq']) && empty($store['service_weixin'])) {
                json_return(1001, '没有填写客服联系方式');
            } else {
                json_return(0, '客服联系方式已填写');
            }
        } else if (IS_POST && strtolower($_POST['type']) == 'add') {
            $store = M('Store');
            $data = array();
            $data['service_tel']    = isset($_POST['tel']) ? trim($_POST['tel']) : '';
            $data['service_qq']     = isset($_POST['qq']) ? trim($_POST['qq']) : '';
            $data['service_weixin'] = isset($_POST['weixin']) ? trim($_POST['weixin']) : '';
            $where = array();
            $where['store_id'] = $this->store_session['store_id'];
            if ($store->setting($where, $data)) {
                json_return(0, '保存成功');
            } else {
                json_return(1001, '保存失败，请重新提交');
            }
        }
    }

    //分销经营统计
    public function statistics()
    {
        $this->display();
    }

    private function _statistics_content($data)
    {
        $fx_order = M('Fx_order');
        $financial_record = M('Financial_record');

        $days = array();
        if (empty($data['start_time']) && empty($data['stop_time'])) {
            for($i=7; $i>=1; $i--){
                $day = date("Y-m-d",strtotime('-'.$i.'day'));
                $days[] = $day;
            }
        } else if (!empty($data['start_time']) && !empty($data['stop_time'])) {
            $start_unix_time = strtotime($data['start_time']);
            $stop_unix_time = strtotime($data['stop_time']);
            $tmp_days = round(($stop_unix_time - $start_unix_time) / 3600 / 24);
            $days = array($data['start_time']);
            if ($data['stop_time'] >$data['start_time']) {
                for($i=1; $i<$tmp_days; $i++){
                    $days[] = date("Y-m-d",strtotime($data['start_time'] . ' +'.$i.'day'));
                }
                $days[] = $data['stop_time'];
            }
        } else if (!empty($data['start_time'])) { //开始时间到后6天的数据
            $stop_time = date("Y-m-d",strtotime($data['start_time']. ' +7 day'));
            $days = array($data['start_time']);
            for($i=1; $i<=6; $i++){
                $day = date("Y-m-d",strtotime($data['start_time'] .' +' . $i . 'day'));
                $days[] = $day;
            }
        } else if (!empty($data['stop_time'])) { //结束时间前6天的数据
            $start_time = date("Y-m-d",strtotime($data['stop_time']. ' -6 day'));
            $days = array($start_time);
            for($i=1; $i<=6; $i++){
                $day = date("Y-m-d",strtotime($start_time .' +' . $i . 'day'));
                $days[] = $day;
            }
        }

        //七天下单、付款、发货订单笔数和付款金额
        $days_7_orders = array();
        $days_7_paid_orders = array();
        $days_7_send_orders = array();
        $days_7_paid_total = array();
        $tmp_days = array();
        foreach ($days as $day) {
            //开始时间
            $start_time = strtotime($day . ' 00:00:00');
            //结束时间
            $stop_time = strtotime($day . ' 23:59:59');
            $where = array();
            $where['store_id'] = $data['store_id'];
            $where['status'] = array('in', array(1,2,3,4));
            $where['_string'] = "paid_time >= '" . $start_time . "' AND paid_time <= '" . $stop_time . "'";
            $tmp_days_7_sales = $fx_order->getSales($where);
            $days_7_sales[] = !empty($tmp_days_7_sales) ? number_format($tmp_days_7_sales, 2, '.', '') : 0;
            $where = array();
            $where['store_id'] = $data['store_id'];
            $where['_string'] = "add_time >= '" . $start_time . "' AND add_time <= '" . $stop_time . "'";
            $tmp_days_7_profits = $financial_record->drpProfit($where);
            $days_7_profits[] = !empty($tmp_days_7_profits) ? number_format($tmp_days_7_profits, 2, '.', '') : 0;

            $tmp_days[] = "'" . $day . "'";
        }
        $days = '[' . implode(',', $tmp_days) . ']';
        $days_7_sales = '[' . implode(',', $days_7_sales) . ']';
        $days_7_profits = '[' . implode(',', $days_7_profits) . ']';

        $this->assign('days', $days);
        $this->assign('days_7_sales', $days_7_sales);
        $this->assign('days_7_profits', $days_7_profits);
    }

    //分销配置
    public function setting()
    {
        $this->display();
    }

    private function _setting_content()
    {
        $this->assign('open_drp_approve', $this->store_session['open_drp_approve']);
        $this->assign('open_drp_guidance', $this->store_session['open_drp_guidance']);
        $this->assign('open_drp_limit', $this->store_session['open_drp_limit']);
        $this->assign('drp_limit_buy', $this->store_session['drp_limit_buy']);
        $this->assign('drp_limit_share', $this->store_session['drp_limit_share']);
        $this->assign('drp_limit_condition', $this->store_session['drp_limit_condition']);
    }

    //保存分销限制
    public function save_drp_limit()
    {
        $drp_limit_buy = !empty($_POST['drp_limit_buy']) ? floatval(trim($_POST['drp_limit_buy'])) : 0;
        $drp_limit_share = !empty($_POST['drp_limit_share']) ? intval(trim($_POST['drp_limit_share'])) : 0;
        $drp_limit_condition = !empty($_POST['drp_limit_condition']) ? intval(trim($_POST['drp_limit_condition'])) : 0;
        if (D('Store')->where(array('store_id' => $this->store_session['store_id']))->data(array('drp_limit_buy' => $drp_limit_buy, 'drp_limit_share' => $drp_limit_share, 'drp_limit_condition' => $drp_limit_condition))->save()) {
            $_SESSION['store']['drp_limit_buy']       = $drp_limit_buy;
            $_SESSION['store']['drp_limit_share']     = $drp_limit_share;
            $_SESSION['store']['drp_limit_condition'] = $drp_limit_condition;
            json_return(0, '分销限制条件保存成功');
        } else {
            json_return(1001, '分销限制条件保存失败');
        }
    }

    //是否开启分销商审核/审核状态
    public function drp_approve()
    {
        $seller_id = isset($_POST['seller_id']) ? intval(trim($_POST['seller_id'])) : 0;
        if (!empty($seller_id)) {
            $result = D('Store')->where(array('store_id' => $seller_id, 'drp_supplier_id' => $this->store_session['store_id']))->data(array('drp_approve' => 1))->save();
            if ($result) {
                $_SESSION['store']['drp_approve'] = 1;
                json_return(0, '审核已通过');
            } else {
                json_return(1001, '审核失败，请重新审核');
            }
        } else {
            $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
            $result = D('Store')->where(array('store_id' => $this->store_session['store_id']))->data(array('open_drp_approve' => $status))->save();
            if ($result) {
                $_SESSION['store']['open_drp_approve'] = $status;
                echo true;
            } else {
                echo false;
            }
        }
        exit;
    }

    //是否开启分销引导
    public function drp_guidance()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array('store_id' => $this->store_session['store_id']))->data(array('open_drp_guidance' => $status))->save();
        if ($result) {
            $_SESSION['store']['open_drp_guidance'] = $status;
            echo true;
        } else {
            echo false;
        }
    }

    //是否开启分销限制
    public function drp_limit()
    {
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0;
        $result = D('Store')->where(array('store_id' => $this->store_session['store_id']))->data(array('open_drp_limit' => $status))->save();
        if ($result) {
            $_SESSION['store']['open_drp_limit'] = $status;
            echo true;
        } else {
            echo false;
        }
    }

    //禁用/启用分销商
    public function drp_status()
    {
        $store = M('Store');
        $store_supplier = M('Store_supplier');
        $seller_id = isset($_POST['seller_id']) ? intval(trim($_POST['seller_id'])) : 0; //分销商id
        $status = isset($_POST['status']) ? intval(trim($_POST['status'])) : 0; //状态
        if ($store->setting(array('store_id' => $seller_id), array('status' => $status))) {
            $sellers = $store_supplier->getSellers(array('supplier_id' => $seller_id));
            foreach ($sellers as $seller) {
                $store->setting(array('store_id' => $seller['seller_id']), array('status' => $status));
                $this->_seller_status($store_supplier, $store, $seller['seller_id'], $status);
            }
            json_return(0, '操作成功');
        } else {
            json_return(1001, '操作失败');
        }
    }

    //校验密码
    public function check_password()
    {
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        if ($password) {
            $password = md5($password);
        }
        $uid = $this->user_session['uid'];
        if (D('User')->where(array('uid' => $uid, 'password' => $password))->count('uid')) {
            json_return(0, '密码正确');
        } else {
            json_return(1001, '密码错误');
        }
    }

    private function _seller_status($store_supplier, $store, $seller_id, $status)
    {
        $sellers = $store_supplier->getSellers(array('supplier_id' => $seller_id));
        if (!empty($sellers)) {
            foreach ($sellers as $seller) {
                $store->setting(array('store_id' => $seller['seller_id']), array('status' => $status));
                $this->_seller_status($store_supplier, $store, $seller['seller_id'], $status);
            }
        }
    }
}