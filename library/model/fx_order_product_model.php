<?php
/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/4/9
 * Time: 16:02
 */

class fx_order_product_model extends base_model
{
    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    public function getProducts($order_id)
    {
        $products = $this->db->query("SELECT p.product_id,p.original_product_id,p.store_id,p.name,p.cost_price,p.image,fop.quantity,fop.price,fop.sku_data,fop.comment,((fop.price - fop.cost_price) * fop.quantity) AS profit FROM " . option('system.DB_PREFIX') . "fx_order_product fop, " . option('system.DB_PREFIX') . "product p WHERE fop.product_id = p.product_id AND fop.fx_order_id = '" . $order_id . "'");
        foreach ($products as &$tmp) {
            $tmp['image'] = getAttachmentUrl($tmp['image']);
        }
        return $products;
    }

    public function getFxProducts($order_id)
    {
        $products = $this->db->query("SELECT p.product_id,p.name,fop.cost_price,p.image,fop.quantity,fop.price,fop.sku_id,fop.sku_data,fop.comment FROM " . option('system.DB_PREFIX') . "fx_order_product fop, " . option('system.DB_PREFIX') . "product p WHERE fop.product_id = p.product_id AND fop.fx_order_id = '" . $order_id . "'");
        foreach ($products as &$tmp) {
            $tmp['image'] = getAttachmentUrl($tmp['image']);
        }
        return $products;
    }
} 