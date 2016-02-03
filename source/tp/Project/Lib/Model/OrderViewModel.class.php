<?php
/**
 * 订单数据视图
 * User: pigcms_21
 * Date: 2014/12/29
 * Time: 13:11
 */

class OrderViewModel extends ViewModel
{
    public $viewFields = array(
        'Order' => array('*', '_as' => 'StoreOrder', '_type' => 'LEFT'),
        'Store' => array('name' => 'store', 'linkman' , '_on' => 'StoreOrder.store_id = Store.store_id'),
    	
    );

    //订单状态
    public function status()
    {
        return array(
            0 => '临时订单',
            1 => '等待买家付款',
            2 => '等待卖家发货',
            3 => '卖家已发货',
            4 => '已完成',
            5 => '订单关闭',
            6 => '退款中'
        );
    }

    //支付方式
    public function getPaymentMethod()
    {
        return array(
            'alipay'    => '支付宝',
            'tenpay'    => '财付通',
            'yeepay'    => '易宝支付',
            'allinpay'  => '通联支付',
            'chinabank' => '网银在线',
            'weixin'    => '微信支付',
            'offline'   => '货到付款',
            'balance'   => '余额支付'
        );
    }
}