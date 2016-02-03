<?php
/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/3/4
 * Time: 18:18
 */

class product_to_group_model extends base_model
{
    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    public function delete($product_id)
    {
        $flag = false;
        if ($this->db->where(array('product_id' => $product_id))->delete()) {
            D('Product')->where(array('product_id' => $product_id))->data(array('has_category' => 0))->save();
            $groups = $this->getGroups($product_id);
            foreach ($groups as $group_id) {
                D('Product_group')->where(array('group_id' => $group_id))->setDec('product_count', 1);
            }
            $flag = true;
        }
        return $flag;
    }

    //商品分组
    public function getGroups($product_id)
    {
        $groups = $this->db->where(array('product_id' => $product_id))->select();
        return $groups;
    }

    //分组商品
    public function getProducts($group_id)
    {
        $products = $this->db->where(array('group_id' => $group_id))->select();
        return $products;
    }
}