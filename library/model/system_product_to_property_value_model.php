<?php

/**
 * 商品栏目属性值关联数据模型
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/6/15
 * Time: 11:26
 */
class system_product_to_property_value_model extends base_model {

    public function add($data) {
        $result = $this->db->data($data)->add();

        return $result;
    }

    public function edit($where, $data) {

        return $this->db->where($where)->data($data)->save();
    }

    public function delete($where) {
        if (!$where) {
            return false;
        }
        return $this->db->where($where)->delete();
    }

    /**
     * @param $store_id
     * @param $product_id
     * @param $pid
     */
    public function getVids($store_id, $product_id, $pid, $fields = 'vid') {
        $vids = $this->db->field($fields)->where(array('pid' => $pid, 'product_id' => $product_id))->order('order_by ASC')->select();
        return $vids;
    }

    public function getPropertyValues($store_id, $product_id) {
        return $this->db->where(array('product_id' => $product_id))->select();
    }

    /**
     * 根据条件返回列表
     * 以后有更多的查询条件可以在此扩展
     */
    public function getList($where) {
        $property_value_list = $this->db->where($where)->select();
        return $property_value_list;
    }

    /**
     * 根据属性ID，搜索出此产品
     */
    public function getProductIDByVid($vid_arr) {
        if (empty($vid_arr)) {
            return '0';
        }

        // debug vid
        $vid = array();
        foreach ($vid_arr as $tmp) {
            $tmp = $tmp + 0;
            $vid[$tmp] = $tmp;
        }

        if (empty($vid)) {
            return '0';
        }

        $prefix = option('system.DB_PREFIX');
        $vid_str = join(',', $vid);

        $md5 = md5($vid_str);
        $expire_time = time() + 60 * 60;
        $search_tmp = D('Search_tmp')->where(array('md5' => $md5))->find();
        if (!empty($search_tmp) && $search_tmp['expire_time'] > time()) {
            return $search_tmp['product_id_str'];
        }

        //$sql = "select product_id from " . $prefix . "product_to_property_value where vid in (" . $vid_str . ") group by product_id  having count(product_id) = " . count($vid) . ' limit 2000';
        $sql = "SELECT `product_id` FROM (SELECT `product_id`, count(product_id) as count FROM `" . $prefix . "system_product_to_property_value` WHERE `vid` IN (" . $vid_str . ") GROUP BY `product_id` ORDER BY `id` DESC) as t WHERE t.count = " . count($vid) . " LIMIT 2000";
        $data = $this->db->query($sql);

        if (empty($data)) {
            return 0;
        } else {
            $product_id_str = '';
            foreach ($data as $tmp) {
                $product_id_str .= ',' . $tmp['product_id'];
            }

            $product_id_str = trim($product_id_str, ',');
            $sql = "replace into " . $prefix . "search_tmp (`md5`, `product_id_str`, `expire_time`) values ('" . $md5 . "', '" . $product_id_str . "', '" . $expire_time . "')";
            $this->db->execute($sql);

            return $product_id_str;
        }
    }

}