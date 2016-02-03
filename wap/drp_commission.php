<?php
/**
 * 分销佣金
 * User: pigcms_21
 * Date: 2015/4/23
 * Time: 11:42
 */

require_once dirname(__FILE__).'/drp_check.php';

if (empty($_SESSION['wap_drp_store'])) {
    pigcms_tips('您没有权限访问，<a href="./home.php?id=' . $_COOKIE['wap_store_id'] . '">返回首页</a>','none');
}

//分享配置 start  
$share_conf     = array(
    'title'     => $_SESSION['wap_drp_store']['name'].'-分销管理', // 分享标题
    'desc'      => str_replace(array("\r","\n"), array('',''), $_SESSION['wap_drp_store']['intro']), // 分享描述
    'link'      => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], // 分享链接
    'imgUrl'    => $_SESSION['wap_drp_store']['logo'], // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);
import('WechatShare');
$share      = new WechatShare();
$shareData  = $share->getSgin($share_conf);
//分享配置 end

if (IS_GET && $_GET['a'] == 'index') { //分销佣金
    $store_model = M('Store');
    $financial_record = M('Financial_record');

    $store = $_SESSION['wap_drp_store'];
    $store_info = $store_model->getStore($store['store_id']);

    $income = !empty($store_info['drp_profit']) ? $store_info['drp_profit'] : 0;
    //可提现余额
    //$balance = $financial_record->drpProfit(array('store_id' => $store['store_id']));
    //已提现金额
    //$withdrawal_amount = $store_model->getWithdrawalAmount($store['store_id']);
    $withdrawal_amount = !empty($store_info['drp_profit_withdrawal']) ? $store_info['drp_profit_withdrawal'] : 0;
    $balance = $income - $withdrawal_amount;
    $balance = number_format($balance, 2, '.', '');
    $withdrawal_amount = number_format($withdrawal_amount, 2, '.', '');
    //店铺url
    $store_url = option('config.wap_site_url') . '/home.php?id=' . $store['store_id'];

    include display('drp_commission_index');
    echo ob_get_clean();
} else if ($_GET['a'] == 'statistics') {
    $store_model = M('Store');
    $financial_record = M('Financial_record');

    $store = $_SESSION['wap_drp_store'];
    $store_info = $store_model->getStore($store['store_id']);

    if (IS_POST) {
        $type = trim($_GET['type']);
        if (strtolower($type) == 'today') { //今日佣金
            //今日佣金 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
            //00:00-6:00
            $starttime = strtotime(date('Y-m-d') . ' 00:00:00');
            $stoptime = strtotime(date('Y-m-d') . ' 06:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $todaycommissiontotal_0_6 = $financial_record->drpProfit($where);
            if (!$todaycommissiontotal_0_6) {
                $todaycommissiontotal_0_6 = 0;
            }
            //6:00-12:00
            $starttime = strtotime(date('Y-m-d') . ' 06:00:00');
            $stoptime = strtotime(date('Y-m-d') . ' 12:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $todaycommissiontotal_6_12 = $financial_record->drpProfit($where);
            if (!$todaycommissiontotal_6_12) {
                $todaycommissiontotal_6_12 = 0;
            }
            //12:00-18:00
            $starttime = strtotime(date('Y-m-d') . ' 12:00:00');
            $stoptime = strtotime(date('Y-m-d') . ' 18:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $todaycommissiontotal_12_18 = $financial_record->drpProfit($where);
            if (!$todaycommissiontotal_12_18) {
                $todaycommissiontotal_12_18 = 0;
            }
            //18:00-24:00
            $starttime = strtotime(date('Y-m-d') . ' 18:00:00');
            $stoptime = strtotime(date('Y-m-d') . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $todaycommissiontotal_18_24 = $financial_record->drpProfit($where);
            if (!$todaycommissiontotal_18_24) {
                $todaycommissiontotal_18_24 = 0;
            }
            $todaycommissiontotal = "[" . number_format($todaycommissiontotal_0_6, 2, '.', '') . ',' . number_format($todaycommissiontotal_6_12, 2, '.', '') . ',' . number_format($todaycommissiontotal_12_18, 2, '.', '') . ',' . number_format($todaycommissiontotal_18_24, 2, '.', '') ."]";
            echo $todaycommissiontotal;
            exit;
        } else if (strtolower($type) == 'yesterday') { //昨日佣金
            //昨日佣金 00:00-6:00 6:00-12:00 12:00-18:00 18:00-24:00
            $date = date('Y-m-d' , strtotime('-1 day'));
            //00:00-6:00
            $starttime = strtotime($date . ' 00:00:00');
            $stoptime = strtotime($date . ' 06:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $yesterdaycommissiontotal_0_6 = $financial_record->drpProfit($where);
            if (!$yesterdaycommissiontotal_0_6) {
                $yesterdaycommissiontotal_0_6 = 0;
            }
            //6:00-12:00
            $starttime = strtotime($date . ' 06:00:00');
            $stoptime = strtotime($date . ' 12:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $yesterdaycommissiontotal_6_12 = $financial_record->drpProfit($where);
            if (!$yesterdaycommissiontotal_6_12) {
                $yesterdaycommissiontotal_6_12 = 0;
            }
            //12:00-18:00
            $starttime = strtotime($date . ' 12:00:00');
            $stoptime = strtotime($date . ' 18:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $yesterdaycommissiontotal_12_18 = $financial_record->drpProfit($where);
            if (!$yesterdaycommissiontotal_12_18) {
                $yesterdaycommissiontotal_12_18 = 0;
            }
            //18:00-24:00
            $starttime = strtotime($date . ' 18:00:00');
            $stoptime = strtotime($date . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $yesterdaycommissiontotal_18_24 = $financial_record->drpProfit($where);
            if (!$yesterdaycommissiontotal_18_24) {
                $yesterdaycommissiontotal_18_24 = 0;
            }
            $yesterdaycommissiontotal = "[" . number_format($yesterdaycommissiontotal_0_6, 2, '.', '') . ',' . number_format($yesterdaycommissiontotal_6_12, 2, '.', '') . ',' . number_format($yesterdaycommissiontotal_12_18, 2, '.', '') . ',' . number_format($yesterdaycommissiontotal_18_24, 2, '.', '') ."]";
            echo $yesterdaycommissiontotal;
            exit;
        } else if (strtolower($type) == 'week') {
            $date = date('Y-m-d');  //当前日期
            $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
            $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
            $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
            $now_end = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期

            //周一佣金
            $starttime = strtotime($now_start . ' 00:00:00');
            $stoptime = strtotime($now_start . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_1 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_1) {
                $weekcommissiontotal_1 = 0;
            }
            //周二佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 00:00:00');
            $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+1 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_2 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_2) {
                $weekcommissiontotal_2 = 0;
            }
            //周三佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 00:00:00');
            $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+2 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_3 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_3) {
                $weekcommissiontotal_3 = 0;
            }
            //周四佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 00:00:00');
            $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+3 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_4 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_4) {
                $weekcommissiontotal_4 = 0;
            }
            //周五佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 00:00:00');
            $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+4 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_5 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_5) {
                $weekcommissiontotal_5 = 0;
            }
            //周六佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 00:00:00');
            $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+5 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_6 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_6) {
                $weekcommissiontotal_6 = 0;
            }
            //周日佣金
            $starttime = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 00:00:00');
            $stoptime = strtotime(date("Y-m-d",strtotime($now_start . "+6 day")) . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $weekcommissiontotal_7 = $financial_record->drpProfit($where);
            if (!$weekcommissiontotal_7) {
                $weekcommissiontotal_7 = 0;
            }
            $weekcommissiontotal = "[" . number_format($weekcommissiontotal_1, 2, '.', '') . ',' . number_format($weekcommissiontotal_2, 2, '.', '') . ',' . number_format($weekcommissiontotal_3, 2, '.', '') . ',' . number_format($weekcommissiontotal_4, 2, '.', '') . ',' . number_format($weekcommissiontotal_5, 2, '.', '') . ',' . number_format($weekcommissiontotal_6, 2, '.', '') . ',' . number_format($weekcommissiontotal_7, 2, '.', '') ."]";
            echo $weekcommissiontotal;
            exit;
        } else if (strtolower($type) == 'month') { //当月佣金
            $month = date('m');
            $year = date('Y');
            //1-7日
            $starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
            $stoptime = strtotime($year . '-' . $month . '-07' . ' 00:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $monthcommissiontotal_1_7 = $financial_record->drpProfit($where);
            if (!$monthcommissiontotal_1_7) {
                $monthcommissiontotal_1_7 = 0;
            }
            //7-14日
            $starttime = strtotime($year . '-' . $month . '-07' . ' 00:00:00');
            $stoptime = strtotime($year . '-' . $month . '-14' . ' 00:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $monthcommissiontotal_7_14 = $financial_record->drpProfit($where);
            if (!$monthcommissiontotal_7_14) {
                $monthcommissiontotal_7_14 = 0;
            }
            //14-21日
            $starttime = strtotime(($year . '-' . $month . '-14') . ' 00:00:00');
            $stoptime = strtotime(($year . '-' . $month . '-21') . ' 00:00:00');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time < " . $stoptime;
            $monthcommissiontotal_14_21 = $financial_record->drpProfit($where);
            if (!$monthcommissiontotal_14_21) {
                $monthcommissiontotal_14_21 = 0;
            }
            //21-本月结束
            //当月最后一天
            $lastday = date('t',time());
            $starttime = strtotime($year . '-' . $month . '-21' . ' 00:00:00');
            $stoptime = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
            $where = array();
            $where['store_id'] = $store['store_id'];
            $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
            $monthcommissiontotal_21_end = $financial_record->drpProfit($where);
            if (!$monthcommissiontotal_21_end) {
                $monthcommissiontotal_21_end = 0;
            }
            $data = array();
            $monthcommissiontotal = "[" . number_format($monthcommissiontotal_1_7, 2, '.', '') . ',' . number_format($monthcommissiontotal_7_14, 2, '.', '') . ',' . number_format($monthcommissiontotal_14_21, 2, '.', '') . ',' . number_format($monthcommissiontotal_21_end, 2, '.', '') ."]";
            $data['monthcommissiontotal'] = $monthcommissiontotal;
            $data['lastday'] = $lastday;
            echo json_encode(array('data' => $data));
            exit;
        }
    }

    //店铺余额
    //$balance = $financial_record->drpProfit(array('store_id' => $store['store_id']));
    $income = !empty($store_info['drp_profit']) ? $store_info['drp_profit'] : 0;
    $withdrawal_amount = !empty($store_info['drp_profit_withdrawal']) ? $store_info['drp_profit_withdrawal'] : 0;
    $balance = $income - $withdrawal_amount;
    $store['balance'] = number_format($balance, 2, '.', '');
    $store['income'] = number_format($income, 2, '.', '');

    include display('drp_commission_statistics');
    echo ob_get_clean();
} else if (IS_GET && $_GET['a'] == 'withdrawal') { //提现申请页面
    $store_model = M('Store');
    $bank = M('Bank');
    $financial_record = M('Financial_record');

    $store = $store_model->getStore($_SESSION['wap_drp_store']['store_id']);
    //可提现金额
    /*$balance = $store_model->getBalance($store['store_id']);
    $balance = number_format($balance, 2, '.', '');*/
    $income = !empty($store['drp_profit']) ? $store['drp_profit'] : 0;
    //可提现余额
    //$balance = $financial_record->drpProfit(array('store_id' => $store['store_id'], 'status' => 3));
    $withdrawal = !empty($store['drp_profit_withdrawal']) ? $store['drp_profit_withdrawal'] : 0; //已提现
    $balance = number_format($income - $withdrawal, 2, '.', '');
    //佣金总额
    /*$income = $store_model->getIncome($store['store_id']);
    $income = number_format($income, 2, '.', '');*/
    //$income = $financial_record->drpProfit(array('store_id' => $store['store_id']));
    $income = number_format($income, 2, '.', '');
    //开户行
    $bank_name = '';
    if (!empty($store['bank_id'])) {
        $bank = $bank->getBank($store['bank_id']);
        $bank_name = $bank['name'];
    }
    //提现最低金额
    $withdrawal_min_amount = option('config.withdrawal_min_amount');

    include display('drp_commission_withdrawal');
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'withdrawal') { //提现申请提交
    $store = M('Store');
    $store_withdrawal = M('Store_withdrawal');
    $store_info = $store->getStore($_SESSION['wap_drp_store']['store_id']);
    $data = array();
    $data['trade_no']        = date('YmdHis',$_SERVER['REQUEST_TIME']).mt_rand(100000,999999);
    $data['uid']             = $store_info['uid'];
    $data['store_id']        = $store_info['store_id'];
    $data['bank_id']         = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
    $data['opening_bank']    = isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
    $data['bank_card']       = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
    $data['bank_card_user']  = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';
    $data['withdrawal_type'] = 0;
    $data['amount']          = isset($_POST['amount']) ? floatval(trim($_POST['amount'])) : 0;
    $data['status']          = 1;
    $data['add_time']        = time();

    if ($store_info['balance'] >= $data['amount']) {
        if ($store_withdrawal->add($data)) {
            $store->applywithdrawal($data['store_id'], $data['amount']);
            $store->drpProfitWithdrawal($data['store_id'], $data['amount']);
            json_return(0, $data['amount']);
        } else {
            json_return(1001, $data['amount']);
        }
    } else {
        json_return(1002, '余额不足，提现失败');
    }

} else if (IS_GET && $_GET['a'] == 'withdrawal_result') { //提现申请结果
    $store = $_SESSION['wap_drp_store'];
    $amount = !empty($_GET['amount']) ? trim($_GET['amount']) : 0;
    $status = !empty($_GET['status']) ? intval(trim($_GET['status'])) : 0;
    if ($status) {
        include display('drp_commission_withdrawal_success');
    } else {
        include display('drp_commission_withdrawal_error');
    }
    echo ob_get_clean();
} else if (IS_GET && $_GET['a'] == 'withdraw_account') { //提现账号
    $bank = M('Bank');
    $store = M('Store');

    $store_id = $_SESSION['wap_drp_store']['store_id'];
    $store = $store->getStore($store_id);
    $banks = $bank->getEnableBanks();

    include display('drp_commission_withdrawal_account');
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'withdraw_account') { //提现账号修改
    $store = M('Store');

    $store_id = $_SESSION['wap_drp_store']['store_id'];
    $bank_id = isset($_POST['bank_id']) ? intval(trim($_POST['bank_id'])) : 0;
    $opening_bank = isset($_POST['opening_bank']) ? trim($_POST['opening_bank']) : '';
    $bank_card = isset($_POST['bank_card']) ? trim($_POST['bank_card']) : '';
    $bank_card_user = isset($_POST['bank_card_user']) ? trim($_POST['bank_card_user']) : '';

    if ($store->settingWithdrawal(array('store_id' => $store_id), array('bank_id' => $bank_id, 'opening_bank' => $opening_bank, 'bank_card' => $bank_card, 'bank_card_user' => $bank_card_user, 'last_edit_time' => time()))) {
        json_return(0, '保存成功');
    } else {
        json_return(1001, '保存失败');
    }
} else if (IS_GET && $_GET['a'] == 'detail') { //佣金明细
    $financial_record = M('Financial_record');
    $store_withdrawal = M('Store_withdrawal');

    $store = $_SESSION['wap_drp_store'];
    //$record_count = $financial_record->getRecordCountByType(3, 5);
    $where = array();
    $where['store_id'] = $store['store_id'];
    $date = strtolower(trim($_GET['date']));
    if ($date == 'today') { //今天佣金明细
        $starttime = strtotime(date("Y-m-d") . ' 00:00:00');
        $stoptime = strtotime(date("Y-m-d") . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'yesterday') { //昨天佣金明细
        $date = date('Y-m-d' , strtotime('-1 day'));

        $starttime = strtotime($date . ' 00:00:00');
        $stoptime = strtotime($date . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'week') { //本周佣金明细
        $date = date('Y-m-d');  //当前日期
        $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期

        $starttime = strtotime($now_start . ' 00:00:00');
        $stoptime = strtotime($now_end . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'month') { //本月佣金明细
        $month = date('m');
        $year = date('Y');
        //当月最后一天
        $lastday = date('t',time());

        $starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
        $stoptime = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    }
    $record_count = $financial_record->getProfitRecordCount($where);
    $withdrawal_count = $store_withdrawal->getWithdrawalCount(array('store_id' => $store['store_id']));

    include display('drp_commission_detail');
    echo ob_get_clean();
} else if (IS_POST && $_POST['type'] == 'brokeragetab') {
    $financial_record = M('Financial_record');

    $store = $_SESSION['wap_drp_store'];
    $page_size = !empty($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 10;
    //$record_count = $financial_record->getRecordCountByType(3, 5);
    $where['store_id'] = $store['store_id'];
    $date = strtolower(trim($_POST['date']));
    if ($date == 'today') { //今天佣金明细
        $starttime = strtotime(date("Y-m-d") . ' 00:00:00');
        $stoptime = strtotime(date("Y-m-d") . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'yesterday') { //昨天佣金明细
        $date = date('Y-m-d' , strtotime('-1 day'));

        $starttime = strtotime($date . ' 00:00:00');
        $stoptime = strtotime($date . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'week') { //本周佣金明细
        $date = date('Y-m-d');  //当前日期
        $first = 1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w = date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end = date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期

        $starttime = strtotime($now_start . ' 00:00:00');
        $stoptime = strtotime($now_end . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    } else if ($date == 'month') { //本月佣金明细
        $month = date('m');
        $year = date('Y');
        //当月最后一天
        $lastday = date('t',time());

        $starttime = strtotime($year . '-' . $month . '-01' . ' 00:00:00');
        $stoptime = strtotime($year . '-' . $month . '-' . $lastday . ' 23:59:59');
        $where['_string'] = "add_time >= " . $starttime . " AND add_time <= " . $stoptime;
    }
    $record_count = $financial_record->getProfitRecordCount($where);
    import('source.class.user_page');
    $page = new Page($record_count, $page_size);
    //$records = $financial_record->getRecordsByType(3, 5, $page->firstRow, $page->listRows);
    $records = $financial_record->getProfitRecords($where, $page->firstRow, $page->listRows);
    $html = '';
    foreach ($records as $record) {
        $html .= '<tr>';
        $html .=    '<td>' . $record['order_id'] . '</td>';
        $html .=    '<td align="right">' . $record['profit'] . '</td>';
        $html .=    '<td style="text-align: center">' . date('Y-m-d', $record['add_time']) .'</td>';
        if ($record['status'] == 3) {
            $html .=    '<td style="text-align: center;color:green">交易完成</td>';
        } else {
            $html .=    '<td style="text-align: center;color:red">进行中</td>';
        }
        $html .= '</tr>';
    }
    echo json_encode(array('count' => count($records), 'data' => $html));
    exit;
} else if (IS_POST && $_POST['type'] == 'extracttab') { //提现记录
    $store_withdrawal = M('Store_withdrawal');

    $store = $_SESSION['wap_drp_store'];
    $page_size = !empty($_POST['pagesize']) ? intval(trim($_POST['pagesize'])) : 10;
    $withdrawal_count = $store_withdrawal->getWithdrawalCount(array('sw.store_id' => $store['store_id']));
    import('source.class.user_page');
    $page = new Page($withdrawal_count, $page_size);
    $withdrawals = $store_withdrawal->getWithdrawals(array('sw.store_id' => $store['store_id']), $page->firstRow, $page->listRows);
    $html = '';
    foreach ($withdrawals as $withdrawal) {
        $html .= '<tr>';
        $html .=    '<td style="text-align: center">' . date('Y-m-d H:i:s', $withdrawal['add_time']) . '</td>';
        $html .=    '<td align="right">' . $withdrawal['amount'] . '</td>';
        $html .=    '<td style="text-align: center">' . $store_withdrawal->getWithdrawalStatus($withdrawal['status']) .'</td>';
        $html .= '</tr>';
    }
    echo json_encode(array('count' => count($records), 'data' => $html));
    exit;
}