<?php

class ControllerProductOcfilter extends Controller
{
	public function index()
	{
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		$category_id = end($parts);

		$this->load->model('catalog/category');

		$category_info = $this->model_catalog_category->getCategory($category_id);

		$data = array();

		if (!empty($_SERVER['HTTPS'])) {
			// SSL connection
			$base_url = str_replace('http://', 'https://', $this->config->get('config_url'));
		} else {
			$base_url = $this->config->get('config_url');
		}

		if ($category_info) {
			$this->load->language('product/ocfilter');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['action'] = str_replace('&amp;', '&', $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . $url);
			$data['clear_action'] = str_replace('&amp;', '&', $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id);

			if (isset($this->request->get['filter'])) {
				$data['filter_category'] = explode(',', $this->request->get['filter']);
			} else {
				$data['filter_category'] = array();
			}

			$this->load->model('catalog/product');

			// Min price and Max price of product collection
			/* Begin */
			$min_price = 1000000000;  // Set the large number
			$max_price = 0;         // Set the small number

			$data['products'] = array();

			$filter_data = array(
				'filter_category_id' => $category_id
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				if ($result['special']) {
					$price = (float)$result['special'];
				} else {
					$price = (float)$result['price'];
				}

				if ($price < $min_price) {
					$min_price = $price;
				}

				if ($price > $max_price) {
					$max_price = $price;
				}
			}

			$rate = (float)$this->currency->getValue($this->session->data['currency']);

			$data['min_price'] = ceil($min_price * $rate);
			$data['max_price'] = round($max_price * $rate);

			$data['currency_symbol_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
			$data['currency_symbol_right'] = $this->currency->getSymbolRight($this->session->data['currency']);
			/* End */

			$data['filter_groups'] = array();

			$filter_groups = $this->model_catalog_category->getCategoryFilters($category_id);

			if ($filter_groups) {
				foreach ($filter_groups as $filter_group) {
					$childen_data = array();

					foreach ($filter_group['filter'] as $filter) {
						$filter_data = array(
							'filter_category_id' => $category_id,
							'filter_filter' => $filter['filter_id']
						);

						$childen_data[] = array(
							'filter_id' => $filter['filter_id'],
							'name' => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
							'e_name' => $filter['name']
						);
					}

					$data['filter_groups'][] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name' => $filter_group['name'],
						'filter' => $childen_data
					);
				}
			}
		}

		return $this->load->view('product/ocfilter/filter', $data);
	}

	/**
	 * Load Layer after filter
	 */
	public function layer()
	{
		if (!empty($_SERVER['HTTPS'])) {
			// SSL connection
			$base_url = str_replace('http://', 'https://', $this->config->get('config_url'));
		} else {
			$base_url = $this->config->get('config_url');
		}

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		$category_id = end($parts);

		$this->load->model('catalog/category');

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			$this->load->language('product/ocfilter');

			$data['clear_action'] = str_replace('&amp;', '&', $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id);

			if (isset($this->request->get['filter'])) {
				$data['filter_category'] = explode(',', $this->request->get['filter']);
			} else {
				$data['filter_category'] = array();
			}

			$this->load->model('catalog/product');

			// Min price and Max price of product collection
			/* Begin */
			$min_price = 1000000000;  // Set the large number
			$max_price = 0;         // Set the small number

			$data['products'] = array();

			$filter_data = array(
				'filter_category_id' => $category_id
			);

			$rate = (float)$this->currency->getValue($this->session->data['currency']);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				if ($result['special']) {
					$price = (float)$result['special'];
				} else {
					$price = (float)$result['price'];
				}

				if ($price < $min_price) {
					$min_price = $price;
				}

				if ($price > $max_price) {
					$max_price = $price;
				}
			}

			$data['min_price'] = ceil($min_price * $rate);
			$data['max_price'] = round($max_price * $rate);

			if (isset($this->request->get['price'])) {
				$price_data = $this->request->get['price'];
			} else {
				$price_data = '';
			}

			if (isset($this->request->get['price'])) {
				$price_data = explode(',', $price_data);
				$data['current_min_price'] = $price_data[0];
				$data['current_max_price'] = $price_data[1];
			} else {
				$data['current_min_price'] = $data['min_price'];
				$data['current_max_price'] = $data['max_price'];
			}

			$data['currency_symbol_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
			$data['currency_symbol_right'] = $this->currency->getSymbolRight($this->session->data['currency']);
			/* End */

			$data['filter_groups'] = array();

			$filter_groups = $this->model_catalog_category->getCategoryFilters($category_id);

			if ($filter_groups) {
				foreach ($filter_groups as $filter_group) {
					$childen_data = array();

					foreach ($filter_group['filter'] as $filter) {
						$filter_data = array(
							'filter_category_id' => $category_id,
							'filter_filter' => $filter['filter_id']
						);

						$childen_data[] = array(
							'filter_id' => $filter['filter_id'],
							'name' => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
							'e_name' => $filter['name']
						);
					}

					$data['filter_groups'][] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name' => $filter_group['name'],
						'filter' => $childen_data
					);
				}
			}
		}

		return $this->load->view('product/ocfilter/filter_ajax', $data);
	}

	/**
	 * Load category view
	 */
	public function category()
	{

		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (!empty($_SERVER['HTTPS'])) {
			// SSL connection
			$base_url = str_replace('http://', 'https://', $this->config->get('config_url'));
		} else {
			$base_url = $this->config->get('config_url');
		}

		$json = array();

		if (isset($this->request->get['price'])) {
			$price_data = $this->request->get['price'];
		} else {
			$price_data = '';
		}

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

		} else {
			$category_id = 0;
		}

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			$store_id = $this->config->get('config_store_id');
			if (isset($this->config->get('module_octhemeoption_custom_view')[$store_id])) {
				$data['use_custom_view'] = (int)$this->config->get('module_octhemeoption_custom_view')[$store_id];
			} else {
				$data['use_custom_view'] = 0;
			}

			if (isset($this->config->get('module_octhemeoption_category_view')[$store_id])) {
				$data['category_view'] = $this->config->get('module_octhemeoption_category_view')[$store_id];
			} else {
				$data['category_view'] = false;
			}

			if (isset($this->config->get('module_octhemeoption_category_view')[$store_id])) {
				$data['grid_columns'] = $this->config->get('module_octhemeoption_grid_columns')[$store_id];
			} else {
				$data['grid_columns'] = false;
			}

			if (isset($this->config->get('module_octhemeoption_use_layered')[$store_id])) {
				$data['use_layered'] = (int)$this->config->get('module_octhemeoption_use_layered')[$store_id];
			} else {
				$data['use_layered'] = 0;
			}

			if (isset($this->config->get('module_octhemeoption_use_cate_quickview')[$store_id])) {
				$data['use_quickview'] = (int)$this->config->get('module_octhemeoption_use_cate_quickview')[$store_id];
			} else {
				$data['use_quickview'] = 0;
			}

			if (isset($this->config->get('module_octhemeoption_image_effect')[$store_id])) {
				$data['image_effect'] = $this->config->get('module_octhemeoption_image_effect')[$store_id];
			} else {
				$data['image_effect'] = false;
			}

			$data['ajax_sorts'] = array();

			$data['ajax_limits'] = array();

			if ($data['use_layered']) {
				$url = '';

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				if (isset($this->request->get['price'])) {
					$url .= '&price=' . $this->request->get['price'];
				}

				$data['ajax_sorts'][] = array(
					'text' => $this->language->get('text_default'),
					'value' => 'p.sort_order-ASC',
					'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . '&sort=p.sort_order&order=ASC' . $url
				);

				$data['ajax_sorts'][] = array(
					'text' => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . '&sort=pd.name&order=ASC' . $url
				);

				$data['ajax_sorts'][] = array(
					'text' => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . '&sort=pd.name&order=DESC' . $url
				);

				$data['ajax_sorts'][] = array(
					'text' => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . '&sort=p.price&order=ASC' . $url
				);

				$data['ajax_sorts'][] = array(
					'text' => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . '&sort=p.price&order=DESC' . $url
				);

				/*if ($this->config->get('config_review_status')) {
					$data['ajax_sorts'][] = array(
						'text' => $this->language->get('text_rating_desc'),
						'value' => 'rating-DESC',
						'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . '&sort=rating&order=DESC' . $url
					);

					$data['ajax_sorts'][] = array(
						'text' => $this->language->get('text_rating_asc'),
						'value' => 'rating-ASC',
						'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . '&sort=rating&order=ASC' . $url
					);
				}*/

				/*$data['ajax_sorts'][] = array(
					'text' => $this->language->get('text_model_asc'),
					'value' => 'p.model-ASC',
					'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . '&sort=p.model&order=ASC' . $url
				);

				$data['ajax_sorts'][] = array(
					'text' => $this->language->get('text_model_desc'),
					'value' => 'p.model-DESC',
					'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . '&sort=p.model&order=DESC' . $url
				);*/

				$url = '';

				if (isset($this->request->get['filter'])) {
					$url .= '&filter=' . $this->request->get['filter'];
				}

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['price'])) {
					$url .= '&price=' . $this->request->get['price'];
				}

				$data['ajax_limits'] = array();

				$limits = array_unique(array($this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

				sort($limits);

				foreach ($limits as $value) {
					$data['ajax_limits'][] = array(
						'text' => $value,
						'value' => $value,
						'href' => $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . $url . '&limit=' . $value
					);
				}
			}

			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
			} else {
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('product/compare');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id' => $result['category_id'],
					'filter_sub_category' => true
				);

				$data['categories'][] = array(
					'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
				);
			}

			$data['products'] = array();

			$rate = (float)$this->currency->getValue($this->session->data['currency']);

			// Min and Max Price
			$filter_price = array();
			if (isset($this->request->get['price'])) {
				$price_data = explode(',', $price_data);
				$filter_price['min_price'] = ceil($price_data[0] / $rate - 1);
				$filter_price['max_price'] = round($price_data[1] / $rate);
			}

			// var_dump($filter_price);die;
			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter' => $filter,
				'filter_price' => $filter_price,
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
			);

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$rate_special = round(100 - ((float)$result['special'] / $result['price'] * 100));
				} else {
					$special = false;
					$rate_special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				if ($data['image_effect'] == 'rotator') {
					$this->load->model('catalog/ocproductrotator');

					$product_rotator_image = $this->model_catalog_ocproductrotator->getProductRotatorImage($result['product_id']);

					if ($product_rotator_image) {
						$rotate_image = $this->model_tool_image->resize($product_rotator_image, $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
					} else {
						$rotate_image = false;
					}
				} else {
					$rotate_image = false;
				}

				$swatches_images = array();

				$options = array();

				if ($data['image_effect'] == 'swatches') {
					$data['icon_swatches_width'] = $this->config->get('module_octhemeoption_cate_swatches_width')[$store_id];
					$data['icon_swatches_height'] = $this->config->get('module_octhemeoption_cate_swatches_height')[$store_id];

					$this->load->model('catalog/occolorswatches');

					$images = $this->model_catalog_product->getProductImages($result['product_id']);

					$is_swatches_option = false;

					foreach ($images as $img) {
						if ($img['product_option_value_id']) {
							$image_option_id = $this->model_catalog_occolorswatches->getOptionIdByProductOptionValueId($img['product_option_value_id']);

							if ($image_option_id == $this->config->get('module_octhemeoption_swatches_option')[$store_id]) {
								$is_swatches_option = true;

								$swatches_images[] = array(
									'product_option_value_id' => $img['product_option_value_id'],
									'image' => $this->model_tool_image->resize($img['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'))
								);
							}
						}
					}

					if ($is_swatches_option) {
						foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
							if ($option['option_id'] == $this->config->get('module_octhemeoption_swatches_option')[$store_id]) {
								$product_option_value_data = array();

								foreach ($option['product_option_value'] as $option_value) {
									if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
										$product_option_value_data[] = array(
											'product_option_value_id' => $option_value['product_option_value_id'],
											'option_value_id' => $option_value['option_value_id'],
											'name' => $option_value['name'],
											'image' => $this->model_tool_image->resize($option_value['image'], $data['icon_swatches_width'], $data['icon_swatches_height']),
										);
									}
								}

								$options[] = array(
									'product_option_id' => $option['product_option_id'],
									'product_option_value' => $product_option_value_data,
									'option_id' => $option['option_id'],
									'name' => $option['name'],
									'type' => $option['type'],
									'value' => $option['value'],
								);
							}
						}
					}
				}
				$model = $result['model'];
				$data['products'][] = array(
					'options' => $options,
					'model' => $model,
					'swatches_images' => $swatches_images,
					'rotate_image' => $rotate_image,
					'product_id' => $result['product_id'],
					'manufacturer' => $result['manufacturer'],
					'manufacturers' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id']),
					'thumb' => $image,
					'name' => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
					'price' => $price,
					'special' => $special,
					'rate_special' => $rate_special,
					'tax' => $tax,
					'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating' => $result['rating'],
					'href' => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'])
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			/* Ajax Pagination */
			$ajax_pagination = new Pagination();
			$ajax_pagination->total = $product_total;
			$ajax_pagination->page = $page;
			$ajax_pagination->limit = $limit;
			$ajax_pagination->url = $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . $url . '&page={page}';

			$data['ajax_pagination'] = $ajax_pagination->render();

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $base_url . 'index.php?route=product/category&path=' . $category_id . $url . '&amp;page={page}';

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			if ($limit && ceil($product_total / $limit) > $page) {
				$this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page + 1), true), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$json['result_html'] = $this->load->view('product/ocfilter/category', $data);

			$url = '';

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$json['filter_action'] = str_replace('&amp;', '&', $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . $url);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$json['price_action'] = str_replace('&amp;', '&', $base_url . 'index.php?route=product/ocfilter/category&path=' . $category_id . $url);

			$json['layered_html'] = $this->layer();

		} else {

			$json['result_html'] = "No No No";

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function all()
	{
		$this->load->language('product/category');
		$this->load->language('product/list');

		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/category');
		$this->load->model('catalog/filter');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (!empty($_SERVER['HTTPS'])) {
			// SSL connection
			$base_url = str_replace('http://', 'https://', $this->config->get('config_url'));
		} else {
			$base_url = $this->config->get('config_url');
		}

		$json = array();

		if (isset($this->request->get['price'])) {
			$price_data = $this->request->get['price'];
		} else {
			$price_data = '';
		}

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		if (isset($this->request->get['available'])) {
			$available = (int)$this->request->get['available'];
		} else {
			$available = 0;
		}

		if (isset($this->request->get['special'])) {
			$special_val = (int)$this->request->get['special'];
		} else {
			$special_val = 0;
		}

		if (isset($this->request->get['manufacturer'])) {
			$manufacturer_val = $this->request->get['manufacturer'];
		} else {
			$manufacturer_val = 0;
		}

		if (isset($this->request->get['taste'])) {
			$taste_val = $this->request->get['taste'];
		} else {
			$taste_val = 0;
		}

		if (isset($this->request->get['category'])) {
			$category_val = $this->request->get['category'];
		} else {
			$category_val = 0;
		}

		if (isset($this->request->get['search'])) {
			$search_val = $this->request->get['search'];
		} else {
			$search_val = '';
		}

		if (isset($this->request->get['price']) && preg_match('#^[0-9]+,[0-9]+$#', $this->request->get['price'])) {
			$price = explode(',', $this->request->get['price']);
			$price_min_val = (int)$price[0];
			$price_max_val = (int)$price[1];

			if ($price_min_val > $price_max_val) {
				$temp = $price_max_val;
				$price_max_val = $price_min_val;
				$price_min_val = $price_max_val;
			}
		} else {
			$price_min_val = null;
			$price_max_val = null;
		}

		$store_id = $this->config->get('config_store_id');
		if (isset($this->config->get('module_octhemeoption_custom_view')[$store_id])) {
			$data['use_custom_view'] = (int)$this->config->get('module_octhemeoption_custom_view')[$store_id];
		} else {
			$data['use_custom_view'] = 0;
		}

		if (isset($this->config->get('module_octhemeoption_category_view')[$store_id])) {
			$data['category_view'] = $this->config->get('module_octhemeoption_category_view')[$store_id];
		} else {
			$data['category_view'] = false;
		}

		if (isset($this->config->get('module_octhemeoption_category_view')[$store_id])) {
			$data['grid_columns'] = $this->config->get('module_octhemeoption_grid_columns')[$store_id];
		} else {
			$data['grid_columns'] = false;
		}

		if (isset($this->config->get('module_octhemeoption_use_layered')[$store_id])) {
			$data['use_layered'] = (int)$this->config->get('module_octhemeoption_use_layered')[$store_id];
		} else {
			$data['use_layered'] = 0;
		}

		if (isset($this->config->get('module_octhemeoption_use_cate_quickview')[$store_id])) {
			$data['use_quickview'] = (int)$this->config->get('module_octhemeoption_use_cate_quickview')[$store_id];
		} else {
			$data['use_quickview'] = 0;
		}

		if (isset($this->config->get('module_octhemeoption_image_effect')[$store_id])) {
			$data['image_effect'] = $this->config->get('module_octhemeoption_image_effect')[$store_id];
		} else {
			$data['image_effect'] = false;
		}

		$data['ajax_sorts'] = array();

		$data['ajax_limits'] = array();

		if ($data['use_layered']) {
			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['available'])) {
				$url .= '&available=' . $this->request->get['available'];
			}

			if (isset($this->request->get['special'])) {
				$url .= '&special=' . $this->request->get['special'];
			}

			if (isset($this->request->get['manufacturer'])) {
				$url .= '&manufacturer=' . $this->request->get['manufacturer'];
			}

			if (isset($this->request->get['category'])) {
				$url .= '&category=' . $this->request->get['category'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['taste'])) {
				$url .= '&taste=' . $this->request->get['taste'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			$data['ajax_sorts'][] = array(
				'text' => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . '&sort=p.sort_order&order=ASC' . $url
			);

			$data['ajax_sorts'][] = array(
				'text' => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . '&sort=pd.name&order=ASC' . $url
			);

			$data['ajax_sorts'][] = array(
				'text' => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . '&sort=pd.name&order=DESC' . $url
			);

			$data['ajax_sorts'][] = array(
				'text' => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . '&sort=p.price&order=ASC' . $url
			);

			$data['ajax_sorts'][] = array(
				'text' => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . '&sort=p.price&order=DESC' . $url
			);

			/*if ($this->config->get('config_review_status')) {
				$data['ajax_sorts'][] = array(
					'text' => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href' => $base_url . 'index.php?route=product/ocfilter/all' . '&sort=rating&order=DESC' . $url
				);

				$data['ajax_sorts'][] = array(
					'text' => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href' => $base_url . 'index.php?route=product/ocfilter/all' . '&sort=rating&order=ASC' . $url
				);
			}*/

			/*$data['ajax_sorts'][] = array(
				'text' => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . '&sort=p.model&order=ASC' . $url
			);

			$data['ajax_sorts'][] = array(
				'text' => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . '&sort=p.model&order=DESC' . $url
			);*/

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['available'])) {
				$url .= '&available=' . $this->request->get['available'];
			}

			if (isset($this->request->get['special'])) {
				$url .= '&special=' . $this->request->get['special'];
			}

			if (isset($this->request->get['manufacturer'])) {
				$url .= '&manufacturer=' . $this->request->get['manufacturer'];
			}

			if (isset($this->request->get['category'])) {
				$url .= '&category=' . $this->request->get['category'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['taste'])) {
				$url .= '&taste=' . $this->request->get['taste'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $data['ajax_limits'] = array();

			$limits = array_unique(array($this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

			sort($limits);
           $data['excel']= $base_url . 'index.php?route=product/list/excel_export' . $url ;
			foreach ($limits as $value) {
				$data['ajax_limits'][] = array(
					'text' => $value,
					'value' => $value,
					'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&limit=' . $value
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['special'])) {
				$url .= '&special=' . $this->request->get['special'];
			}

			if (isset($this->request->get['manufacturer'])) {
				$url .= '&manufacturer=' . $this->request->get['manufacturer'];
			}

			if (isset($this->request->get['category'])) {
				$url .= '&category=' . $this->request->get['category'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['taste'])) {
				$url .= '&taste=' . $this->request->get['taste'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			$availables = [
				[
					'text' => $this->language->get('list_not_selected'),
					'value' => 0,
				],
				[
					'text' => $this->language->get('list_availability_yes'),
					'value' => 1,
				],
				[
					'text' => $this->language->get('list_availability_no'),
					'value' => 2,
				],
			];

			foreach ($availables as $item) {
				$data['ajax_availables'][] = array(
					'text' => $item['text'],
					'value' => $item['value'],
					'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&available=' . $item['value'],
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['available'])) {
				$url .= '&available=' . $this->request->get['available'];
			}

			if (isset($this->request->get['manufacturer'])) {
				$url .= '&manufacturer=' . $this->request->get['manufacturer'];
			}

			if (isset($this->request->get['category'])) {
				$url .= '&category=' . $this->request->get['category'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			$tastes = $this->model_catalog_filter->getFilters();
			$data['ajax_tastes'] = array();

			$data['ajax_tastes'][] = array(
				'value' => 0,
				'text' => $this->language->get('list_not_selected'),
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&taste=0',
			);

			foreach ($tastes as $item) {
				$data['ajax_tastes'][] = array(
					'value' => $item['filter_id'],
					'text' => $item['name'],
					'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&taste=' . $item['filter_id'],
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['available'])) {
				$url .= '&available=' . $this->request->get['available'];
			}

			if (isset($this->request->get['manufacturer'])) {
				$url .= '&manufacturer=' . $this->request->get['manufacturer'];
			}

			if (isset($this->request->get['category'])) {
				$url .= '&category=' . $this->request->get['category'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['taste'])) {
				$url .= '&taste=' . $this->request->get['taste'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			$specials = [
				[
					'text' => $this->language->get('list_not_selected'),
					'value' => 0,
				],
				[
					'text' => $this->language->get('list_special_yes'),
					'value' => 1,
				],
				[
					'text' => $this->language->get('list_special_no'),
					'value' => 2,
				],
			];
			foreach ($specials as $item) {
				$data['ajax_specials'][] = array(
					'text' => $item['text'],
					'value' => $item['value'],
					'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&special=' . $item['value'],
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['available'])) {
				$url .= '&available=' . $this->request->get['available'];
			}

			if (isset($this->request->get['category'])) {
				$url .= '&category=' . $this->request->get['category'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['special'])) {
				$url .= '&special=' . $this->request->get['special'];
			}

			if (isset($this->request->get['taste'])) {
				$url .= '&taste=' . $this->request->get['taste'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
			$data['ajax_manufacturers'] = array();

			$data['ajax_manufacturers'][] = array(
				'value' => 0,
				'text' => $this->language->get('list_not_selected'),
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&manufacturer=0',
			);

			$data['ajax_zero_out_href'] = $base_url . 'index.php?route=product/ocfilter/all';

			foreach ($manufacturers as $item) {
				$data['ajax_manufacturers'][] = array(
					'value' => $item['manufacturer_id'],
					'text' => $item['name'],
					'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&manufacturer=' . $item['manufacturer_id'],
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['available'])) {
				$url .= '&available=' . $this->request->get['available'];
			}

			if (isset($this->request->get['manufacturer'])) {
				$url .= '&manufacturer=' . $this->request->get['manufacturer'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['special'])) {
				$url .= '&special=' . $this->request->get['special'];
			}

			if (isset($this->request->get['taste'])) {
				$url .= '&taste=' . $this->request->get['taste'];
			}

			if (isset($this->request->get['category'])) {
				$url .= '&category=' . $this->request->get['category'];
			}

			$data['price_href'] = $base_url . 'index.php?route=product/ocfilter/all' . $url . '&price=';

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['available'])) {
				$url .= '&available=' . $this->request->get['available'];
			}

			if (isset($this->request->get['manufacturer'])) {
				$url .= '&manufacturer=' . $this->request->get['manufacturer'];
			}

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . $this->request->get['search'];
			}

			if (isset($this->request->get['special'])) {
				$url .= '&special=' . $this->request->get['special'];
			}

			if (isset($this->request->get['taste'])) {
				$url .= '&taste=' . $this->request->get['taste'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			$categories = $this->model_catalog_category->getCategories();
			$data['ajax_categories'] = array();

			$data['ajax_categories'][] = array(
				'value' => 0,
				'text' => $this->language->get('list_not_selected'),
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&category=0',
			);

			foreach ($categories as $item) {
				$data['ajax_categories'][] = array(
					'value' => $item['category_id'],
					'text' => $item['name'],
					'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&category=' . $item['category_id'],
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['available'])) {
				$url .= '&available=' . $this->request->get['available'];
			}

			if (isset($this->request->get['manufacturer'])) {
				$url .= '&manufacturer=' . $this->request->get['manufacturer'];
			}

			if (isset($this->request->get['category'])) {
				$url .= '&category=' . $this->request->get['category'];
			}

			if (isset($this->request->get['special'])) {
				$url .= '&special=' . $this->request->get['special'];
			}

			if (isset($this->request->get['taste'])) {
				$url .= '&taste=' . $this->request->get['taste'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			$data['search_href'] = $base_url . 'index.php?route=product/ocfilter/all' . $url . '&search=';
		}

		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));

		$data['compare'] = $this->url->link('product/compare');

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['price'])) {
			$url .= '&price=' . $this->request->get['price'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		if (isset($this->request->get['special'])) {
			$url .= '&special=' . $this->request->get['special'];
		}

		if (isset($this->request->get['availables'])) {
			$url .= '&availables=' . $this->request->get['availables'];
		}

		if (isset($this->request->get['manufacturer'])) {
			$url .= '&manufacturer=' . $this->request->get['manufacturer'];
		}

		if (isset($this->request->get['category'])) {
			$url .= '&category=' . $this->request->get['category'];
		}

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		if (isset($this->request->get['taste'])) {
			$url .= '&taste=' . $this->request->get['taste'];
		}

		if (isset($this->request->get['price'])) {
			$url .= '&price=' . $this->request->get['price'];
		}

		$filter_data = array(
			'filter_filter' => $filter,
			'sort' => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit,
		);

		if (in_array($available, [1, 2])) {
			$filter_data['filter_available'] = $available;
		}

		if (in_array($special_val, [1, 2])) {
			$filter_data['filter_special'] = $special_val;
		}

		if ($manufacturer_val != 0) {
			$filter_data['filter_manufacturer_id'] = $manufacturer_val;
		}

		if ($taste_val != 0) {
			$filter_data['filter_taste'] = $taste_val;
		}

		if ($category_val != 0) {
			$filter_data['filter_category_id'] = $category_val;
		}

		if (!empty($search_val)) {
			$filter_data['filter_name'] = $search_val;
		}

		if (!is_null($price_min_val) && !is_null($price_max_val)) {
			$filter_data['filter_price'] = array(
				'min_price' => $price_min_val,
				'max_price' => $price_max_val,
			);
		}

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}

			$discount = (float)$this->customer->getDiscount();
			if ($discount > 0) {
				if ($result['special']) {
					$discount_price = $result['special'] - $result['special'] * $discount / 100;
					if ($discount_price < 0)
						$discount_price = 0;
					$discount_price = $this->tax->calculate($discount_price, $result['tax_class_id'], $this->config->get('config_tax'));
					$discount_price = $this->currency->format($discount_price, $this->session->data['currency']);
				} else {
					$discount_price = $result['price'] - $result['price'] * $discount / 100;
					if ($discount_price < 0)
						$discount_price = 0;
					$discount_price = $this->tax->calculate($discount_price, $result['tax_class_id'], $this->config->get('config_tax'));
					$discount_price = $this->currency->format($discount_price, $this->session->data['currency']);
				}
			} else {
				$discount_price = false;
			}

			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$rate_special = round(100 - ((float)$result['special'] / $result['price'] * 100));
			} else {
				$special = false;
				$rate_special = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}

			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

			if ($data['image_effect'] == 'rotator') {
				$this->load->model('catalog/ocproductrotator');

				$product_rotator_image = $this->model_catalog_ocproductrotator->getProductRotatorImage($result['product_id']);

				if ($product_rotator_image) {
					$rotate_image = $this->model_tool_image->resize($product_rotator_image, $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
				} else {
					$rotate_image = false;
				}
			} else {
				$rotate_image = false;
			}

			$swatches_images = array();

			$options = array();

			if ($data['image_effect'] == 'swatches') {
				$data['icon_swatches_width'] = $this->config->get('module_octhemeoption_cate_swatches_width')[$store_id];
				$data['icon_swatches_height'] = $this->config->get('module_octhemeoption_cate_swatches_height')[$store_id];

				$this->load->model('catalog/occolorswatches');

				$images = $this->model_catalog_product->getProductImages($result['product_id']);

				$is_swatches_option = false;

				foreach ($images as $img) {
					if ($img['product_option_value_id']) {
						$image_option_id = $this->model_catalog_occolorswatches->getOptionIdByProductOptionValueId($img['product_option_value_id']);

						if ($image_option_id == $this->config->get('module_octhemeoption_swatches_option')[$store_id]) {
							$is_swatches_option = true;

							$swatches_images[] = array(
								'product_option_value_id' => $img['product_option_value_id'],
								'image' => $this->model_tool_image->resize($img['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'))
							);
						}
					}
				}

				if ($is_swatches_option) {
					foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
						if ($option['option_id'] == $this->config->get('module_octhemeoption_swatches_option')[$store_id]) {
							$product_option_value_data = array();

							foreach ($option['product_option_value'] as $option_value) {
								if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
									$product_option_value_data[] = array(
										'product_option_value_id' => $option_value['product_option_value_id'],
										'option_value_id' => $option_value['option_value_id'],
										'name' => $option_value['name'],
										'image' => $this->model_tool_image->resize($option_value['image'], $data['icon_swatches_width'], $data['icon_swatches_height']),
									);
								}
							}

							$options[] = array(
								'product_option_id' => $option['product_option_id'],
								'product_option_value' => $product_option_value_data,
								'option_id' => $option['option_id'],
								'name' => $option['name'],
								'type' => $option['type'],
								'value' => $option['value'],
							);
						}
					}
				}
			}
			$model = $result['model'];

			$categories_result = $this->model_catalog_product->getCategories($result['product_id']);
			$categories_product = array();

			foreach ($categories_result as $categories_result_item) {
				$category_temp = $this->model_catalog_category->getCategory($categories_result_item['category_id']);

				if (!empty($category_temp)) {
					$categories_product[] = array(
						'name' => $category_temp['name'],
						'href' => $this->url->link('product/list', 'category=' . $category_temp['category_id']),
					);
				}
			}

			$data['products'][] = array(
				'categories' => $categories_product,
				'options' => $options,
				'model' => $model,
				'swatches_images' => $swatches_images,
				'rotate_image' => $rotate_image,
				'product_id' => $result['product_id'],
				'manufacturer' => $result['manufacturer'],
				'manufacturers' => $this->url->link('product/list', 'manufacturer=' . $result['manufacturer_id']),
				'thumb' => $image,
				'name' => $result['name'],
				'quantity' => $result['quantity'],
				'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
				'price' => $price,
				'special' => $special,
				'discount_price' => $discount_price,
				'rate_special' => $rate_special,
				'tax' => $tax,
				'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
				'rating' => $result['rating'],
				'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'])
			);
		}

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		if (isset($this->request->get['price'])) {
			$url .= '&price=' . $this->request->get['price'];
		}

		if (isset($this->request->get['availables'])) {
			$url .= '&availables=' . $this->request->get['availables'];
		}

		if (isset($this->request->get['special'])) {
			$url .= '&special=' . $this->request->get['special'];
		}

		if (isset($this->request->get['manufacturer'])) {
			$url .= '&manufacturer=' . $this->request->get['manufacturer'];
		}

		if (isset($this->request->get['category'])) {
			$url .= '&category=' . $this->request->get['category'];
		}

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		if (isset($this->request->get['taste'])) {
			$url .= '&taste=' . $this->request->get['taste'];
		}

		if (isset($this->request->get['price'])) {
			$url .= '&price=' . $this->request->get['price'];
		}

		/* Ajax Pagination */
		$ajax_pagination = new Pagination();
		$ajax_pagination->total = $product_total;
		$ajax_pagination->page = $page;
		$ajax_pagination->limit = $limit;
		$ajax_pagination->url = $base_url . 'index.php?route=product/ocfilter/all' . $url . '&page={page}';

		$data['ajax_pagination'] = $ajax_pagination->render();

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $base_url . 'index.php?route=product/list' . $url . '&amp;page={page}';

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		if ($limit && ceil($product_total / $limit) > $page) {
			$this->document->addLink($this->url->link('product/list', 'page=' . ($page + 1), true), 'next');
		}

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;
		$data['available'] = $available;
		$data['special'] = $special_val;
		$data['manufacturer'] = $manufacturer_val;
		$data['category'] = $category_val;
		$data['search'] = $search_val;
		$data['taste'] = $taste_val;

		$data['list_search'] = $this->language->get('list_search');
		$data['list_manufacturer'] = $this->language->get('list_manufacturer');
		$data['list_categories'] = $this->language->get('list_categories');
		$data['list_taste'] = $this->language->get('list_taste');
		$data['list_stock'] = $this->language->get('list_stock');
		$data['list_availability'] = $this->language->get('list_availability');
		$data['list_price'] = $this->language->get('list_price');
		$data['list_not_selected'] = $this->language->get('list_not_selected');

		$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
		$data['manufacturers'] = array();
		foreach ($manufacturers as $manufacturer) {
			$data['manufacturers'][] = array(
				'value' => $manufacturer['manufacturer_id'],
				'text' => $manufacturer['name'],
			);
		}

		$categories = $this->model_catalog_category->getCategories();
		$data['categories'] = array();
		foreach ($categories as $category) {
			$data['categories'][] = array(
				'value' => $category['category_id'],
				'text' => $category['name'],
			);
		}

		$min_price = 0;  // Set the large number
		$max_price = 1;

		unset($filter_data['filter_price']);

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if ($result['special']) {
				$price = (float)$result['special'];
			} else {
				$price = (float)$result['price'];
			}

			if ($price < $min_price) {
				$min_price = $price;
			}

			if ($price > $max_price) {
				$max_price = $price;
			}
		}

		$rate = (float)$this->currency->getValue($this->session->data['currency']);

		$data['min_price'] = ceil($min_price * $rate);
		$data['max_price'] = round($max_price * $rate);

		if (!is_null($price_min_val) && !is_null($price_max_val)) {
			$data['start_price'] = $price_min_val;
			$data['end_price'] = $price_max_val;
		} else {
			$data['start_price'] = $data['min_price'];
			$data['end_price'] = $data['max_price'];
		}

		$json['result_html'] = $this->load->view('product/ocfilter/list', $data);

		$url = '';

		if (isset($this->request->get['price'])) {
			$url .= '&price=' . $this->request->get['price'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		if (isset($this->request->get['availables'])) {
			$url .= '&availables=' . $this->request->get['availables'];
		}

		if (isset($this->request->get['special'])) {
			$url .= '&special=' . $this->request->get['special'];
		}

		if (isset($this->request->get['manufacturer'])) {
			$url .= '&manufacturer=' . $this->request->get['manufacturer'];
		}

		if (isset($this->request->get['category'])) {
			$url .= '&category=' . $this->request->get['category'];
		}

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		if (isset($this->request->get['taste'])) {
			$url .= '&taste=' . $this->request->get['taste'];
		}

		if (isset($this->request->get['price'])) {
			$url .= '&price=' . $this->request->get['price'];
		}

		$json['filter_action'] = str_replace('&amp;', '&', $base_url . 'index.php?route=product/ocfilter/all' . $url);

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		if (isset($this->request->get['availables'])) {
			$url .= '&availables=' . $this->request->get['availables'];
		}

		if (isset($this->request->get['special'])) {
			$url .= '&special=' . $this->request->get['special'];
		}

		if (isset($this->request->get['manufacturer'])) {
			$url .= '&manufacturer=' . $this->request->get['manufacturer'];
		}

		if (isset($this->request->get['category'])) {
			$url .= '&category=' . $this->request->get['category'];
		}

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		if (isset($this->request->get['taste'])) {
			$url .= '&taste=' . $this->request->get['taste'];
		}

		if (isset($this->request->get['price'])) {
			$url .= '&price=' . $this->request->get['price'];
		}

		$json['price_action'] = str_replace('&amp;', '&', $base_url . 'index.php?route=product/ocfilter/all' . $url);

		// $json['layered_html'] = $this->layer();


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}