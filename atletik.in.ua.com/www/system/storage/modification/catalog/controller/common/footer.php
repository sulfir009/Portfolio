<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
		
				'short-des' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 300),
			
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['tracking'] = $this->url->link('information/tracking');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/login', '', true);
		$data['special'] = $this->url->link('product/list', 'available=1');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);
								
				$data['block3'] = $this->load->controller('common/block3');				
				$data['block4'] = $this->load->controller('common/block4');
				$data['block5'] = $this->load->controller('common/block5');
				$data['block6'] = $this->load->controller('common/block6');
				$data['block7'] = $this->load->controller('common/block7');
				$data['address'] = $this->config->get('config_address');
				$data['telephone'] = $this->config->get('config_telephone');
				$data['email'] = $this->config->get('config_email');
				$data['fax'] = $this->config->get('config_fax');
				$data['text_signup_newsletter'] = $this->language->get('text_signup_newsletter');
				$data['text_phone'] = $this->language->get('text_phone');
				$data['text_fax'] = $this->language->get('text_fax');
				$data['text_address'] = $this->language->get('text_address');
				$data['text_email'] = $this->language->get('text_email');
				$data['text_description'] = $this->language->get('text_description');
				$data['text_logo'] = $this->language->get('text_logo');
				$data['text_social'] = $this->language->get('text_social');
				if ($this->request->server['HTTPS']) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}
				if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
					$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
				} else {
					$data['logo'] = '';
				}
			

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = ($this->request->server['HTTPS'] ? 'https://' : 'http://') . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		$data['scripts'] = $this->document->getScripts('footer');
		
		return $this->load->view('common/footer', $data);
	}
}
