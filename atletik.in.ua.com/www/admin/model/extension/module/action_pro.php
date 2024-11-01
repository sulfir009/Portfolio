<?php

/*
 * 
 */

class ModelExtensionModuleActionPro extends Model {
    public function showtables() {
        if ($this->db->query("SHOW TABLES LIKE 'product_special_archive'")->row == false) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_special_archive` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `product_special_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                `date_start` DATE NOT NULL DEFAULT '0000-00-00',
                `date_end` DATE NOT NULL DEFAULT '0000-00-00',
                `date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
        }
    }
    /* Выбираем категории */
    public function getCategory() {
        $query = $this->db->query("SELECT category_id, name FROM " . DB_PREFIX . "category_description WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name ASC");
        return $query->rows;
    }

    public function getParentCategory($id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category p LEFT JOIN " . DB_PREFIX . "category_description p2s ON (p.category_id = p2s.category_id) WHERE p.parent_id='" . (int)$id . "' AND p2s.language_id = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->rows;
    }

    public function getProductCategory($array) {
        $sql = "SELECT p.product_id, p2s.category_id, p.manufacturer_id, p.price, p.status FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2s ON (p.product_id = p2s.product_id) WHERE " . $this->db->escape($array);
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getProductManufacturer($array) {
        $sql = "SELECT product_id, manufacturer_id, price, status FROM " . DB_PREFIX . "product WHERE " . $this->db->escape($array);
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getSearchProductName($name) {
        $sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description p2s ON (p.product_id = p2s.product_id) WHERE p2s.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1'";
        if (!empty($name)) {
            $sql .= " AND (";
            $implode = [];
            $words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $this->db->escape($name))));
            foreach ($words as $word) {
                $implode[] = "LCASE(p2s.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(p.model) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
            }
            $sql .= implode(" OR ", $implode) . ")";
            $sql .= " LIMIT 12";
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function setParamsToSpecial($product_id, $price, $date_start, $date_end, $customer_group_id) {
        // Получить существующую скидку для продукта и группы клиента
        $query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND date_end >= NOW() AND date_start <= NOW() ORDER BY priority ASC, price ASC LIMIT 1");
    
        if ($query->num_rows) {
            // Если существует скидка, добавляем к ней новую скидку
            $existing_discount = $query->row['price'];
            $new_price = $existing_discount - ($existing_discount * $price / 100);
        } else {
            // Если скидки нет, просто назначаем новую скидку
            $new_price = $price - ($price * $price / 100);
        }
    
        // Вставить новую скидку в таблицу
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', price = '" . (float)$new_price . "', date_start = '" . $this->db->escape($date_start) . "', date_end = '" . $this->db->escape($date_end) . "', priority = '1', customer_group_id = '" . (int)$customer_group_id . "'");
        return $this->db->getLastId();
    }
    
    /* Записываем акции в архив */
    public function setArhiveToSpecial($array_arhive) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_special_archive SET `product_special_id`='" . $this->db->escape($array_arhive['product_special_id']) . "', `name`='" . $this->db->escape($array_arhive['name_auto_special']) . "', `date_start`='" . $this->db->escape($array_arhive['date_start']) . "', `date_end`='" . $this->db->escape($array_arhive['date_end']) . "', date_added = NOW()");
    }
    public function getArhiveToSpecial($data) {
        $sql = "SELECT * FROM " . DB_PREFIX . "product_special_archive ORDER BY `date_added` DESC";
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
    
    public function DeleteProductToSpecialAll() {
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "product_special_archive");
        $result = $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "product_special");
        return $result;
    }
    
    public function DeleteArhiveSpecial($product_special_id) {
        $result = [];
        $result['special'] = $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_special_id in (" . $this->db->escape($product_special_id) . ")");
        $result['archive'] = $this->db->query("DELETE FROM " . DB_PREFIX . "product_special_archive WHERE product_special_id ='" . $this->db->escape($product_special_id) . "'");
        return $result;
    }
    
    public function getAllSpecialCount() {
        $sql = "SELECT COUNT(id) as total FROM " . DB_PREFIX . "product_special_archive";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }
    

}
