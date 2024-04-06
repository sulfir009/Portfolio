<?php

class ControllerProductList extends Controller
{
    public function excel_export(){
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->load->language('product/category');
        $this->load->language('product/list');

        $this->load->model('catalog/manufacturer');
        $this->load->model('catalog/category');
        $this->load->model('catalog/filter');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

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
            $limit = (int)$this->request->get['limit'];
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
            $manufacturer_val = (int)$this->request->get['manufacturer'];
        } else {
            $manufacturer_val = 0;
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

        if (isset($this->request->get['taste'])) {
            $taste_val = (int)$this->request->get['taste'];
        } else {
            $taste_val = 0;
        }

        if (isset($this->request->get['category'])) {
            $category_val = (int)$this->request->get['category'];
        } else {
            $category_val = 0;
        }

        if (isset($this->request->get['search'])) {
            $search_val = $this->request->get['search'];
        } else {
            $search_val = '';
        }
        $data['products'] = array();

        $filter_data = array(
			'filter_name' => isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null,
			'filter_model' => isset($this->request->get['filter_model']) ? $this->request->get['filter_model'] : null,
			'filter_price' => isset($this->request->get['filter_price']) ? $this->request->get['filter_price'] : null,
			'filter_category_id' => isset($this->request->get['category']) ? (int)$this->request->get['category'] : 0,
			'filter_sub_category' => true,
			'filter_manufacturer_id' => isset($this->request->get['manufacturer']) ? (int)$this->request->get['manufacturer'] : 0,
			'filter_barcode' => isset($this->request->get['filter_barcode']) ? $this->request->get['filter_barcode'] : null,
			// Додати інші параметри за потребою
		);
        /*$min_price = $data[]['min_price'];
        $max_price = $data['filter_price']['max_price'];*/

       /* if (in_array($available, [1, 2])) {
            $filter_data['filter_available'] = $available;
        }

        if (in_array($special_val, [1, 2])) {
            $filter_data['filter_special'] = $special_val;
        }

        if ($manufacturer_val != 0) {
            $filter_data['filter_manufacturer_id'] = $manufacturer_val;
        }

        if (!is_null($price_min_val) && !is_null($price_max_val)) {
            $filter_data['filter_price'] = array(
                'min_price' => $price_min_val,
                'max_price' => $price_max_val,
            );
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

*/

        $results = $this->model_catalog_product->getProducts($filter_data);


        $cwd = getcwd();
        chdir( DIR_SYSTEM.'PHPExcel' );
        require_once( 'Classes/PHPExcel.php' );
        chdir( $cwd ); //подключили библиотеку
        $phpexcel = new PHPExcel();

        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/manufacturer'); //подключили нужные для выгрузки модели


        $page = $phpexcel->setActiveSheetIndex(0); //создаем вкладку

        $page->getColumnDimensionByColumn("0")->setWidth(40);
        $page->getColumnDimensionByColumn("1")->setWidth(70);
        $page->getColumnDimensionByColumn("2")->setWidth(20);
        $page->getColumnDimensionByColumn("3")->setWidth(20);
        $page->getColumnDimensionByColumn("4")->setWidth(8);
        $page->getColumnDimensionByColumn("5")->setWidth(6);
        $page->getColumnDimensionByColumn("6")->setWidth(12); //задаем ширину столбцов

        $page->setCellValue("A1", "Название");
        $page->setCellValue("B1", "Категория");
        $page->setCellValue("C1", "Производитель");
        $page->setCellValue("D1", "Цена");
        $page->setCellValue("E1", "Наличие");
		$page->setCellValue("F1", "Артикул");
		$page->setCellValue("G1", "Штрихкод");


        $i=2;
        foreach($results as $product){

            if($product['quantity']<=0 || $product['status']==0){
                continue;
            }

            $categories_result = $this->model_catalog_product->getCategories($product['product_id']);

            $categories="";
            foreach($categories_result as $cat){
                $category_temp = $this->model_catalog_category->getCategory($cat['category_id']);

                $categories.=$category_temp['name']." ";

            }
            $discount = (float)$this->customer->getDiscount();
            if ($discount > 0) {
                if ($product['special']) {
                    $discount_price = $product['special'] - $product['special'] * $discount / 100;
                    if ($discount_price < 0)
                        $discount_price = 0;
                    $discount_price = $this->tax->calculate($discount_price, $product['tax_class_id'], $this->config->get('config_tax'));
                    $discount_price = $this->currency->format($discount_price, $this->session->data['currency']);
                } else {
                    $discount_price = $product['price'] - $product['price'] * $discount / 100;
                    if ($discount_price < 0)
                        $discount_price = 0;
                    $discount_price = $this->tax->calculate($discount_price, $product['tax_class_id'], $this->config->get('config_tax'));
                    $discount_price = $this->currency->format($discount_price, $this->session->data['currency']);
                }
            } else {
                $discount_price = false;
            }

            $page->setCellValue("A$i", $product['name']);
            $page->setCellValue("B$i", $categories);
            $page->setCellValue("C$i", $product['manufacturer']);
                   $page->setCellValue("D$i", $discount_price?$discount_price:$product['price']);
            $page->setCellValue("E$i", $product['quantity']);
						$page->setCellValue("F$i", $product['model']); // Артикул продукту
			$page->setCellValue("G$i", $product['barcode']); // Штрихкод продукту
            $i++;
        }

        $page->setTitle("Товары");

        $filename = 'products.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(false);
        $objWriter->save('php://output'); //отдаем файл в браузер по ссылке
    }
	public function index()
	{
		if (!$this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		$this->load->language('product/category');
		$this->load->language('product/list');

		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/category');
		$this->load->model('catalog/filter');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

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
			$limit = (int)$this->request->get['limit'];
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
			$manufacturer_val = (int)$this->request->get['manufacturer'];
		} else {
			$manufacturer_val = 0;
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

		if (isset($this->request->get['taste'])) {
			$taste_val = (int)$this->request->get['taste'];
		} else {
			$taste_val = 0;
		}

		if (isset($this->request->get['category'])) {
			$category_val = (int)$this->request->get['category'];
		} else {
			$category_val = 0;
		}

		if (isset($this->request->get['search'])) {
			$search_val = $this->request->get['search'];
		} else {
			$search_val = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['list_search'] = $this->language->get('list_search');
		$data['list_manufacturer'] = $this->language->get('list_manufacturer');
		$data['list_categories'] = $this->language->get('list_categories');
		$data['list_taste'] = $this->language->get('list_taste');
		$data['list_stock'] = $this->language->get('list_stock');
		$data['list_availability'] = $this->language->get('list_availability');
		$data['list_price'] = $this->language->get('list_price');
		$data['list_not_selected'] = $this->language->get('list_not_selected');
		$data['list_zero_out'] = $this->language->get('list_zero_out');

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		if (isset($this->request->get['available'])) {
			$url .= '&available=' . $this->request->get['available'];
		}

		if (isset($this->request->get['special'])) {
			$url .= '&special=' . $this->request->get['special'];
		}

		if (isset($this->request->get['category'])) {
			$url .= '&category=' . $this->request->get['category'];
		}

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
		$data['manufacturers'] = array();
		foreach ($manufacturers as $item) {
			$data['manufacturers'][] = array(
				'value' => $item['manufacturer_id'],
				'text' => $item['name'],
				'href' => $this->url->link('product/ocfilter/all', '&manufacturer=' . $item['manufacturer_id'] . $url),
			);
		}

		$data['zero_out_href'] = $this->url->link('product/ocfilter/all');

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['manufacturer'])) {
			$url .= '&manufacturer=' . $this->request->get['manufacturer'];
		}

		if (isset($this->request->get['available'])) {
			$url .= '&available=' . $this->request->get['available'];
		}

		if (isset($this->request->get['special'])) {
			$url .= '&special=' . $this->request->get['special'];
		}

		if (isset($this->request->get['category'])) {
			$url .= '&category=' . $this->request->get['category'];
		}

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		$tastes = $this->model_catalog_filter->getFilters();
		$data['tastes'] = array();
		foreach ($tastes as $item) {
			$data['tastes'][] = array(
				'value' => $item['filter_id'],
				'text' => $item['name'],
				'href' => $this->url->link('product/ocfilter/all', '&taste=' . $item['filter_id'] . $url),
			);
		}

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
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

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . $this->request->get['search'];
		}

		$categories = $this->model_catalog_category->getCategories();
		$data['categories'] = array();
		foreach ($categories as $item) {
			$data['categories'][] = array(
				'value' => $item['category_id'],
				'text' => $item['name'],
				'href' => $this->url->link('product/ocfilter/all', '&category=' . $item['category_id'] . $url),
			);
		}

		$this->document->setTitle($this->language->get('list_title'));
		$this->document->setDescription($this->language->get('list_meta_description'));
		$this->document->setKeywords($this->language->get('list_meta_keyword'));

		$data['heading_title'] = $this->language->get('list_title');

		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));


		if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/octhemecategory/category.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/octhemecategory/category.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/octhemecategory/category.css');
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

		if ($data['image_effect'] == 'swatches') {
			$this->document->addScript('catalog/view/javascript/occolorswatches/swatches.js');
		}

		if ($data['use_custom_view']) {
			$this->document->addScript('catalog/view/javascript/occategorygrid/grid.js');
		}

		if (!empty($_SERVER['HTTPS'])) {
			// SSL connection
			$base_url = str_replace('http://', 'https://', $this->config->get('config_url'));
		} else {
			$base_url = $this->config->get('config_url');
		}

		$data['ajax_sorts'] = array();

		$data['ajax_limits'] = array();

		$url = '';

		if ($data['use_layered']) {
			if (file_exists('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/octhemecategory/filter.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_' . $this->config->get('config_theme') . '_directory') . '/stylesheet/octhemecategory/filter.css');
			} else {
				$this->document->addStyle('catalog/view/theme/default/stylesheet/octhemecategory/filter.css');
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

			if (isset($this->request->get['taste'])) {
				$url .= '&taste=' . $this->request->get['taste'];
			}

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['search_href'] = $base_url . 'index.php?route=product/ocfilter/all' . $url . '&search=';

			$this->document->addScript('catalog/view/javascript/occategorygrid/filter.js');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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

			$data['excel']=$base_url . 'index.php?route=product/list/excel_export' . '&sort=p.sort_order&order=ASC' . $url;


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

			$data['ajax_limits'] = array();

			$limits = array_unique(array($this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

			sort($limits);
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

			foreach ($limits as $value) {
				$data['ajax_limits'][] = array(
					'text' => $value,
					'value' => $value,
					'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&limit=' . $value
				);
			}

			$data['ajax_loader'] = $base_url . 'image/' . $this->config->get('module_octhemeoption_loader_img');
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

			$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
			$data['ajax_manufacturers'] = array();

			$data['ajax_manufacturers'][] = array(
				'value' => 0,
				'text' => $this->language->get('list_not_selected'),
				'href' => $base_url . 'index.php?route=product/ocfilter/all' . $url . '&manufacturer=0',
			);

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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$data['price_href'] = $base_url . 'index.php?route=product/ocfilter/all' . $url . '&price=';

			$data['ajax_zero_out_href'] = $base_url . 'index.php?route=product/ocfilter/all';

			$tastes = $this->model_catalog_filter->getFilters();
			$data['ajax_tastes'] = array();

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

			if (isset($this->request->get['price'])) {
				$url .= '&price=' . $this->request->get['price'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
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

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
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
		} else {
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

			$data['search_href'] = $this->url->link('product/list', $url . '&search=');
		}

		/*echo '<pre>';
		var_dump($data['ajax_availables']);
		echo '</pre>';
		die;*/


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

		$data['products'] = array();

		$filter_data = array(
			'filter_filter' => $filter,
			'sort' => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit,
		);
		/*$min_price = $data[]['min_price'];
		$max_price = $data['filter_price']['max_price'];*/

		if (in_array($available, [1, 2])) {
			$filter_data['filter_available'] = $available;
		}

		if (in_array($special_val, [1, 2])) {
			$filter_data['filter_special'] = $special_val;
		}

		if ($manufacturer_val != 0) {
			$filter_data['filter_manufacturer_id'] = $manufacturer_val;
		}

		if (!is_null($price_min_val) && !is_null($price_max_val)) {
			$filter_data['filter_price'] = array(
				'min_price' => $price_min_val,
				'max_price' => $price_max_val,
			);
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
			} else {
				$special = false;
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
				'swatches_images' => $swatches_images,
				'rotate_image' => $rotate_image,
				'product_id' => $result['product_id'],
				'barcode' => $result['barcode'],
				'model' => $result['model'],
				'thumb' => $image,
				'manufacturer' => $result['manufacturer'],
				'manufacturers' => $this->url->link('product/list', 'manufacturer=' . $result['manufacturer_id']),
				'name' => $result['name'],
				'quantity' => $result['quantity'],
				'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
				'price' => $price,
				'special' => $special,
				'discount_price' => $discount_price,
				'tax' => $tax,
				'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
				'rating' => $result['rating'],
				'href' => $this->url->link('product/product', '&product_id=' . $result['product_id'] . $url),
			);
		}

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
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

		$data['sorts'] = array();

		$data['sorts'][] = array(
			'text' => $this->language->get('text_default'),
			'value' => 'p.sort_order-ASC',
			'href' => $this->url->link('product/list', '&sort=p.sort_order&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_name_asc'),
			'value' => 'pd.name-ASC',
			'href' => $this->url->link('product/list', '&sort=pd.name&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_name_desc'),
			'value' => 'pd.name-DESC',
			'href' => $this->url->link('product/list', '&sort=pd.name&order=DESC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_price_asc'),
			'value' => 'p.price-ASC',
			'href' => $this->url->link('product/list', '&sort=p.price&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_price_desc'),
			'value' => 'p.price-DESC',
			'href' => $this->url->link('product/list', '&sort=p.price&order=DESC' . $url)
		);

		/*if ($this->config->get('config_review_status')) {
			$data['sorts'][] = array(
				'text' => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href' => $this->url->link('product/list', '&sort=rating&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text' => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href' => $this->url->link('product/list', '&sort=rating&order=ASC' . $url)
			);
		}*/

		/*$data['sorts'][] = array(
			'text' => $this->language->get('text_model_asc'),
			'value' => 'p.model-ASC',
			'href' => $this->url->link('product/list', '&sort=p.model&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_model_desc'),
			'value' => 'p.model-DESC',
			'href' => $this->url->link('product/list', '&sort=p.model&order=DESC' . $url)
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

		$data['limits'] = array();

		$limits = array_unique(array($this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

		sort($limits);

		foreach ($limits as $value) {
			$data['limits'][] = array(
				'text' => $value,
				'value' => $value,
				'href' => $this->url->link('product/list', $url . '&limit=' . $value)
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
			$data['availables'][] = array(
				'text' => $item['text'],
				'value' => $item['value'],
				'href' => $this->url->link('product/list', $url . '&available=' . $item['value'])
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

		if (isset($this->request->get['available'])) {
			$url .= '&available=' . $this->request->get['available'];
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
			$data['specials'][] = array(
				'text' => $item['text'],
				'value' => $item['value'],
				'href' => $this->url->link('product/list', $url . '&special=' . $item['value'])

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

		if ($data['use_layered']) {
			$ajax_pagination = new Pagination();
			$ajax_pagination->total = $product_total;
			$ajax_pagination->page = $page;
			$ajax_pagination->limit = $limit;
			$ajax_pagination->url = $base_url . 'index.php?route=product/ocfilter/all' . $url . '&page={page}';

			$data['ajax_pagination'] = $ajax_pagination->render();
		} else {
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/list', $url . '&page={page}');


			$data['pagination'] = $pagination->render();
		}


		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
		if ($page == 1) {
			$this->document->addLink($this->url->link('product/link'), 'canonical');
		} else {
			$this->document->addLink($this->url->link('product/link', '&page=' . $page), 'canonical');
		}

		if ($page > 1) {
			$this->document->addLink($this->url->link('product/link', (($page - 2) ? '&page=' . ($page - 1) : '')), 'prev');
		}

		if ($limit && ceil($product_total / $limit) > $page) {
			$this->document->addLink($this->url->link('product/link', '&page=' . ($page + 1)), 'next');
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
		$data['discout_value'] = (float)$this->customer->getDiscount();

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

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('product/list', $data));
	}
}
