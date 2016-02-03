<?php
/**
 * 公用数据
 * User: pigcms_21
 * Date: 2015/7/4
 * Time: 15:24
 */

class common_data_model extends base_model
{
    //设置店铺数
    public function setStoreQty($qty = 1)
    {
        if ($qty > 0) {
            return $this->db->where(array('key' => 'store_qty'))->setInc('value', $qty);
        } else {
            return $this->db->where(array('key' => 'store_qty'))->setDec('value', $qty);
        }
    }

    //获取店铺数
    public function getStoreQty()
    {
        $data = $this->db->where(array('key' => 'store_qty'))->find();
        return !empty($data['value']) && $data['value'] > 0 ? $data['value'] : 0;
    }

    //设置分销商数
    public function setDrpSellerQty($qty = 1)
    {
        if ($qty > 0) {
            return $this->db->where(array('key' => 'drp_seller_qty'))->setInc('value', $qty);
        } else {
            return $this->db->where(array('key' => 'drp_seller_qty'))->setDec('value', abs($qty));
        }
    }

    //获取分销商数
    public function getDrpSellerQty()
    {
        $data = $this->db->where(array('key' => 'drp_seller_qty'))->find();
        return !empty($data['value']) && $data['value'] > 0 ? $data['value'] : 0;
    }

    //设置商品数
    public function setProductQty($qty = 1)
    {
        if ($qty > 0) {
            return $this->db->where(array('key' => 'product_qty'))->setInc('value', $qty);
        } else {
            return $this->db->where(array('key' => 'product_qty'))->setDec('value', abs($qty));
        }
    }

    //获取商品数
    public function getProductQty()
    {
        $data = $this->db->where(array('key' => 'product_qty'))->find();
        return !empty($data['value']) && $data['value'] > 0 ? $data['value'] : 0;
    }
} 