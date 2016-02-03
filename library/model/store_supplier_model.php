<?php
/**
 * 店铺模型
 * User: pigcms_21
 * Date: 2015/2/2
 * Time: 22:00
 */
    class store_supplier_model extends base_model
    {
        public function add($data)
        {
            return $this->db->data($data)->add();
        }

        public function suppliers($where, $offset = 0, $limit = 0)
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.supplier_id';
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . implode(',', $value['like']) . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }
            if ($limit) {
                $sql .= ' LIMIT ' . $offset . ',' . $limit;
            }
            $suppliers = $this->db->query($sql);
            foreach ($suppliers as &$tmp) {
                $tmp['logo'] = getAttachmentUrl($tmp['logo']);
            }
            return $suppliers;
        }

        public function supplier_count($where)
        {
            $sql = "SELECT count(ss.supplier_id) AS suppliers FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.supplier_id';
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . implode(',', $value['like']) . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }
            $suppliers = $this->db->query($sql);
            return !empty($suppliers[0]['suppliers']) ? $suppliers[0]['suppliers'] : 0;
        }

        public function sellers($where, $offset = 0, $limit = 0)
        {
            $sql = "SELECT *,s.status,s.drp_profit as profit FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id';
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . implode(',', $value['like']) . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }
            $sql .= ' ORDER BY s.status ASC,s.drp_approve ASC,s.store_id DESC';
            if ($limit) {
                $sql .= ' LIMIT ' . $offset . ',' . $limit;
            }
            $sellers = $this->db->query($sql);
            foreach ($sellers as &$tmp) {
                $tmp['logo'] = getAttachmentUrl($tmp['logo']);
            }
            return $sellers;
        }

        public function seller_count($where)
        {
            $sql = "SELECT count(ss.seller_id) AS sellers FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id';
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        if (array_key_exists('like', $value)) {
                            $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                        } else if (array_key_exists('in', $value)) {
                            $sql .= " AND " . $key . " in (" . implode(',', $value['like']) . ")";
                        }
                    } else {
                        $sql .= " AND " . $key . "=" . $value;
                    }
                }
            }
            $sellers = $this->db->query($sql);
            return !empty($sellers[0]['sellers']) ? $sellers[0]['sellers'] : 0;
        }

        //获取符合条件的单个分销商
        public function getSeller($where)
        {
            $seller = $this->db->where($where)->find();
            return $seller;
        }
        //获取符合条件的多个分销商
        public function getSellers($where)
        {
            $sellers = $this->db->where($where)->select();
            return $sellers;
        }
    }