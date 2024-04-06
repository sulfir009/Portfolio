<?php

class ControllerExtensionModuleActionPro extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('extension/module/action_pro');
        $this->load->model('extension/module/action_pro');
        $this->load->model('catalog/manufacturer');
        $this->load->model('setting/setting');
        $this->load->model('tool/image');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addStyle('view/stylesheet/sol.css');
		$this->document->addStyle('view/stylesheet/action_pro.css');
		$this->document->addScript('view/javascript/jquery/bootstrap-checkbox/dist/js/bootstrap-checkbox.js');
		$this->document->addScript('view/javascript/jquery/sol.js');
        $this->model_extension_module_action_pro->showtables();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_action_pro', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));

        }

        $category = $this->getCategory();

        $data['array_manufacturer'] = $this->model_catalog_manufacturer->getManufacturers();


        $data['text_delete_special'] = $this->language->get('text_delete_special');
		$data['entry_btn_action_start'] = $this->language->get('entry_btn_action_start');
		$data['entry_btn_action_stop'] = $this->language->get('entry_btn_action_stop');
		$data['entry_btn_action_del'] = $this->language->get('entry_btn_action_del');
		$data['entry_update_btn'] = $this->language->get('entry_update_btn');
        $data['text_update'] = $this->language->get('text_update');
        $data['text_clean'] = $this->language->get('text_clean');
        $data['heading_title'] = $this->language->get('heading_title');
        $data['settings'] = $this->language->get('settings');
        $data['text_date_added'] = $this->language->get('text_date_added');
        $data['text_date_start'] = $this->language->get('text_date_start');
        $data['text_date_end'] = $this->language->get('text_date_end');

        $data['text_success_all'] = $this->language->get('text_success_all');
        $data['text_error_all'] = $this->language->get('text_error_all');
        $data['text_error_name_auto_special'] = $this->language->get('text_error_name_auto_special');


        $data['text_state'] = $this->language->get('text_state');
        $data['text_discount_action'] = $this->language->get('text_discount_action');
        $data['text_auto_action'] = $this->language->get('text_auto_action');
        $data['text_manual_action'] = $this->language->get('text_manual_action');
        $data['text_settings_manual'] = $this->language->get('text_settings_manual');
        $data['text_archiv_action'] = $this->language->get('text_archiv_action');

        $data['text_current_action'] = $this->language->get('text_current_action');
        $data['text_description_module_auto'] = $this->language->get('text_description_module_auto');

        $data['text_auto_mode'] = $this->language->get('text_auto_mode');
        $data['text_view'] = $this->language->get('text_view');

        $data['text_special_price'] = $this->language->get('text_special_price');
        $data['text_auto_products_views'] = $this->language->get('text_auto_products_views');
        $data['text_info'] = $this->language->get('text_info');
        $data['text_email_delivery'] = $this->language->get('text_email_delivery');
        $data['text_filter_name'] = $this->language->get('text_filter_name');
        $data['text_found_products'] = $this->language->get('text_found_products');
        $data['text_select_products'] = $this->language->get('text_select_products');
        $data['text_not_select_products'] = $this->language->get('text_not_select_products');
        $data['text_on'] = $this->language->get('text_on');
        $data['text_off'] = $this->language->get('text_off');
        $data['text_not_round'] = $this->language->get('text_not_round');
        $data['text_round'] = $this->language->get('text_round');
        $data['text_floor'] = $this->language->get('text_floor');
        $data['text_ceil'] = $this->language->get('text_ceil');
        $data['text_procent_round'] = $this->language->get('text_procent_round');
        $data['txt_cap'] = $this->language->get('txt_cap');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_customer_group'] = $this->language->get('text_customer_group');
       
        $data['text_count_view'] = $this->language->get('text_count_view');
        $data['text_not_found'] = $this->language->get('text_not_found');
        $data['text_success_add_product'] = $this->language->get('text_success_add_product');
        $data['text_manual_mode_mess'] = $this->language->get('text_manual_mode_mess');
        $data['text_arch_total_views'] = $this->language->get('text_arch_total_views');
        $data['text_arch_participate_action'] = $this->language->get('text_arch_participate_action');
        $data['text_arch_order'] = $this->language->get('text_arch_order');
        $data['text_arch_viewed'] = $this->language->get('text_arch_viewed');

        $data['tooltip_procent'] = $this->language->get('tooltip_procent');
        $data['tooltip_email_delivery'] = $this->language->get('tooltip_email_delivery');
        $data['tooltip_customer_group'] = $this->language->get('tooltip_customer_group');
        $data['tooltip_filter_name'] = $this->language->get('tooltip_filter_name');
        $data['tooltip_procent_round'] = $this->language->get('tooltip_procent_round');
        $data['info'] = $this->language->get('info');
        $data['date_now'] = date('Y-m-d');
        $data['array_category'] = $category;
        $data['select_manufacturer'] = $this->language->get('select_manufacturer');
        $data['select_category'] = $this->language->get('select_category');
        $data['categorys'] = $this->language->get('categorys');
        $data['entry_procent'] = $this->language->get('entry_procent');

        $data['entry_name'] = $this->language->get('entry_name');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['change_button_start'] = $this->makeUrlScript('extension/module/action_pro/addAutoSpecial');
        $data['change_button_delete'] = $this->makeUrlScript('extension/module/action_pro/DeleteProductToSpecialAll');
        $data['search_products_name'] = $this->makeUrlScript('extension/module/action_pro/getAjaxSearchNameProducts');
        $data['add_settings_item'] = $this->makeUrlScript('extension/module/action_pro/getAjaxAddSettings');
        $data['delete_arhive_special'] = $this->makeUrlScript('extension/module/action_pro/DeleteArhiveSpecial');





        if (isset($this->error['module_action_pro_warning'])) {
            $data['error_module_action_pro_warning'] = $this->error['module_action_pro_warning'];
        } else {
            $data['error_module_action_pro_warning'] = '';
        }

        if (isset($this->error['module_action_pro_name'])) {
            $data['error_module_action_pro_name'] = $this->error['module_action_pro_name'];
        } else {
            $data['error_module_action_pro_name'] = '';
        }



        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/action_pro', 'user_token=' . $this->session->data['user_token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/action_pro', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }


            $data['action'] = $this->url->link('extension/module/action_pro', 'user_token=' . $this->session->data['user_token'], true);
            $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);



        if (isset($this->request->post['module_action_pro_status'])) {
            $data['module_action_pro_status'] = $this->request->post['module_action_pro_status'];
        } elseif (!empty($this->config->get('module_action_pro_status'))) {
            $data['module_action_pro_status'] = $this->config->get('module_action_pro_status');
        } else {
            $data['module_action_pro_status'] = '';
        }

        if (isset($this->request->post['module_action_pro_config']['procent_round'])) {
            $data['module_action_pro_config']['procent_round'] = (int) $this->request->post['module_action_pro_config']['procent_round'];
        } elseif (!empty($this->config->get('module_action_pro_config')['procent_round'])) {
            $data['module_action_pro_config']['procent_round'] = $this->config->get('module_action_pro_config')['procent_round'];
        } else {
            $data['module_action_pro_config']['procent_round'] = '';
        }

        if (isset($this->request->post['module_action_pro_config']['procent'])) {
            $data['module_action_pro_config']['procent'] = (int) $this->request->post['module_action_pro_config']['procent'];
        } elseif (!empty($this->config->get('module_action_pro_config')['procent'])) {
            $data['module_action_pro_config']['procent'] = $this->config->get('module_action_pro_config')['procent'];
        } else {
            $data['module_action_pro_config']['procent'] = '';
            $data['module_action_pro_config']['procent'] = '';
        }
		if (VERSION < '2.1.0.1') {
			$this->load->model('sale/customer_group');

			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		} else {
			$this->load->model('customer/customer_group');

			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		}
		
        if (isset($this->request->post['module_action_pro_config']['customer_group_id'])) {
            $data['module_action_pro_config']['customer_group_id'] = $this->request->post['module_action_pro_config']['customer_group_id'];
        } elseif (!empty($this->config->get('module_action_pro_config')['customer_group_id'])) {
            $data['module_action_pro_config']['customer_group_id'] = $this->config->get('module_action_pro_config')['customer_group_id'];
        } else {
            $data['module_action_pro_config']['customer_group_id'] = '';
        }

      
        if (isset($this->request->post['module_action_pro_config']['date_end'])) {
            $data['module_action_pro_config']['date_end'] = $this->request->post['module_action_pro_config']['date_end'];
        } elseif (!empty($this->config->get('module_action_pro_config')['date_end'])) {
            $data['module_action_pro_config']['date_end'] = $this->config->get('module_action_pro_config')['date_end'];
        } else {
            $data['module_action_pro_config']['date_end'] = '';
        }

        if (isset($this->request->post['module_action_pro_config']['date_start'])) {
            $data['module_action_pro_config']['date_start'] = $this->request->post['module_action_pro_config']['date_start'];
        } elseif (!empty($this->config->get('module_action_pro_config')['date_start'])) {
            $data['module_action_pro_config']['date_start'] = $this->config->get('module_action_pro_config')['date_start'];
        } else {
            $data['module_action_pro_config']['date_start'] = '';
        }

        if (isset($this->request->post['module_action_pro_config']['category'])) {
            $data['module_action_pro_config']['category'] = $this->request->post['module_action_pro_config']['category'];
        } elseif (!empty($this->config->get('module_action_pro_config')['category'])) {
            $data['module_action_pro_config']['category'] = $this->config->get('module_action_pro_config')['category'];
        } else {
            $data['module_action_pro_config']['category'] = array();
        }

        if (isset($this->request->post['module_action_pro_config']['manufacturer'])) {
            $data['module_action_pro_config']['manufacturer'] = $this->request->post['module_action_pro_config']['manufacturer'];
        } elseif (!empty($this->config->get('module_action_pro_config')['manufacturer'])) {
            $data['module_action_pro_config']['manufacturer'] = $this->config->get('module_action_pro_config')['manufacturer'];
        } else {
            $data['module_action_pro_config']['manufacturer'] = array();
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }


        $special_total = $this->model_extension_module_action_pro->getAllSpecialCount();
        $filter_data = array(
            'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'           => $this->config->get('config_limit_admin')
        );
        $data['arhive_to_special'] = $this->model_extension_module_action_pro->getArhiveToSpecial($filter_data);

        $pagination = new Pagination();
        $pagination->total = $special_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('extension/module/action_pro', 'user_token=' . $this->session->data['user_token']  . '&page={page}#tab3', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($special_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($special_total - $this->config->get('config_limit_admin'))) ? $special_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $special_total, ceil($special_total / $this->config->get('config_limit_admin')));




        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/action_pro', $data));
    }

    protected function validate() {

        if (!$this->user->hasPermission('modify', 'extension/module/action_pro')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }



        return !$this->error;
    }

    public function addAutoSpecial() {
        $json = array();
        $this->load->model('extension/module/action_pro');
        $this->load->language('extension/module/action_pro');
        if (!empty($this->request->post['module_action_pro_config']['manufacturer']) || !empty($this->request->post['module_action_pro_config']['category'])) {

            /**
             * Если и категория и производитель не пустые
             */
            if (!empty($this->request->post['module_action_pro_config']['category']) && !empty($this->request->post['module_action_pro_config']['manufacturer'])) {
                
                $sql = "p2s.category_id in (" . implode(',', $this->request->post['module_action_pro_config']['category']) . ") AND p.manufacturer_id in (" . implode(',', $this->request->post['module_action_pro_config']['manufacturer']) . ") ";

                $product = $this->model_extension_module_action_pro->getProductCategory($sql);

                if (!empty($product)) {
                    $col = $this->addSpecial($product);
                    $json['success'] = sprintf($this->language->get('text_success_action'),$col);
                } else {
                    $json['error'] = sprintf($this->language->get('text_error_action'));
                }


            }
            /**
             * Если Категори не пустая, а производитель пустой
             */
            if (!empty($this->request->post['module_action_pro_config']['category']) && empty($this->request->post['module_action_pro_config']['manufacturer'])) {

                $sql = "p2s.category_id in (" . implode(',', $this->request->post['module_action_pro_config']['category']) . ")";
                $product = $this->model_extension_module_action_pro->getProductCategory($sql);
                if (!empty($product)) {
                    $col = $this->addSpecial($product);
                    $json['success'] = sprintf($this->language->get('text_success_action'),$col);
                } else {
                    $json['error'] = sprintf($this->language->get('text_error_action'));
                }

                
            }
            /**
             * Если категория пустая, а производитель не пустой
             */
            if (empty($this->request->post['module_action_pro_config']['category']) && !empty($this->request->post['module_action_pro_config']['manufacturer'])) {
                $sql = "manufacturer_id in (" . implode(',', $this->request->post['module_action_pro_config']['manufacturer']) . ")";
                $product = $this->model_extension_module_action_pro->getProductManufacturer($sql);

                if (!empty($product)) {
                    $col = $this->addSpecial($product);
                    $json['success'] = sprintf($this->language->get('text_success_action'),$col);
                } else {
                    $json['error'] = sprintf($this->language->get('text_error_action'));
                }


            }
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function addSpecial($product){

        $product_special_id = array();
        $i = 0;
        foreach ($product as $value) {
            $price = $this->roundProcentToPrice($value['price'], $this->request->post['module_action_pro_config']['procent'], $this->request->post['module_action_pro_config']['procent_round']);

            $product_special_id[] = $this->model_extension_module_action_pro->setParamsToSpecial($value['product_id'], $price, $this->request->post['module_action_pro_config']['date_start'], $this->request->post['module_action_pro_config']['date_end'], $this->request->post['module_action_pro_config']['customer_group_id']);
            $i++;

        }
        $array_arhive = [
                'product_special_id' => implode(',',$product_special_id),
                'name_auto_special' => $this->request->post['name_auto_special'],
                'date_start' => $this->request->post['module_action_pro_config']['date_start'],
                'date_end' => $this->request->post['module_action_pro_config']['date_end']
            ];
        $this->model_extension_module_action_pro->setArhiveToSpecial($array_arhive);
        return $i;
    }
    public function DeleteProductToSpecialAll(){
        $json = array();
        $this->load->model('extension/module/action_pro');
        $this->load->language('extension/module/action_pro');
        $result = $this->model_extension_module_action_pro->DeleteProductToSpecialAll();
        if ($result) {
            $json['success'] = $this->language->get('text_success_action_del');
        } else {
            $json['error'] = $this->language->get('text_error_action_del');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    public function DeleteArhiveSpecial(){
        $json = array();
        $this->load->model('extension/module/action_pro');
        $this->load->language('extension/module/action_pro');
        $result = $this->model_extension_module_action_pro->DeleteArhiveSpecial($this->request->post['special_id']);
        if ($result['special'] && $result['archive']) {
            $json['success'] = $this->language->get('text_success_action_del');
        } else {
            $json['error'] = $this->language->get('text_error_action_del');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }


    private function makeUrlScript($route, $arg='') {
        return str_replace('&amp;','&',$this->makeUrl($route, $arg));
    }

    private function makeUrl($route, $arg='') {
        if ($arg) {
            $arg = '&' . ltrim($arg, '&');
        }
        return $this->url->link($route, 'user_token=' . $this->session->data['user_token'] . $arg, true);
    }

    public function getAjaxSearchNameProducts() {
        $this->load->model('extension/module/action_pro');
        $products = $this->model_extension_module_action_pro->getSearchProductName($this->request->post['name']);
        foreach ($products as $key => $value) {
            $products[$key]['price_format'] = $this->currency->format($value['price'], $this->config->get('config_currency'));

        }
        $json['success'] = $products;
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getAjaxAddSettings() {
        $this->load->model('extension/module/action_pro');

        $price = $this->roundProcentToPrice($this->request->post['price'], $this->request->post['procent'], $this->request->post['round']);


        $this->model_extension_module_action_pro->setParamsToSpecial($this->request->post['product_id'], $price, $this->request->post['date_start'], $this->request->post['date_end'],$this->request->post['customer_group_id']);

        $result = array(
            "date_start" => $this->request->post['date_start'],
            "date_end" => $this->request->post['date_end'],
            "procent" => $this->request->post['procent'],
            "procent_round" => $this->request->post['round'],
            "customer_group_id" => $this->request->post['customer_group_id'],
            "product_id" => $this->request->post['product_id']
        );

        $this->session->data['settings'][] = $result;
        $json['success'] = true;
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function roundProcentToPrice($price, $procent, $round) {
        switch ($round) {
            case 1:
                $price = $price - ($price * $procent / 100);
                break;
            case 2:
                $price = ceil($price - ($price * $procent) / 100);
                break;
            case 3:
                $price = floor($price - ($price * $procent) / 100);
                break;

            default:
                $price = $price - ($price * $procent / 100);
                break;
        }
        return $price;
    }


    /**
     *
     * Выбираем все категории
     */
    public function getCategory() {
        $category = $this->model_extension_module_action_pro->getCategory();

        foreach ($category as $key => $value) {
            $category[$key]['parent'] = $this->model_extension_module_action_pro->getParentCategory($category[$key]['category_id']);
        }

        foreach ($category as $k => $v) {
            for ($i = 0; $i < count($v['parent']); $i++) {
                $cat = $this->model_extension_module_action_pro->getParentCategory($v['parent'][$i]['category_id']);
                foreach ($cat as $key => $value) {
                    $category[$k]['parent'][] = $value;
                }
            }
        }
        return $category;
    }




    

}
