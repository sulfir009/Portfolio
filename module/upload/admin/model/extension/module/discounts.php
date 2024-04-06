<?php
class ModelExtensionModuleDiscounts extends Model {
    
    public function addDiscount($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "discounts SET name = '" . $this->db->escape($data['name']) . "', discount_percent = '" . (float)$data['discount_percent'] . "', start_date = '" . $this->db->escape($data['start_date']) . "', end_date = '" . $this->db->escape($data['end_date']) . "'");
        if ($this->db->countAffected() <= 0) {
            throw new Exception('Ошибка добавления скидки');
        }
        $discount_id = $this->db->getLastId();

        if (isset($data['category_ids'])) {
            foreach ($data['category_ids'] as $category_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "discounts_to_categories_brands SET discount_id = '" . (int)$discount_id . "', category_id = '" . (int)$category_id . "'");
            }
        }

        if (isset($data['brand_ids'])) {
            foreach ($data['brand_ids'] as $brand_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "discounts_to_categories_brands SET discount_id = '" . (int)$discount_id . "', brand_id = '" . (int)$brand_id . "'");
            }
        }
    }

    public function editDiscount($discount_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "discounts SET name = '" . $this->db->escape($data['name']) . "', discount_percent = '" . (float)$data['discount_percent'] . "', start_date = '" . $this->db->escape($data['start_date']) . "', end_date = '" . $this->db->escape($data['end_date']) . "' WHERE discount_id = '" . (int)$discount_id . "'");
        if ($this->db->countAffected() <= 0) {
            throw new Exception('Ошибка обновления скидки');
        }
        $this->db->query("DELETE FROM " . DB_PREFIX . "discounts_to_categories_brands WHERE discount_id = '" . (int)$discount_id . "'");

        if (isset($data['category_ids'])) {
            foreach ($data['category_ids'] as $category_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "discounts_to_categories_brands SET discount_id = '" . (int)$discount_id . "', category_id = '" . (int)$category_id . "'");
            }
        }

        if (isset($data['brand_ids'])) {
            foreach ($data['brand_ids'] as $brand_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "discounts_to_categories_brands SET discount_id = '" . (int)$discount_id . "', brand_id = '" . (int)$brand_id . "'");
            }
        }
    }

    public function deleteDiscount($discount_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "discounts WHERE discount_id = '" . (int)$discount_id . "'");
        if ($this->db->countAffected() <= 0) {
            throw new Exception('Ошибка удаления скидки');
        }
        $this->db->query("DELETE FROM " . DB_PREFIX . "discounts_to_categories_brands WHERE discount_id = '" . (int)$discount_id . "'");
    }

    public function getDiscount($discount_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "discounts WHERE discount_id = '" . (int)$discount_id . "'");

        return $query->row;
    }

    public function getDiscounts($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "discounts";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }
    public function getDiscountCategories($discount_id) {
        $category_data = array();

        $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "discounts_to_categories_brands WHERE discount_id = '" . (int)$discount_id . "'");

        foreach ($query->rows as $result) {
            $category_data[] = $result['category_id'];
        }

        return $category_data;
    }

    public function getDiscountBrands($discount_id) {
        $brand_data = array();

        $query = $this->db->query("SELECT brand_id FROM " . DB_PREFIX . "discounts_to_categories_brands WHERE discount_id = '" . (int)$discount_id . "'");

        foreach ($query->rows as $result) {
            $brand_data[] = $result['brand_id'];
        }

        return $brand_data;
    }
}

