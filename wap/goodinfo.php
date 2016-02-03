<?php
//狗扑源码社区 www.gope.cn
require_once dirname(__FILE__) . '/global.php';

if (IS_POST) {
	$action = (isset($_POST['action']) ? $_POST['action'] : 'getSku');

	switch ($action) {
	case 'getSku':
		$product_id = (isset($_POST['product_id']) ? intval($_POST['product_id']) : json_return(1000, '缺少必要参数'));
		$nowProduct = D('Product')->where(array('product_id' => $product_id))->field('`product_id`,`name`,`buy_way`,`quantity`,`image`,`price`,`sold_time`,`buyer_quota`,`buy_url`,`has_property`')->find();

		if (empty($nowProduct)) {
			json_return(1001, '商品不存在');
		}
		else if ($nowProduct['buy_way'] == '0') {
			json_return(1002, $nowProduct['buy_url']);
		}
		else if ($nowProduct['quantity'] == '0') {
			json_return(1003, '商品已经售完');
		}
		else if ($_SERVER['REQUEST_TIME'] < $nowProduct['sold_time']) {
			json_return(1004, '商品还未开始销售');
		}
		else if ($_SERVER['REQUEST_TIME'] < $nowProduct['sold_time']) {
			json_return(1005, '商品还未开始销售');
		}

		$nowProduct['image'] = getAttachmentUrl($nowProduct['image']);
		$returnArr['productInfo'] = $nowProduct;

		if ($nowProduct['has_property']) {
			$skuList = D('Product_sku')->field('`sku_id`,`properties`,`quantity`,`price`')->where(array(
	'product_id' => $product_id,
	'quantity'   => array('!=', '0')
	))->order('`sku_id` ASC')->select();

			if (!empty($skuList)) {
				$skuPriceArr = $skuPropertyArr = array();

				foreach ($skuList as $value) {
					$skuPriceArr[] = $value['price'];
					$skuPropertyArr[$value['properties']] = true;
				}

				if (!empty($skuPriceArr)) {
					$minPrice = min($skuPriceArr);
					$maxPrice = max($skuPriceArr);
				}
				else {
					json_return(1003, '商品已经售完');
				}

				$tmpPropertyList = D('')->field('`pp`.`pid`,`pp`.`name`')->table(array('Product_to_property' => 'ptp', 'Product_property' => 'pp'))->where('`ptp`.`product_id`=\'' . $product_id . '\' AND `pp`.`pid`=`ptp`.`pid`')->order('`ptp`.`pigcms_id` ASC')->select();

				if (!empty($tmpPropertyList)) {
					$tmpPropertyValueList = D('')->field('`ppv`.`vid`,`ppv`.`value`,`ppv`.`pid`')->table(array('Product_to_property_value' => 'ptpv', 'Product_property_value' => 'ppv'))->where('`ptpv`.`product_id`=\'' . $product_id . '\' AND `ppv`.`vid`=`ptpv`.`vid`')->order('`ptpv`.`pigcms_id` ASC')->select();

					if (!empty($tmpPropertyValueList)) {
						foreach ($tmpPropertyValueList as $value) {
							$propertyValueList[$value['pid']][] = array('vid' => $value['vid'], 'value' => $value['value']);
						}

						foreach ($tmpPropertyList as $value) {
							$newPropertyList[] = array('pid' => $value['pid'], 'name' => $value['name'], 'values' => $propertyValueList[$value['pid']]);
						}

						if (count($newPropertyList) == 1) {
							foreach ($newPropertyList[0]['values'] as $key => $value) {
								$tmpKey = $newPropertyList[0]['pid'] . ':' . $value['vid'];

								if (empty($skuPropertyArr[$tmpKey])) {
									unset($newPropertyList[0]['values'][$key]);
								}
							}
						}

						$returnArr['skuList'] = $skuList;
						$returnArr['propertyList'] = $newPropertyList;
					}
					else {
						json_return(1008, '未找到商品的库存信息，无法购买');
					}
				}
				else {
					json_return(1007, '未找到商品的库存信息，无法购买');
				}
			}
			else {
				json_return(1006, '商品已经售完');
			}
		}

		$returnArr['productInfo']['minPrice'] = !empty($minPrice) ? $minPrice : $nowProduct['price'];
		$returnArr['productInfo']['maxPrice'] = !empty($maxPrice) ? $maxPrice : 0;
		$returnArr['customFieldList'] = D('Product_custom_field')->field('`field_name`,`field_type`,`multi_rows`,`required`')->where(array('product_id' => $product_id))->order('`pigcms_id` ASC')->select();
		json_return(0, $returnArr);
		break;
	}
}

?>
