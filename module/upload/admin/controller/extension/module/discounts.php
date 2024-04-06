<?php
class ControllerExtensionModuleDiscounts extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('extension/module/discounts');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/discounts');
        $this->getList();
    }

    public function add() {
        $this->load->language('extension/module/discounts');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/discounts');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_extension_module_discounts->addDiscount($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module/discounts', 'user_token=' . $this->session->data['user_token'], true));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('extension/module/discounts');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/discounts');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_extension_module_discounts->editDiscount($this->request->get['discount_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module/discounts', 'user_token=' . $this->session->data['user_token'], true));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('extension/module/discounts');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/discounts');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $discount_id) {
                $this->model_extension_module_discounts->deleteDiscount($discount_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module/discounts', 'user_token=' . $this->session->data['user_token'], true));
        }

        $this->getList();
    }

    protected function getList() {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/discounts', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['add'] = $this->url->link('extension/module/discounts/add', 'user_token=' . $this->session->data['user_token'], true);
        $data['delete'] = $this->url->link('extension/module/discounts/delete', 'user_token=' . $this->session->data['user_token'], true);

        $data['discounts'] = array();

        $results = $this->model_extension_module_discounts->getDiscounts();

        foreach ($results as $result) {
            $data['discounts'][] = array(
                'discount_id' => $result['discount_id'],
                'name'       => $result['name'],
                'edit'       => $this->url->link('extension/module/discounts/edit', 'user_token=' . $this->session->data['user_token'] . '&discount_id=' . $result['discount_id'], true)
            );
       
        

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_name'] = $this->language->get('column_name');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['user_token'] = $this->session->data['user_token'];
        $this->response->setOutput($this->load->view('extension/module/discounts_list', $data));
    }
}
    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['discount_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_discount_percent'] = $this->language->get('entry_discount_percent');
        $data['entry_start_date'] = $this->language->get('entry_start_date');
        $data['entry_end_date'] = $this->language->get('entry_end_date');
        $data['entry_categories'] = $this->language->get('entry_categories');
        $data['entry_brands'] = $this->language->get('entry_brands');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/discounts', 'user_token=' . $this->session->data['user_token'], true)
        );

        if (!isset($this->request->get['discount_id'])) {
            $data['action'] = $this->url->link('extension/module/discounts/add', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/discounts/edit', 'user_token=' . $this->session->data['user_token'] . '&discount_id=' . $this->request->get['discount_id'], true);
        }

        $data['cancel'] = $this->url->link('extension/module/discounts', 'user_token=' . $this->session->data['user_token'], true);

        if (isset($this->request->get['discount_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $discount_info = $this->model_extension_module_discounts->getDiscount($this->request->get['discount_id']);
        }

        $this->load->model('catalog/category');
        $this->load->model('catalog/manufacturer');

        $data['categories'] = $this->model_catalog_category->getCategories(array());
        $data['brands'] = $this->model_catalog_manufacturer->getManufacturers(array());

        if (isset($this->request->post['category_ids'])) {
            $data['category_ids'] = $this->request->post['category_ids'];
        } elseif (!empty($discount_info['category_ids'])) {
            $data['category_ids'] = $discount_info['category_ids'];
        } else {
            $data['category_ids'] = array();
        }
    
        if (isset($this->request->post['brand_ids'])) {
            $data['brand_ids'] = $this->request->post['brand_ids'];
        } elseif (!empty($discount_info['brand_ids'])) {
            $data['brand_ids'] = $discount_info['brand_ids'];
        } else {
            $data['brand_ids'] = array();
        }
    

        if (isset($this->request->post['category_id'])) {
            $data['category_id'] = $this->request->post['category_id'];
        } elseif (!empty($discount_info)) {
            $data['category_id'] = $discount_info['category_id'];
       
        } else {
            $data['category_id'] = array();
        }

        if (isset($this->request->post['brand_id'])) {
            $data['brand_id'] = $this->request->post['brand_id'];
        } elseif (!empty($discount_info)) {
            $data['brand_id'] = $discount_info['brand_id'];
        } else {
            $data['brand_id'] = array();
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($discount_info)) {
            $data['name'] = $discount_info['name'];
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['discount_percent'])) {
            $data['discount_percent'] = $this->request->post['discount_percent'];
        } elseif (!empty($discount_info)) {
            $data['discount_percent'] = $discount_info['discount_percent'];
        } else {
            $data['discount_percent'] = '';
        }

        if (isset($this->request->post['start_date'])) {
            $data['start_date'] = $this->request->post['start_date'];
        } elseif (!empty($discount_info)) {
            $data['start_date'] = ($discount_info['start_date'] != '0000-00-00 00:00:00') ? $discount_info['start_date'] : '';
        } else {
            $data['start_date'] = '';
        }

        if (isset($this->request->post['end_date'])) {
            $data['end_date'] = $this->request->post['end_date'];
        } elseif (!empty($discount_info)) {
            $data['end_date'] = ($discount_info['end_date'] != '0000-00-00 00:00:00') ? $discount_info['end_date'] : '';
        } else {
            $data['end_date'] = '';
        }

        $data['user_token'] = $this->session->data['user_token'];
        $this->response->setOutput($this->load->view('extension/module/discounts_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'extension/module/discounts')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if (!$this->request->post['discount_percent'] || !is_numeric($this->request->post['discount_percent'])) {
            $this->error['discount_percent'] = $this->language->get('error_discount_percent');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'extension/module/discounts')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
    public function install() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "discounts` (
              `discount_id` INT(11) NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(255) NOT NULL,
              `discount_percent` DECIMAL(15,2) NOT NULL,
              `start_date` DATETIME NULL,
              `end_date` DATETIME NULL,
              PRIMARY KEY (`discount_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        ");
    
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "discounts_to_categories_brands` (
              `discount_id` INT(11) NOT NULL,
              `category_id` INT(11) NOT NULL,
              `brand_id` INT(11) NOT NULL,
              PRIMARY KEY (`discount_id`, `category_id`, `brand_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        ");
    
        // Реєстрація події для додавання пункту меню
        $this->load->model('setting/event');
        $this->model_setting_event->addEvent('discounts_event', 'admin/view/common/column_left/before', 'extension/module/discounts/addMenuItem');
    }
    
    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "discounts`;");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "discounts_to_categories_brands`;");
    
        $this->load->model('setting/event');
        $this->model_setting_event->deleteEventByCode('discounts_event');
    }
    
    public function addMenuItem(&$route, &$data) {
        if (!isset($data['menus']) || !is_array($data['menus'])) {
            return;
        }
    
        // Знайдіть правильне місце для вставки пункту меню (наприклад, у розділі 'Каталог')
        foreach ($data['menus'] as &$menu) {
            if ($menu['id'] == 'menu-catalog') {
                $menu['children'][] = array(
                    'name'     => 'Акції',
                    'href'     => $this->url->link('extension/module/discounts', 'user_token=' . $this->session->data['user_token'], true),
                    'children' => array()    
                );
                break;
            }
        }
    }
    
    
    
}
