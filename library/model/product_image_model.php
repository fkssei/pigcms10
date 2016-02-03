<?php
/**
 * 商品图片数据模型
 * User: pigcms_21
 * Date: 2015/2/9
 * Time: 16:43
 */
    class product_image_model extends base_model
    {
        /**
         * @desc 获取商品图片
         * @param $product_id
         */
        public function getImages($product_id,$is_wap = false)
        {
            $images = $this->db->field('`image`')->where(array('product_id' => $product_id))->order('sort ASC')->select();
			foreach($images as &$value){
				$value['image'] = getAttachmentUrl($value['image']);
			}
            return $images;
        }

        /**
         * @desc 添加商品图片
         * @param $product_id
         * @param $images
         * @return array
         */
        public function add($product_id, $images)
        {
            $tmp_images = array();
            foreach ($images as $key => $image) {
                $result = $this->db->data(array('product_id' => $product_id, 'image' => $image, 'sort' => ($key + 1)))->add();
                if ($result) {
                    $tmp_images[] = array(
                        'image'    => $image
                    );
                }
            }
            return $tmp_images;
        }

        public function delete($product_id)
        {
            return $this->db->where(array('product_id' => $product_id))->delete();
        }
    }