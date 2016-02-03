<?php
/**
 * 订单包裹
 * User: pigcms_21
 * Date: 2015/3/13
 * Time: 18:09
 */

class order_package_model extends base_model
{
    public function getPackages($where)
    {
        $packages = $this->db->where($where)->order('package_id DESC')->select();
        return $packages;
    }

    //添加包裹
    public function add($data)
    {
        return $this->db->data($data)->add();
    }
} 