<?php
//¹·ÆËÔ´ÂëÉçÇø www.gope.cn
class product_custom_field_model extends base_model
{
	public function add($product_id, $fields)
	{
		foreach ($fields as $field) {
			$this->db->data(array('product_id' => $product_id, 'field_name' => $field['name'], 'field_type' => $field['type'], 'multi_rows' => $field['multi_rows'], 'required' => $field['required']))->add();
		}
	}

	public function delete($product_id)
	{
		$this->db->where(array('product_id' => $product_id))->delete();
		return true;
	}

	public function getFields($product_id)
	{
		$fields = $this->db->where(array('product_id' => $product_id))->select();
		return $fields;
	}
}

?>
