<?php

/**
 * 自定义字段
 * User: pigcms_21
 * Date: 2015/2/9
 * Time: 20:47
 */
class custom_field_model extends base_model {

    /**
     * 修改
     * 
     * store_id  	  店铺字段
     * custom   	  自定义字段
     * module_name    MODULE 名称
     * module_id      MODULE ID
     *
     */
    public function save_field($store_id, $custom, $module_name, $module_id) {
        $this->delete_field($store_id, $module_name, $module_id);

        $data_fields = array();
        $data_field['store_id'] = $store_id;
        $data_field['module_name'] = $module_name;
        $data_field['module_id'] = $module_id;
        foreach ($custom as $value) {
            $data_field['field_type'] = $value['type'];
            $data_field['content'] = serialize($this->clear_field($value));
            $data_fields[] = $data_field;
        }
        if (!empty($data_fields)) {
            $result = $this->db->data($data_fields)->addAll();
            return $result;
        } else {
            return 1;
        }
    }

    /**
     * 增加
     * 
     * store_id  	  店铺字段
     * custom   	  自定义字段
     * module_name    MODULE 名称
     * module_id      MODULE ID
     *
     */
    public function add_field($store_id, $custom, $module_name, $module_id) {
        $data_fields = array();
        $data_field['store_id'] = $store_id;
        $data_field['module_name'] = $module_name;
        $data_field['module_id'] = $module_id;
        foreach ($custom as $value) {
            $data_field['field_type'] = $value['type'];
            $data_field['content'] = serialize($this->clear_field($value));
            $data_fields[] = $data_field;
        }
        if (!empty($data_fields)) {
            $result = $this->db->data($data_fields)->addAll();
            return $result;
        } else {
            return 1;
        }
    }

    /**
     * 删除
     * 
     * store_id  	  店铺字段
     * custom   	  自定义字段
     * module_name    MODULE 名称
     * module_id      MODULE ID
     *
     */
    public function delete_field($store_id, $module_name, $module_id) {
        $condition_field['store_id'] = $store_id;
        $condition_field['module_name'] = $module_name;
        $condition_field['module_id'] = $module_id;
        $this->db->where($condition_field)->delete();
        return 1;
    }

    /**
     * 查询
     * 
     * store_id  	  店铺字段
     * module_name    MODULE 名称
     * module_id      MODULE ID
     *
     */
    public function get_field($store_id, $module_name, $module_id) {
        if ($store_id) {
            $condition_field['store_id'] = $store_id;
        }
		
        $condition_field['module_name'] = $module_name;
        $condition_field['module_id'] = $module_id;
        $field_list = $this->db->field('`module_name`,`field_type`,`content`')->where($condition_field)->order('`field_id` ASC')->select();
        foreach ($field_list as &$value) {
            $value['content'] = unserialize($value['content']);
            if (strtolower($value['field_type']) == 'goods') {
                if (!empty($value['content']['goods'])) {
                    $goods = array();
                    foreach ($value['content']['goods'] as $product) {
                        $product['title'] = htmlspecialchars_decode($product['title']);
                        $product['image'] = getAttachmentUrl($product['image']);
                        $goods[] = $product;
                    }
                    $value['content']['goods'] = $goods;
                }
            } else if (strtolower($value['field_type']) == 'rich_text') {
                $value['content']['content'] = htmlspecialchars_decode($value['content']['content']);
            } else if (strtolower($value['field_type']) == 'title') {
                $value['content']['title'] = htmlspecialchars_decode($value['content']['title']);
                $value['content']['sub_title'] = htmlspecialchars_decode($value['content']['sub_title']);
            } else if (strtolower($value['field_type']) == 'text_nav') {
                $text_navs = array();
                foreach ($value['content'] as $key => $nav) {
                    $nav['title'] = htmlspecialchars_decode($nav['title']);
                    $nav['name'] = htmlspecialchars_decode($nav['name']);
                    $text_navs[$key] = $nav;
                }
                $value['content'] = $text_navs;
            } else if (strtolower($value['field_type']) == 'image_nav') {
                $image_navs = array();
                foreach ($value['content'] as $key => $nav) {
                    $nav['title'] = htmlspecialchars_decode($nav['title']);
                    $nav['name'] = htmlspecialchars_decode($nav['name']);
                    $nav['image'] = getAttachmentUrl($nav['image']);
                    $image_navs[$key] = $nav;
                }
                $value['content'] = $image_navs;
            } else if (strtolower($value['field_type']) == 'link') {
                $links = array();
                if (!empty($value['content'])) {
                    foreach ($value['content'] as $key => $link) {
                        $link['title'] = htmlspecialchars_decode($link['title']);
                        $link['name'] = htmlspecialchars_decode($link['name']);
                        $links[$key] = $link;
                    }
                }
                $value['content'] = $links;
            } else if (strtolower($value['field_type']) == 'notice') {
                $value['content']['content'] = htmlspecialchars_decode($value['content']['content']);
            } else if (strtolower($value['field_type']) == 'image_ad') {
                if (!empty($value['content']['nav_list'])) {
                    $ads = array();
                    foreach ($value['content']['nav_list'] as $ad) {
                        $ad['title'] = htmlspecialchars_decode($ad['title']);
                        $ad['name'] = htmlspecialchars_decode($ad['name']);
                        $ad['image'] = getAttachmentUrl($ad['image']);
                        $ads[] = $ad;
                    }
                    $value['content']['nav_list'] = $ads;
                }
            }
        }
        return $field_list;
    }

    /**
     * 
     *  清空数组里空的字段 
     * 
     */
    protected function clear_field($array) {
        $new_array = array();
        if (is_array($array)) {
            if (!empty($array['goods'])) {
                $goods = array();
                foreach ($array['goods'] as $product) {
                    $product['title'] = htmlspecialchars($product['title'], ENT_QUOTES); //解决serialize序列化单引号问题
                    $product['image'] = getAttachment($product['image']);
                    $goods[] = $product;
                }
                $array['goods'] = $goods;
            } else if (strtolower($array['type']) == 'rich_text') {
                $array['content'] = htmlspecialchars($array['content'], ENT_QUOTES);
            } else if (strtolower($array['type']) == 'title') {
                $array['title'] = htmlspecialchars($array['title'], ENT_QUOTES);
                $array['sub_title'] = htmlspecialchars($array['sub_title'], ENT_QUOTES);
            } else if (strtolower($array['type']) == 'text_nav') {
                $type = array_pop($array);
                $text_navs = array();
                foreach ($array as $key => $nav) {
                    $nav['title'] = htmlspecialchars($nav['title'], ENT_QUOTES);
                    $nav['name'] = htmlspecialchars($nav['name'], ENT_QUOTES);
                    $text_navs[$key] = $nav;
                }
                $array = $text_navs;
                $array['type'] = $type;
            } else if (strtolower($array['type']) == 'image_nav') {
                $type = array_pop($array);
                $image_navs = array();
                foreach ($array as $key => $nav) {
                    $nav['title'] = htmlspecialchars($nav['title'], ENT_QUOTES);
                    $nav['name'] = htmlspecialchars($nav['name'], ENT_QUOTES);
                    $image_navs[$key] = $nav;
                }
                $array = $image_navs;
                $array['type'] = $type;
            } else if (strtolower($array['type']) == 'link') {
                $type = array_pop($array);
                $links = array();
                foreach ($array as $key => $link) {
                    $link['title'] = htmlspecialchars($link['title'], ENT_QUOTES);
                    $link['name'] = htmlspecialchars($link['name'], ENT_QUOTES);
                    $links[$key] = $link;
                }
                $array = $links;
                $array['type'] = $type;
            } else if (strtolower($array['type']) == 'notice') {
                $array['content'] = htmlspecialchars($array['content'], ENT_QUOTES);
            } else if (strtolower($array['type']) == 'component') {
                $array['name'] = htmlspecialchars($array['name'], ENT_QUOTES);
            }

            foreach ($array as $key => $value) {
                if (!empty($value) && $key != 'type') {
                    $new_array[$key] = $value;
                }
            }
        }
        return $new_array;
    }

    /**
     * 查询并解析，返回内容数组 返回  type,content
     * 
     * store_id  	  店铺字段
     * module_name    MODULE 名称
     * module_id      MODULE ID
     *
     */
    public function getParseFields($store_id, $module_name, $module_id) {
        $field_list = $this->get_field($store_id, $module_name, $module_id);
        if (empty($field_list))
            return array();
        $fieldHtmlArr = array();
        foreach ($field_list as $key => $value) {
            if (empty($value['content']) && !in_array($value['field_type'], array('line', 'search', 'store')))
                continue;
            $fieldHtml = array();
            $fieldHtml['type'] = $value['field_type'];
            $fieldContent = $value['content'];
            switch ($value['field_type']) {
                case 'title':
                    $fieldHtml['html'] = '<!-- 标题 -->';
                    $fieldHtml['html'] .= '<div' . (!empty($fieldContent['bgcolor']) ? ' class="custom-title-noline" style="background-color:' . $fieldContent['bgcolor'] . ';"' : '') . '>';
                    $fieldHtml['html'] .= '<div class="custom-title ' . ($fieldContent['show_method'] == 0 ? 'text-left' : ($fieldContent['show_method'] == 1 ? 'text-center' : 'text-right')) . '">';
                    $fieldHtml['html'] .= '<h2 class="title">' . htmlspecialchars_decode($fieldContent['title']) . '</h2>';
                    $fieldHtml['html'] .= '<p class="sub_title">' . htmlspecialchars_decode($fieldContent['sub_title']) . '</p>';
                    $fieldHtml['html'] .= '</div>';
                    $fieldHtml['html'] .= '</div>';
                    break;
                case 'rich_text':
                    $fieldHtml['html'] = '<!-- 富文本内容区域 -->';
                    $fieldHtml['html'] .= '<div class="custom-richtext' . (!empty($fieldContent['screen']) ? ' custom-richtext-fullscreen' : '') . '" ' . (!empty($fieldContent['bgcolor']) ? 'style="background-color:' . $fieldContent['bgcolor'] . ';"' : '') . '>';
                    $fieldHtml['html'] .= htmlspecialchars_decode($fieldContent['content']);
                    $fieldHtml['html'] .= '</div>';
                    break;
                case 'notice':
                    if (!empty($fieldContent['content'])) {
                        $fieldHtml['html'] = '<!-- 店铺公告 -->';
                        $fieldHtml['html'] .= '<div class="custom-notice"><div class="custom-notice-inner"><div class="custom-notice-scroll"><span class="js-scroll-notice">公告：' . htmlspecialchars_decode($fieldContent['content']) . '</span></div></div></div>';
                    }
                    break;
                case 'line':
                    $fieldHtml['html'] = '<!-- 辅助线 -->';
                    $fieldHtml['html'] .= '<div class="custom-line-wrap"><hr class="custom-line"></div>';
                    break;
                case 'white':
                    $fieldHtml['html'] = '<!-- 辅助空白 -->';
                    $fieldHtml['html'] .= '<div class="custom-white" style="height:' . $fieldContent['height'] . 'px;"></div>';
                    break;
                case 'search':
                    $fieldHtml['html'] = '<!-- 商品搜索 -->';
                    $fieldHtml['html'] .= '<div class="custom-search"><form action="./search.php" method="get"><input type="search" class="custom-search-input" placeholder="商品搜索：请输入商品关键字" name="q" value=""/><input type="hidden" name="store_id" value="' . $store_id . '"/><button type="submit" class="custom-search-button">搜索</button></form></div>';
                    break;
                case 'store':
                    $fieldHtml['html'] = '<!-- 进入店铺 -->';
                    $fieldHtml['html'] .= '<div class="custom-store"><a class="custom-store-link clearfix" href="' . option('now_store.url') . '"><div class="custom-store-img"></div><div class="custom-store-name">' . option('now_store.name') . '</div><span class="custom-store-enter">进入店铺</span></a></div>';
                    break;
                case 'text_nav':
                    $fieldHtml['html'] = '<!-- 文本导航 -->';
                    $fieldHtml['html'] .= '<ul class="custom-nav clearfix">';
                    foreach ($fieldContent as $v) {
                        if (!empty($v['title'])) {
                            $fieldHtml['html'] .= '<li><a class="clearfix relative arrow-right" href="' . ($v['url'] ? $v['url'] : 'javascript:void(0);') . '" target="_blank"><span class="custom-nav-title">' . htmlspecialchars_decode($v['title']) . '</span></a></li>';
                        }
                    }
                    $fieldHtml['html'] .= '</ul>';
                    break;
                case 'image_nav':
                    $fieldHtml['html'] = '<!-- 图片导航 -->';
                    $fieldHtml['html'] .= '<ul class="custom-nav-4 clearfix">';
                    foreach ($fieldContent as $v) {
                        //if(!empty($v['title'])){
                        $fieldHtml['html'] .= '<li><a href="' . ($v['url'] ? $v['url'] : 'javascript:void(0);') . '" target="_blank"><span class="nav-img-wap">' . ($v['image'] ? '<img class="js-lazy" src="' . getAttachmentUrl($v['image']) . '" style="display:inline;"/>' : '&nbsp;') . '</span><span class="title">' . htmlspecialchars_decode($v['title']) . '</span></a></li>';
                        //}
                    }
                    $fieldHtml['html'] .= '</ul>';
                    break;
                case 'component':
                    if (!empty($fieldContent['id'])) {
                        $fieldHtml['html'] = '<!-- 自定义模块 -->';
                        $comFieldHtml = $this->getParseFields($store_id, 'custom_page', $fieldContent['id']);
                        foreach ($comFieldHtml as $value) {
                            $fieldHtml['html'] .= $value['html'];
                        }
                    }
                    break;
                case 'link':
                    $fieldHtml['html'] = '<!-- 关联链接 -->';
                    $fieldHtml['html'] .= '<ul class="custom-nav clearfix">';
                    foreach ($fieldContent as $v) {
                        if ($v['type'] == 'link') {
                            $fieldHtml['html'] .= '<li><a class="custom-link-link clearfix relative arrow-right" href="' . ($v['url'] ? $v['url'] : 'javascript:void(0);') . '" target="_blank"><span class="custom-nav-title">' . ($v['name'] ? htmlspecialchars_decode($v['name']) : '自定义外链') . '</span></a></li>';
                        } elseif ($v['widget'] == 'pagecat') {
                            $page_list = M('Wei_page')->getCategoryPageNumberList($v['id'], $v['number']);
                            foreach ($page_list as $jv) {
                                $fieldHtml['html'] .= '<li><a class="clearfix relative arrow-right" href="' . option('config.wap_site_url') . '/page.php?id=' . $jv['page_id'] . '" target="_blank"><span class="custom-nav-title">' . htmlspecialchars_decode($jv['page_name']) . '</span></a></li>';
                            }
                        } elseif ($v['widget'] == 'goodcat') {
                            $product_list = M('Product')->getGroupGoodNumberList($v['id'], $v['number']);
                            foreach ($product_list as $jv) {
                                $fieldHtml['html'] .= '<li><a class="clearfix relative arrow-right" href="' . option('config.wap_site_url') . '/good.php?id=' . $jv['product_id'] . '" target="_blank"><span class="custom-nav-title">' . htmlspecialchars_decode($jv['name']) . '</span></a></li>';
                            }
                        }
                    }
                    $fieldHtml['html'] .= '</ul>';
                    break;
                case 'image_ad':
                    $fieldHtml['html'] = '<!-- 图片广告 --><style type="text/css"> .custom-image-swiper .swiper-slide a {width: 100%!important;}</style>';
                    if (!empty($fieldContent['nav_list'])) {
						//dump($fieldContent);
                        if (empty($fieldContent['image_type'])) {
                            $fieldHtml['html'] .= '<div class="custom-image-swiper" data-max-height="' . $fieldContent['max_height'] . '" data-max-width="' . $fieldContent['max_width'] . '"><div class="swiper-container" style="height:' . $fieldContent['max_height'] . 'px"><div class="swiper-wrapper">';
                            foreach ($fieldContent['nav_list'] as $v) {
                                $fieldHtml['html'] .= '<div style="height:' . $fieldContent['max_height'] . 'px;" class="swiper-slide"><a href="' . ($v['url'] != '' ? $v['url'] : 'javascript:void(0);') . '" style="height:' . $fieldContent['max_height'] . 'px;">' . ($v['title'] != '' ? '<h3 class="title">' . htmlspecialchars_decode($v['title']) . '</h3>' : '') . '<img src="' . getAttachmentUrl($v['image']) . '"></a></div>';
                            }
                            $fieldHtml['html'] .= '</div></div>';
                            if (count($fieldContent['nav_list']) > 1) {
                                $fieldHtml['html'] .= '<div class="swiper-pagination">';
                                $num = 0;
                                foreach ($fieldContent['nav_list'] as $v) {
                                    $fieldHtml['html'] .= '<span class="swiper-pagination-switch' . ($num == 0 ? ' swiper-active-switch' : '') . '"></span>';
                                    $num++;
                                }
                                $fieldHtml['html'] .= '</div>';
                            }
                            $fieldHtml['html'] .= '</div>';
                        } else {
                            $fieldHtml['html'] .= '<ul class="custom-image clearfix">';
                            foreach ($fieldContent['nav_list'] as $v) {
                                $fieldHtml['html'] .= '<li' . ($fieldContent['image_size'] == '1' ? ' class="custom-image-small"' : '') . '><a href="' . ($v['url'] != '' ? $v['url'] : 'javascript:void(0);') . '">' . ($v['title'] != '' ? '<h3 class="title">' . htmlspecialchars_decode($v['title']) . '</h3>' : '') . '<img src="' . getAttachmentUrl($v['image']) . '"/></a></li>';
                            }
                            $fieldHtml['html'] .= '</ul>';
                        }
                    }
                    break;
                case 'goods':
                    $fieldHtml['html'] = '<!-- 商品 -->';
                    if (!empty($fieldContent['goods'])) {
                        if ($fieldContent['size'] == 0) {
                            $fieldHtml['html'].= '<ul class="js-goods-list sc-goods-list pic clearfix size-0">';
                            $i = 1;
                            foreach ($fieldContent['goods'] as $key => $value) {
                                $product = M('Product')->get(array('product_id' => $value['id'], 'status' => 1));
                                if (empty($product)) {
                                    continue;
                                }

                                $fieldHtml['html'].='<li class="goods-card goods-list big-pic ' . ($fieldContent['size_type'] == 2 ? 'normal' : 'card') . '">';
                                $fieldHtml['html'].='<a href="' . $value['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($product['name']) . '">';
                                $fieldHtml['html'].='<div class="photo-block" style="height:auto;">';
                                $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($product['image']) . '" style="display:inline;">';
                                $fieldHtml['html'].='</div>';
                                $fieldHtml['html'].='<div class="info clearfix ' . ($fieldContent['show_title'] == 1 ? 'info-title ' : 'info-no-title ') . ($fieldContent['price'] == 1 ? 'info-price ' : 'info-no-price ') . 'btn' . $fieldContent['buy_btn_type'] . ($fieldContent['show_title'] == 1 || $fieldContent['price'] == 1 ? '' : ' hide') . '">';
                                $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($product['name']) . '</p>';
                                $fieldHtml['html'].='<p class="goods-sub-title c-black hide"></p>';
                                if ($fieldContent['price']) {
                                    $fieldHtml['html'].='<p class="goods-price">';
                                    $fieldHtml['html'].='<em>￥' . $product['price'] . '</em>';
                                    $fieldHtml['html'].='</p>';
                                }
                                $fieldHtml['html'].='<p class="goods-price-taobao hide"></p>';
                                $fieldHtml['html'].='</div>';
                                if ($fieldContent['buy_btn'] && $fieldContent['size_type'] == 0) {
                                    $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                    $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $value['id'] . '"></div>';
                                }
                                $fieldHtml['html'].='</a>';
                                $fieldHtml['html'].='</li>';
                                $i++;
                            }
                            $fieldHtml['html'].='</ul>';
                        } else if ($fieldContent['size'] == 1) {
                            if ($fieldContent['size_type'] != 1) {
                                $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-1">';
                                $i = 1;
                                foreach ($fieldContent['goods'] as $key => $value) {
                                    $product = M('Product')->get(array('product_id' => $value['id'], 'status' => 1));
                                    if (empty($product)) {
                                        continue;
                                    }

                                    $fieldHtml['html'].='<li class="goods-card goods-list small-pic ' . ($fieldContent['size_type'] == 2 ? 'normal' : 'card') . '">';
                                    $fieldHtml['html'].='<a href="' . $value['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($product['name']) . '">';
                                    $fieldHtml['html'].='<div class="photo-block">';
                                    $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($product['image']) . '" style="display:inline;"/>';
                                    $fieldHtml['html'].='</div>';
                                    $fieldHtml['html'].='<div class="info clearfix ' . ($fieldContent['show_title'] == 1 ? 'info-title ' : 'info-no-title ') . ($fieldContent['price'] == 1 ? 'info-price ' : 'info-no-price ') . 'btn' . $fieldContent['buy_btn_type'] . ($fieldContent['show_title'] == 1 || $fieldContent['price'] == 1 ? '' : ' hide') . '">';
                                    $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($product['name']) . '</p>';
                                    $fieldHtml['html'].='<p class="goods-sub-title c-black hide"></p>';
                                    if ($fieldContent['price']) {
                                        $fieldHtml['html'].='<p class="goods-price">';
                                        $fieldHtml['html'].='<em>￥' . $product['price'] . '</em>';
                                        $fieldHtml['html'].='</p>';
                                    }
                                    $fieldHtml['html'].='<p class="goods-price-taobao hide"></p>';
                                    $fieldHtml['html'].='</div>';
                                    if ($fieldContent['buy_btn'] && $fieldContent['size_type'] == 0) {
                                        $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                        $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $value['id'] . '"></div>';
                                    }
                                    $fieldHtml['html'].='</a>';
                                    $fieldHtml['html'].='</li>';
                                    $i++;
                                }
                                $fieldHtml['html'].='</ul>';
                            } else {
                                $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-1 waterfall">';
                                $i = 1;
                                foreach ($fieldContent['goods'] as $key => $value) {
                                    $product = M('Product')->get(array('product_id' => $value['id'], 'status' => 1));
                                    if (empty($product)) {
                                        continue;
                                    }

                                    $fieldHtml['html'].='<li class="goods-card goods-list small-pic waterfall" style="width:155px;">';
                                    $fieldHtml['html'].='<a href="' . $value['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($product['name']) . '">';
                                    $fieldHtml['html'].='<div class="photo-block">';
                                    $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($product['image']) . '" style="display:inline;">';
                                    $fieldHtml['html'].='</div>';
                                    $fieldHtml['html'].='<div class="info clearfix ' . ($fieldContent['show_title'] == 1 ? 'info-title ' : 'info-no-title ') . ($fieldContent['price'] == 1 ? 'info-price ' : 'info-no-price ') . 'btn' . $fieldContent['buy_btn_type'] . ($fieldContent['show_title'] == 1 || $fieldContent['price'] == 1 ? '' : ' hide') . '">';
                                    $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($product['name']) . '</p>';
                                    $fieldHtml['html'].='<p class="goods-sub-title c-black hide"></p>';
                                    if ($fieldContent['price']) {
                                        $fieldHtml['html'].='<p class="goods-price">';
                                        $fieldHtml['html'].='<em>￥' . $product['price'] . '</em>';
                                        $fieldHtml['html'].='</p>';
                                    }
                                    $fieldHtml['html'].='<p class="goods-price-taobao hide"></p>';
                                    $fieldHtml['html'].='</div>';
                                    if ($fieldContent['buy_btn'] && $fieldContent['size_type'] == 0) {
                                        $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                        $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $value['id'] . '"></div>';
                                    }
                                    $fieldHtml['html'].='</a>';
                                    $fieldHtml['html'].='</li>';
                                    $i++;
                                }
                                $fieldHtml['html'].='</ul>';
                            }
                        } else if ($fieldContent['size'] == 2) {
                            $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-2">';
                            $i = 1;
                            foreach ($fieldContent['goods'] as $key => $value) {
                                $product = M('Product')->get(array('product_id' => $value['id'], 'status' => 1));
                                if (empty($product)) {
                                    continue;
                                }
                                $fieldHtml['html'].='<li class="goods-card goods-list ' . ($i % 3 == 1 ? 'big-pic' : 'small-pic') . ($fieldContent['size_type'] == 2 ? ' normal' : ' card') . '">';
                                $fieldHtml['html'].='<a href="' . $value['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($product['name']) . '">';
                                $fieldHtml['html'].='<div class="photo-block">';
                                $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($product['image']) . '" style="display:inline;">';
                                $fieldHtml['html'].='</div>';
                                $fieldHtml['html'].='<div class="info clearfix ' . ($fieldContent['show_title'] == 1 ? 'info-title ' : 'info-no-title ') . ($fieldContent['price'] == 1 ? 'info-price ' : 'info-no-price ') . '' . $fieldContent['buy_btn_type'] . (($fieldContent['show_title'] == 1 || $fieldContent['price'] == 1) ? '' : ' hide') . '">';
                                $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($product['name']) . '</p>';
                                $fieldHtml['html'].='<p class="goods-sub-title c-black hide"></p>';
                                if ($fieldContent['price']) {
                                    $fieldHtml['html'].='<p class="goods-price">';
                                    $fieldHtml['html'].='<em>￥' . $product['price'] . '</em>';
                                    $fieldHtml['html'].='</p>';
                                }
                                $fieldHtml['html'].='<p class="goods-price-taobao hide"></p>';
                                $fieldHtml['html'].='</div>';
                                if ($fieldContent['buy_btn'] && $fieldContent['size_type'] == 0) {
                                    $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                    $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $value['id'] . '"></div>';
                                }
                                $fieldHtml['html'].='</a>';
                                $fieldHtml['html'].='</li>';
                                $i++;
                            }
                            $fieldHtml['html'].='</ul>';
                        } else if ($fieldContent['size'] == 3) {
                            $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list clearfix list size-3">';
                            $i = 1;
                            foreach ($fieldContent['goods'] as $key => $value) {
                                $product = M('Product')->get(array('product_id' => $value['id'], 'status' => 1));
                                if (empty($product)) {
                                    continue;
                                }

                                $fieldHtml['html'].='<li class="goods-card goods-list ' . ($i % 3 == 1 ? 'big-pic' : 'small-pic') . ($fieldContent['size_type'] == 2 ? ' normal' : ' card') . '">';
                                $fieldHtml['html'].='<a href="' . $value['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($product['name']) . '">';
                                $fieldHtml['html'].='<div class="photo-block">';
                                $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($product['image']) . '" style="display:block;">';
                                $fieldHtml['html'].='</div>';
                                $fieldHtml['html'].='<div class="info">';
                                $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($product['name']) . '</p>';
                                if ($fieldContent['price']) {
                                    $fieldHtml['html'].='<p class="goods-price">';
                                    $fieldHtml['html'].='<em>￥' . $product['price'] . '</em>';
                                    $fieldHtml['html'].='</p>';
                                }
                                if ($fieldContent['buy_btn']) {
                                    $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                    $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $value['id'] . '"></div>';
                                }
                                $fieldHtml['html'].='</div>';
                                $fieldHtml['html'].='</a>';
                                $fieldHtml['html'].='</li>';
                                $i++;
                            }
                            $fieldHtml['html'].='</ul>';
                        }
                    }
                    break;
                    
                 //头部   
                case 'tpl_shop':
						$rooturl = option('config.site_url');
                    	$fieldHtml['html'] = '<!-- logo抬头 -->';
                    	$bg1 = "style='";
                    	if(!empty($fieldContent['bgcolor'])){
                    		$bg1 .= "background-color:".$fieldContent['bgcolor']."; ";
                    	}
                    	if(!empty($fieldContent['shop_head_bg_img'])) {
							if(preg_match("/^http/",$fieldContent['shop_head_bg_img'])) {
								$bg1 .= " background-image:url(".$fieldContent['shop_head_bg_img'].");";
							} else {
								//$bg1 .= "style='background-image:url(".$rooturl.'/'.$fieldContent['shop_head_bg_img'].");'";
								$bg1 .= " background-image:url(".$fieldContent['shop_head_bg_img'].");";
							}
                    	} 
						$bg1 .= "'";
						
						
					
						
                    //	./upload/images/head_bg1.png
                    	$imgs="";
                    	if(!empty($fieldContent['shop_head_logo_img'])) {
							if(preg_match("/^http/",$fieldContent['shop_head_logo_img'])) {
                    		$imgs = $fieldContent['shop_head_logo_img'];
							} else {
								//$imgs = $rooturl.'/'.$fieldContent['shop_head_logo_img'];
								$imgs = $fieldContent['shop_head_logo_img'];
							}
                    	}
						
						$count = M('Product')->getTotalByStoreId($store_id);

						$stores = D('Store')->where(array('store_id'=>$store_id))->field("attention_num as atten_num,logo")->find();
						$atten = $stores['atten_num'];
						$imgs = getAttachmentUrl($stores['logo']);					
						$count = ($count>9999) ? '9999+': $count;
						$atten = ($atten>9999) ? '9999+': $atten;

						
                    	$fieldHtml['html'] .= '<div class="custom-title text-left"  style="padding:0px;" ><div class="tpl-shop">';
                    	$fieldHtml['html'] .= '		<div class="tpl-shop-header" '.$bg1.'>';
                    	$fieldHtml['html'] .= '		<div class="tpl-shop-title">'.$fieldContent['title'].'</div>';
                    	$fieldHtml['html'] .= '		<div class="tpl-shop-avatar"><img width="80" height="80" src="'.$imgs.'" alt=""></div></div>';
                    	$fieldHtml['html'] .= '	<div class="tpl-shop-content">';
                    	$fieldHtml['html'] .= '<ul class="clearfix"><li><a href="javascript:;"><span class="count">'.$count.'</span> <span class="text">全部商品</span></a></li><li><a href="javascript:;"><span class="count">'.$atten.'</span> <span class="text">关注我的</span></a></li><li><a href="/wap/order.php?id='.$store_id.'"><span class="count user"></span> <span class="text">我的订单</span></a></li></ul>';
                    	$fieldHtml['html'] .= '</div></div></div><div class="component-border"></div>';
                    	
                    	break;
                    	
                  //头部
                 case 'tpl_shop1':
                    		$fieldHtml['html'] = '<!-- logo抬头 -->';
                    		$bg1 = "style='";
                    		if(!empty($fieldContent['bgcolor'])){
                    			$bg1 .= "background-color:".$fieldContent['bgcolor'].";";
                    		}
                    		if(!empty($fieldContent['shop_head_bg_img'])) {
                    			$bg1 .= "background-image:url(".$fieldContent['shop_head_bg_img'].");";
                    		} else {
                    		
                    		}
							$bg1 .= "'";
                    		$imgs="";
                    		if(!empty($fieldContent['shop_head_logo_img'])) {
                    			$imgs = $fieldContent['shop_head_logo_img'];
                    		} else {

                    		}
							$stores = D('Store')->where(array('store_id'=>$store_id))->field("attention_num as atten_num,logo")->find();
							$atten = $stores['atten_num'];
							$imgs = getAttachmentUrl($stores['logo']);							

							$fieldHtml['html'] .= '<div style="padding:0px;" class="custom-title text-left">';
							$fieldHtml['html'] .= '<div class="tpl-shop1 tpl-wxd">';
							$fieldHtml['html'] .= '<div class="tpl-wxd-header" '.$bg1.'>';
							$fieldHtml['html'] .= '<div class="tpl-wxd-title"></div><div class="tpl-wxd-avatar">';
							$fieldHtml['html'] .= '<img src="'.$imgs.'" alt=""></div> </div></div>';
							$fieldHtml['html'] .= '</div>'; 
							 
                  break;
                    	
                case 'coupons':
                    $fieldHtml['html'] = '<!-- 优惠券 --><div style="clear:both"></div><style type="text/css"> .custom-coupon{padding:10px;text-align:center;font-size:0}.custom-coupon li{display:inline-block;margin-left:6px;width:94px;height:67px;border:1px solid #ff93b2;border-radius:4px;background:#ffeaec}.custom-coupon li a{color:#fa5262}.custom-coupon li:nth-child(1){margin-left:0}.custom-coupon li:nth-child(2){background:#f3ffef;border-color:#98e27f}.custom-coupon li:nth-child(2) a{color:#7acf8d}.custom-coupon li:nth-child(3){background:#ffeae3;border-color:#ffa492}.custom-coupon li:nth-child(3) a{color:#ff9664}.custom-coupon .custom-coupon-price{height:24px;line-height:24px;padding-top:12px;font-size:24px;overflow:hidden}.custom-coupon .custom-coupon-price span{font-size:16px}.custom-coupon .custom-coupon-desc{height:20px;line-height:20px;font-size:12px;padding-top:4px;overflow:hidden}</style>';
                    $fieldHtml['html'] .= '<div class="app-preview"><ul class="custom-coupon clearfix">';
                    foreach ($fieldContent as $v) {
                        foreach ($v as $val) {
                            if (!empty($val['face_money'])) {
                                $fieldHtml['html'] .= '<li>  <a href="/wap/store_coupon.php?id='.$store_id.'"><div class="custom-coupon-price"><span>￥</span>' . $val['face_money'] . '</div><div class="custom-coupon-desc">' . $val['condition'] . '</div>  </a> </li>';
                            }
                        }
                    }
                    $fieldHtml['html'] .= '</ul></div><div style="clear:both"></div>';
                    break;

                case 'goods_group1':
                    $fieldHtml['html'] = '<!-- 商品分组1 --><div style="clear:both"></div>';
                    $fieldHtml['html'] .='<div class="app-field clearfix editing"><div class="control-group"><ul class="goods_group1 clearfix"><div class="custom-tag-list clearfix"><div class="custom-tag-list-menu-block js-collection-region" style="min-height: 323px;"><ul class="custom-tag-list-side-menu"><li>';
                    foreach ($fieldContent['goods_group1'] as $k => $v) {
                        $fieldHtml['html'] .='<a href="javascript:;" class="current"';
                        if ($k == 0) {
                            $fieldHtml['html'].='style="background:#fff"';
                        }
                        $fieldHtml['html'].='>' . $v["title"] . '</a>';
                    }

                    $fieldHtml['html'] .= '</li></ul></div>';
                    foreach ($fieldContent['goods_group1'] as $k => $v) {
                        $fieldHtml['html'] .= '<div class = "custom-tag-list-goods"';
                        if ($k != 0) {
                            $fieldHtml['html'] .= ' style = "display:none"';
                        }
                        $fieldHtml['html'] .= '><ul class = "custom-tag-list-goods-list">';


                        $product_list = M('Product_to_group')->getProducts($v['id']);
                        $product_arr = array();
                        foreach ($product_list as $v) {
                            array_push($product_arr, $v['product_id']);
                        }
                        
                        $product_list = M('Product')->getSelling(array('product_id' => array('in', $product_arr)), '', '', 0, 10);
                        //$where['group_id'] = $v['id'];
                        //$product_list = M('Product')->getSelling($where, '', '', 0, $v['show_num'] ? $v['show_num'] : 10);
                        if ($product_list) {
                            foreach ($product_list as $key => $val) {
                                $fieldHtml['html'] .= '<li class = "custom-tag-list-single-goods clearfix"><div class = "custom-tag-list-goods-img"><img src = "' . $val['image'] . '" style = "display: inline;"></div><div class = "custom-tag-list-goods-detail"><p class = "custom-tag-list-goods-title">' . $val['name'] . '</p><span class = "custom-tag-list-goods-price">￥'.$val['price'].'</span><a class = "custom-tag-list-goods-buy" href = "javascript:void(0)" onclick="speed_shop(' . $val["product_id"] . ')"><span></span></a></div></li>';
                            }
                        } else {
                            $fieldHtml['html'].='<ul class="custom-tag-list-goods-list"><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="upload/images/kd2.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="upload/images/kd1.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="upload/images/kd3.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li><li class="custom-tag-list-single-goods clearfix"><div class="custom-tag-list-goods-img"><img src="upload/images/kd4.jpg" style="display: inline;"></div><div class="custom-tag-list-goods-detail"><p class="custom-tag-list-goods-title">此处显示商品名称</p><span class="custom-tag-list-goods-price">￥100.00</span><a class="custom-tag-list-goods-buy" href="javascript:void(0)"><span></span></a></div></li></ul>';
                        }
                        $fieldHtml['html'] .= '</ul></div>';
                    }
                    $fieldHtml['html'].='<div style="clear:both"></div>';
                    break;

                case 'goods_group2':
                    $fieldHtml['html'] = '<!-- 商品分组2 --><style> a.active {color: #ed5050;border-bottom: 1px solid #ed5050;}</style><div style="clear:both"></div>';
                    if (!empty($fieldContent['goods'])) {
                        $fieldHtml['html'].='<div style="clear:both"></div><div class="js-tabber-tags tabber tabber-bottom red clearfix tabber-n4 ">';
                        foreach ($fieldContent['goods'] as $k => $v) {
                            if ($k == 0) {
                                $fieldHtml['html'].='<a data-type="tag-1"href="javascript:;"class="active">' . $v['title'] . '</a>';
                            } else {
                                $fieldHtml['html'].='<a data-type="tag-1"href="javascript:;">' . $v['title'] . '</a>';
                            }
                        }
                        $fieldHtml['html'].='</div>';
                        if ($fieldContent['size'] == 0) {
                            $i = 1;
                            foreach ($fieldContent['goods'] as $key => $value) {
                                if ($key == 0) {
                                    $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-0">';
                                } else {
                                    $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-0" style="display:none">';
                                }

                                $product_list = M('Product_to_group')->getProducts($value['id']);
                                $product_arr = array();
                                foreach ($product_list as $v) {
                                    array_push($product_arr, $v['product_id']);
                                }

                                $product_list = M('Product')->getSelling(array('product_id' => array('in', $product_arr)), '', '', 0, 10);


                                //$product_list = M('Product')->getSelling(array('group_id' => $value['id']), '', '', 0, 10);
                                if (empty($product_list)) {
                                    $fieldHtml['html'].='<center>暂时没有商品</cemter>';
                                } else {
                                    foreach ($product_list as $k => $v) {
                                        $fieldHtml['html'].='<li class="goods-card goods-list big-pic ' . ($fieldContent['size_type'] == 2 ? 'normal' : 'card') . '">';
                                        $fieldHtml['html'].='<a href="' . $value['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($v['name']) . '">';
                                        $fieldHtml['html'].='<div class="photo-block" style="height:auto;">';
                                        $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($v['image']) . '" style="display:inline;">';
                                        $fieldHtml['html'].='</div>';
                                        $fieldHtml['html'].='<div class="info clearfix ' . ($fieldContent['show_title'] == 1 ? 'info-title ' : 'info-no-title ') . ($fieldContent['price'] == 1 ? 'info-price ' : 'info-no-price ') . 'btn' . $fieldContent['buy_btn_type'] . ($fieldContent['show_title'] == 1 || $fieldContent['price'] == 1 ? '' : ' hide') . '">';
                                        $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($v['name']) . '</p>';
                                        $fieldHtml['html'].='<p class="goods-sub-title c-black hide"></p>';
                                        if ($fieldContent['price']) {
                                            $fieldHtml['html'].='<p class="goods-price">';
                                            $fieldHtml['html'].='<em>￥' . $v['price'] . '</em>';
                                            $fieldHtml['html'].='</p>';
                                        }
                                        $fieldHtml['html'].='<p class="goods-price-taobao hide"></p>';
                                        $fieldHtml['html'].='</div>';
                                        if ($fieldContent['buy_btn'] && $fieldContent['size_type'] == 0) {
                                            $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                            $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $value['id'] . '"></div>';
                                        }
                                        $fieldHtml['html'].='</a>';
                                        $fieldHtml['html'].='</li>';
                                        $i++;
                                    }
                                }
                                $fieldHtml['html'].='</ul>';
                            }
                        } else if ($fieldContent['size'] == 1) {
                            if ($fieldContent['size_type'] != 1) {
                                $i = 1;
                                foreach ($fieldContent['goods'] as $key => $value) {
                                    if ($key == 0) {
                                        $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-1">';
                                    } else {
                                        $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-1" style="display:none">';
                                    }
                                    $product_list = M('Product_to_group')->getProducts($value['id']);
                                    $product_arr = array();
                                    foreach ($product_list as $v) {
                                        array_push($product_arr, $v['product_id']);
                                    }

                                    $product_list = M('Product')->getSelling(array('product_id' => array('in', $product_arr)), '', '', 0, 10);

                                    if (empty($product_list)) {
                                        $fieldHtml['html'].='<center>暂时没有商品</cemter>';
                                    } else {
                                        foreach ($product_list as $k => $v) {
                                            $fieldHtml['html'].='<li class="goods-card goods-list small-pic ' . ($fieldContent['size_type'] == 2 ? 'normal' : 'card') . '">';
                                            $fieldHtml['html'].='<a href="' . $v['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($v['name']) . '">';
                                            $fieldHtml['html'].='<div class="photo-block">';
                                            $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($v['image']) . '" style="display:inline;"/>';
                                            $fieldHtml['html'].='</div>';
                                            $fieldHtml['html'].='<div class="info clearfix ' . ($fieldContent['show_title'] == 1 ? 'info-title ' : 'info-no-title ') . ($fieldContent['price'] == 1 ? 'info-price ' : 'info-no-price ') . 'btn' . $fieldContent['buy_btn_type'] . ($fieldContent['show_title'] == 1 || $fieldContent['price'] == 1 ? '' : ' hide') . '">';
                                            $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($v['name']) . '</p>';
                                            $fieldHtml['html'].='<p class="goods-sub-title c-black hide"></p>';
                                            if ($fieldContent['price']) {
                                                $fieldHtml['html'].='<p class="goods-price">';
                                                $fieldHtml['html'].='<em>￥' . $v['price'] . '</em>';
                                                $fieldHtml['html'].='</p>';
                                            }
                                            $fieldHtml['html'].='<p class="goods-price-taobao hide"></p>';
                                            $fieldHtml['html'].='</div>';
                                            if ($fieldContent['buy_btn'] && $fieldContent['size_type'] == 0) {
                                                $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                                $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $v['id'] . '"></div>';
                                            }
                                            $fieldHtml['html'].='</a>';
                                            $fieldHtml['html'].='</li>';
                                            $i++;
                                        }
                                    }$fieldHtml['html'].='</ul>';
                                }
                            } else {
                                $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-1 waterfall">';
                                $i = 1;
                                foreach ($fieldContent['goods'] as $key => $value) {
                                    foreach ($fieldContent['goods'] as $key => $value) {
                                        $product = M('Product')->get(array('product_id' => $value['id'], 'status' => 1));
                                        if (empty($product)) {
                                            continue;
                                        }
                                        if (empty($product)) {
                                            continue;
                                        }

                                        $fieldHtml['html'].='<li class="goods-card goods-list small-pic waterfall" style="width:155px;">';
                                        $fieldHtml['html'].='<a href="' . $value['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($product['name']) . '">';
                                        $fieldHtml['html'].='<div class="photo-block">';
                                        $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($product['image']) . '" style="display:inline;">';
                                        $fieldHtml['html'].='</div>';
                                        $fieldHtml['html'].='<div class="info clearfix ' . ($fieldContent['show_title'] == 1 ? 'info-title ' : 'info-no-title ') . ($fieldContent['price'] == 1 ? 'info-price ' : 'info-no-price ') . 'btn' . $fieldContent['buy_btn_type'] . ($fieldContent['show_title'] == 1 || $fieldContent['price'] == 1 ? '' : ' hide') . '">';
                                        $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($product['name']) . '</p>';
                                        $fieldHtml['html'].='<p class="goods-sub-title c-black hide"></p>';
                                        if ($fieldContent['price']) {
                                            $fieldHtml['html'].='<p class="goods-price">';
                                            $fieldHtml['html'].='<em>￥' . $product['price'] . '</em>';
                                            $fieldHtml['html'].='</p>';
                                        }
                                        $fieldHtml['html'].='<p class="goods-price-taobao hide"></p>';
                                        $fieldHtml['html'].='</div>';
                                        if ($fieldContent['buy_btn'] && $fieldContent['size_type'] == 0) {
                                            $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                            $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $value['id'] . '"></div>';
                                        }
                                        $fieldHtml['html'].='</a>';
                                        $fieldHtml['html'].='</li>';
                                        $i++;
                                    }
                                    $fieldHtml['html'].='</ul>';
                                }
                            }
                        } else if ($fieldContent['size'] == 2) {
                            $i = 1;
                            foreach ($fieldContent['goods'] as $key => $value) {
                                if ($key == 0) {
                                    $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-2">';
                                } else {
                                    $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list pic clearfix size-2" style="display:none">';
                                }

                                $product_list = M('Product_to_group')->getProducts($value['id']);
                                $product_arr = array();
                                foreach ($product_list as $v) {
                                    array_push($product_arr, $v['product_id']);
                                }

                                $product_list = M('Product')->getSelling(array('product_id' => array('in', $product_arr)), '', '', 0, 10);
                                if (empty($product_list)) {
                                    $fieldHtml['html'].='<center>暂时没有商品</cemter>';
                                } else {
                                    foreach ($product_list as $k => $v) {
                                        $fieldHtml['html'].='<li class="goods-card goods-list ' . ($i % 3 == 1 ? 'big-pic' : 'small-pic') . ($fieldContent['size_type'] == 2 ? ' normal' : ' card') . '">';
                                        $fieldHtml['html'].='<a href="' . $value['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($v['name']) . '">';
                                        $fieldHtml['html'].='<div class="photo-block">';
                                        $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($v['image']) . '" style="display:inline;">';
                                        $fieldHtml['html'].='</div>';
                                        $fieldHtml['html'].='<div class="info clearfix ' . ($fieldContent['show_title'] == 1 ? 'info-title ' : 'info-no-title ') . ($fieldContent['price'] == 1 ? 'info-price ' : 'info-no-price ') . '' . $fieldContent['buy_btn_type'] . (($fieldContent['show_title'] == 1 || $fieldContent['price'] == 1) ? '' : ' hide') . '">';
                                        $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($v['name']) . '</p>';
                                        $fieldHtml['html'].='<p class="goods-sub-title c-black hide"></p>';
                                        if ($fieldContent['price']) {
                                            $fieldHtml['html'].='<p class="goods-price">';
                                            $fieldHtml['html'].='<em>￥' . $v['price'] . '</em>';
                                            $fieldHtml['html'].='</p>';
                                        }
                                        $fieldHtml['html'].='<p class="goods-price-taobao hide"></p>';
                                        $fieldHtml['html'].='</div>';
                                        if ($fieldContent['buy_btn'] && $fieldContent['size_type'] == 0) {
                                            $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                            $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $value['id'] . '"></div>';
                                        }
                                        $fieldHtml['html'].='</a>';
                                        $fieldHtml['html'].='</li>';
                                        $i++;
                                    }
                                }
                                $fieldHtml['html'].='</ul>';
                            }
                        } else if ($fieldContent['size'] == 3) {
                            $i = 1;
                            foreach ($fieldContent['goods'] as $key => $value) {
                                if ($key == 0) {
                                    $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list clearfix list size-3">';
                                } else {
                                    $fieldHtml['html'].='<ul class="js-goods-list sc-goods-list clearfix list size-3" style="display:none">';
                                }

                                $product_list = M('Product_to_group')->getProducts($value['id']);
                                $product_arr = array();
                                foreach ($product_list as $v) {
                                    array_push($product_arr, $v['product_id']);
                                }

                                $product_list = M('Product')->getSelling(array('product_id' => array('in', $product_arr)), '', '', 0, 10);
                                //$product_list = M('Product')->getSelling(array('group_id' => $value['id']), '', '', 0, 10);
                                if (empty($product_list)) {
                                    $fieldHtml['html'].='<center>暂时没有商品</cemter>';
                                } else {
                                    foreach ($product_list as $k => $v) {
                                        $fieldHtml['html'].='<li class="goods-card goods-list ' . ($i % 3 == 1 ? 'big-pic' : 'small-pic') . ($fieldContent['size_type'] == 2 ? ' normal' : ' card') . '">';
                                        $fieldHtml['html'].='<a href="' . $v['url'] . '" class="js-goods link clearfix" target="_blank" title="' . htmlspecialchars_decode($v['name']) . '">';
                                        $fieldHtml['html'].='<div class="photo-block">';
                                        $fieldHtml['html'].='<img class="goods-photo js-goods-lazy" src="' . getAttachmentUrl($v['image']) . '" style="display:block;">';
                                        $fieldHtml['html'].='</div>';
                                        $fieldHtml['html'].='<div class="info">';
                                        $fieldHtml['html'].='<p class="goods-title">' . htmlspecialchars_decode($product_list['name']) . '</p>';
                                        if ($fieldContent['price']) {
                                            $fieldHtml['html'].='<p class="goods-price">';
                                            $fieldHtml['html'].='<em>￥' . $v['price'] . '</em>';
                                            $fieldHtml['html'].='</p>';
                                        }
                                        if ($fieldContent['buy_btn']) {
                                            $fieldHtml['html'].='<div class="goods-buy btn' . $fieldContent['buy_btn_type'] . ' info-no-title"></div>';
                                            $fieldHtml['html'].='<div class="js-goods-buy buy-response" data-id="' . $v['id'] . '"></div>';
                                        }
                                        $fieldHtml['html'].='</div>';
                                        $fieldHtml['html'].='</a>';
                                        $fieldHtml['html'].='</li>';
                                        $i++;
                                    }
                                    $fieldHtml['html'].='</ul>';
                                }
                            }
                        }
                    }
                    break;
            }
            $fieldHtmlArr[] = $fieldHtml;
        }
        return $fieldHtmlArr;
    }

}

