<?php
class ControllerApi1cexchange extends Controller {
    public function sync() {

        $json = array();

        if (!isset($this->session->data['api_id'])) {
            $json['error']['warning'] = $this->language->get('error_permission');
        } else {
            
            $rawData = file_get_contents("php://input");    

            $xml=simplexml_load_string($rawData) or die("Error: Cannot create object");

            $keys = [];
            $data = [];

            foreach ($xml->column as $i => $column) {
                $keys[] = (string) $column->Name[0];
            }

            $rowIndex = 0;

            foreach ($xml->row as $i => $row) {
                $colIndex = 0;
                foreach ($row->Value as $j => $value) {
                    $data[$rowIndex][$keys[$colIndex]] = (string) $value;
                    $colIndex++;
                }
                $rowIndex++;
            }


            if ($data) {
                foreach ($data as $i => $datum) {

                    if(
                        isset($datum['Артикул']) &&
                        isset($datum['КількістьЗалишку']) &&
                        isset($datum['Ціна']) &&
                        isset($datum['ЦінаUSD']) &&
                        isset($datum['ЦінаEUR']) &&
                        isset($datum['ЦінаPLN']) &&
                        isset($datum['КодРодителя']) &&
                        isset($datum['Родитель']) &&
                        isset($datum['КодБренд']) &&
                        isset($datum['Бренд']) &&
                        isset($datum['НазваТовару']) &&
                        isset($datum['Смак']) 
                    ){
                        $uId = (string)$datum['Артикул'];
                        $qty = (int)$datum['КількістьЗалишку'];
                        $price = (float)$datum['Ціна'];
                        $priceUSD = (float)$datum['ЦінаUSD'];
                        $priceEUR = (float)$datum['ЦінаEUR'];
                        $pricePLN = (float)$datum['ЦінаPLN'];
                        $catId = (int)$datum['КодРодителя'];
                        $catName = (string)$datum['Родитель'];
                        $manufId = (int)$datum['КодБренд'];
                        $manufName = (string)$datum['Бренд'];
                        $productName = (string)$datum['НазваТовару'];
                        $productTaste = (string)$datum['Смак'];

                        $language_id = 1;

                        //Update currency rate
                        if(!$i) {
                            $UAH = $this->db->query("SELECT DISTINCT currency_id FROM `" . DB_PREFIX . "currency` WHERE code = 'UAH'");
                            $EUR = $this->db->query("SELECT DISTINCT currency_id FROM `" . DB_PREFIX . "currency` WHERE code = 'EUR'");
                            $PLN = $this->db->query("SELECT DISTINCT currency_id FROM `" . DB_PREFIX . "currency` WHERE code = 'PLN'");

                            if ($UAH->num_rows) {
                                $rate = $priceUSD / $price;
                                $this->db->query("UPDATE `" . DB_PREFIX . "currency` SET value = '" . (float)$rate . "' WHERE currency_id = '" . $UAH->row['currency_id'] . "'");
                            }

                            if ($EUR->num_rows) {
                                $rate = $priceEUR / $price;
                                $this->db->query("UPDATE `" . DB_PREFIX . "currency` SET value = '" . (float)$rate . "' WHERE currency_id = '" . $EUR->row['currency_id'] . "'");
                            }

                            if ($PLN->num_rows) {
                                $rate = $pricePLN / $price;
                                $this->db->query("UPDATE `" . DB_PREFIX . "currency` SET value = '" . (float)$rate . "' WHERE currency_id = '" . $PLN->row['currency_id'] . "'");
                            }
                        }

                        //Get manufacturer or create if not exist
                        $manufacturer_id = null;
                        $manufacturer = $this->db->query("SELECT DISTINCT manufacturer_id FROM `" . DB_PREFIX . "manufacturer` WHERE uid = '". $manufId ."'");
                        if ($manufacturer->num_rows) {
                            $manufacturer_id = $manufacturer->row['manufacturer_id'];
                            $this->db->query("UPDATE `" . DB_PREFIX . "manufacturer` SET name = '". $manufName ."' WHERE manufacturer_id = '". $manufacturer_id ."'");
                        } else {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($manufName) . "', uid = '" . $this->db->escape($manufId) . "'");
                            $manufacturer_id = $this->db->getLastId();
                            $this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . $manufacturer_id . "', store_id = 0");
                        }

                        //Get category or create if not exist
                        $category_id = null;
                        $category = $this->db->query("SELECT DISTINCT c.category_id, cd.name FROM `" . DB_PREFIX . "category` `c` LEFT JOIN `" . DB_PREFIX . "category_description` `cd` ON (c.category_id = cd.category_id) WHERE c.uid = '". $catId ."'");
                        if ($category->num_rows) {
                            $category_id = $category->row['category_id'];
                            $category_name = $category->row['category_id'];

                            $this->db->query("UPDATE `" . DB_PREFIX . "category_description` SET name = '". $catName ."' WHERE category_id = '". $category_id ."' AND language_id = '". $language_id ."'");
                        } else {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "category SET status=1, date_modified = NOW(), date_added = NOW(), uid = '" . $this->db->escape($catId) . "'");
                            $category_id = $this->db->getLastId();
                            
                            $this->db->query("INSERT INTO " . DB_PREFIX . "category_path SET category_id = '" . $category_id . "', path_id = '" . $category_id . "', level = 0");
                            $this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . $category_id . "', name = '" . $this->db->escape($catName) . "', language_id = '" . $language_id . "'");
                        }

                        //Get product and update it, or create if not exist
                        $product = $this->db->query("SELECT DISTINCT product_id FROM `" . DB_PREFIX . "product` WHERE model = '". $uId ."'");

                        if ($product->num_rows) {
                            $product_id = (int)$product->row['product_id'];
                            $this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = '" . (int)$qty . "', price = '" . (float)$priceUSD . "', manufacturer_id = '" . (int)$manufacturer_id . "' WHERE product_id = '" . $product_id . "'");

                        } else {

                            $this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($uId) . "', quantity = '" . (int)$qty . "', manufacturer_id = '" . (int)$manufacturer_id . "', price = '" . (float)$priceUSD . "', status = 1, date_added = NOW(), date_modified = NOW()");

                            $product_id = $this->db->getLastId();
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . $product_id . "', name = '" . $this->db->escape($productName) . "', language_id = '" . $language_id . "'");

                        }

                        //Update category
                        if ($category_id) {
                            $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
                        }


                        //Update filters
                        if(isset($productTaste) && $productTaste){
                            $filter_group_id = 1;

                            $filter = $this->db->query("SELECT DISTINCT f.filter_id FROM `" . DB_PREFIX . "filter` `f` LEFT JOIN `" . DB_PREFIX . "filter_description` `fd` ON (f.filter_id = fd.filter_id) WHERE fd.name = '". $productTaste ."'");

                            if ($filter->num_rows) {
                                $filter_id = $filter->row['filter_id'];
                            } else {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_group_id = '" . $filter_group_id . "'");
                                $filter_id = $this->db->getLastId();
                                
                                $this->db->query("INSERT INTO " . DB_PREFIX . "filter_description SET filter_id = '" . $filter_id . "', name = '" . $this->db->escape($productTaste) . "', language_id = '" . $language_id . "'");
                            }

                            $this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "' AND filter_id = '" . (int)$filter_id . "'");
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
                        }
                    } else {
                        //
                    }
                }

                $json['success'] = 'ok';
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
