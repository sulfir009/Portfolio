<?php
// Heading
$_['heading_title'] = 'Експорт / Імпорт';

// Text
$_['text_success'] = 'Вітаємо: Ви успішно іпортували ваші дані!';
$_['text_success_settings'] = 'Вітаємо: Ви успішно зберегли налаштування модуля Експорт/Імпорт!';
$_['text_export_type_category'] = 'Категорії (у тому числі описи категорій та фільтри)';
$_['text_export_type_category_old'] = 'Категорії';
$_['text_export_type_product'] = 'Товари (у тому числі опис товарів, опції, акції, знижки, бонусні бали, атрибути та фільтри)';
$_['text_export_type_product_old'] = 'Товари (включаючи дані товару: опції, акції, знижки, бонусні бали та атрибути)';
$_['text_export_type_option'] = 'Опції';
$_['text_export_type_attribute'] = 'Атрибути';
$_['text_export_type_filter'] = 'Фільтри';
$_['text_export_type_customer'] = 'Покупці';
$_['text_yes'] = 'Так';
$_['text_no'] = 'Ні';
$_['text_nochange'] = 'Ніякі дані не були змінені.';
$_['text_log_details'] = 'Перевірте \'Система &gt; Інструменти &gt; Журнал помилок більш детально.';
$_['text_log_details_2_0_x'] = 'Перевірте \'Система &gt; Інструменти &gt; Журнал помилок більш детально.';
$_['text_log_details_2_1_x'] = 'Перевірте \'Система &gt; Інструменти &gt; Журнал помилок більш детально.';
$_['text_loading_notifications'] = 'Отримання повідомлень';
$_['text_retry'] = 'Повторити спробу';

// Entry
$_['entry_import'] = 'Імпорт із XLS, XLSX або ODS файлу';
$_['entry_export'] = 'Експорт даних у файл XLSX.';
$_['entry_export_type'] = 'Виберіть, які дані ви хочете експортувати:';
$_['entry_range_type'] = 'Будь ласка, виберіть діапазон даних, який потрібно експортувати:';
$_['entry_category_filter'] = 'Обмежити експорт товарів за категоріями:';
$_['entry_category'] = 'Категорії';
$_['entry_start_id'] = 'Початковий id:';
$_['entry_start_index'] = 'Кількість частин:';
$_['entry_end_id'] = 'Завершальний id:';
$_['entry_end_index'] = 'Номер частини(партії):';
$_['entry_incremental'] = 'Використовувати ступінчастий імпорт';
$_['entry_upload'] = 'Завантажуваний файл';
$_['entry_settings_use_option_id'] = 'Використовувати <em>option_id</em> замість <em>option name</em> у файлах \'Опції товару(ProductOptions)\' та \'Значення опцій товару(ProductOptionValues)\' ';
$_['entry_settings_use_option_value_id'] = 'Використовувати <em>option_value_id</em> замість <em>option_value name</em> у файлі \'Значення опцій товару(ProductOptionValues)\'';
$_['entry_settings_use_attribute_group_id'] = 'Використовувати <em>attribute_group_id</em> замість <em>attribute_group name</em> у файлі \'Атрибут товару(ProductAttributes)\'';
$_['entry_settings_use_attribute_id'] = 'Використовувати <em>attribute_id</em> замість <em>attribute name</em> у файлі \'Атрибут товару(ProductAttributes)\'';
$_['entry_settings_use_filter_group_id'] = 'Використовувати <em>filter_group_id</em> замість <em>filter_group name</em> у файлах \'ProductFilters\' та \'CategoryFilters\'';
$_['entry_settings_use_filter_id'] = 'Використовувати <em>filter_id</em> замість <em>filter name</em> у файлах \'ProductFilters\' та \'CategoryFilters\'';
$_['entry_settings_use_export_cache'] = 'Використовувати phpTemp cache для імпорту великих файлів (повільніший процес імпорту)';
$_['entry_settings_use_import_cache'] = 'Використовувати phpTemp cache для імпорту великих файлів (повільніший процес імпорту)';

// Error
$_['error_permission'] = 'У вас немає прав для внесення змін до модуля Export/Import!';
$_['error_upload'] = 'Файл імпорту, що завантажується, має помилки валідації!';
$_['error_categories_header'] = 'Неприпустимий заголовок у Категорії файлу імпорту';
$_['error_category_filters_header'] = 'Неприпустимий заголовок у Фільтрах Категорії(CategoryFilters) файлу імпорту';
$_['error_products_header'] = 'Неприпустимий заголовок у Товарі(Product) файлу імпорту';
$_['error_additional_images_header'] = 'Неприпустимий заголовок у Додаткових зображеннях(AdditionalImages) товару файлу імпорту';
$_['error_specials_header'] = 'Неприпустимий заголовок в Акціях(Specials) файлу імпорту';
$_['error_discounts_header'] = 'Неприпустимий заголовок у знижках(Discounts) файлу імпорту';
$_['error_rewards_header'] = 'Неприпустимий заголовок у Бонусних Баллах (Rewards) файлу імпорту';
$_['error_product_options_header'] = 'Неприпустимий заголовок в Опціях Товару(ProductOptions) файлу імпорту';
$_['error_product_option_values_header'] = 'Неприпустимий заголовок у значеннях Опцій Товару(ProductOptionValues) файлу імпорту';
$_['error_product_attributes_header'] = 'Неприпустиме заголовок в Атрибутах товару (ProductAttributes) файлу імпорту';
$_['error_product_filters_header'] = 'Неприпустимий заголовок у фільтрах Товарів (ProductFilters) файлу імпорту';
$_['error_options_header'] = 'Неприпустимий заголовок в Опціях файлу імпорту';
$_['error_option_values_header'] = 'Неприпустимий заголовок у значеннях опцій (OptionValues) файлу імпорту';
$_['error_attribute_groups_header'] = 'Неприпустимий заголовок у Групах Атрибутів(AttributeGroups) файлу імпорту';
$_['error_attributes_header'] = 'Неприпустимий заголовок в Атрибутах файлу імпорту';
$_['error_filter_groups_header'] = 'Неприпустимий заголовок у Групах фільтра(FilterGroups) файлу імпорту';
$_['error_filters_header'] = 'Неприпустимий заголовок у Фільтрах(Filters) файлу імпорту';
$_['error_customers_header'] = 'Неприпустимий заголовок у Покупці файлу імпорту';
$_['error_addresses_header'] = 'Неприпустимий заголовок в Адреса (Addresses) файлу імпорту';
$_['error_product_options'] = 'Export/Import: Відсутні товари у файлі імпорту або у списку товарів немає значення Опції Товару(ProductOptions)';
$_['error_product_option_values'] = 'Export/Import: Відсутні товари у файлі імпорту або у списку товарів немає Значення Опції Товару (ProductOptionValues)';
$_['error_product_option_values_2'] = 'Export/Import: Відсутні опції товару у файлі імпорту або в списку товарів немає Значення опцій товару(ProductOptionValues)';
$_['error_product_option_values_3'] = 'Export/Import: У значеннях опцій товарів файлу імпорту очікується наявність Опцій товару цього файлу імпорту';
$_['error_additional_images'] = 'Export/Import: Відсутні товари у файлі імпорту або в списку товарів немає значення для додаткових зображень товару(AdditionalImages)';
$_['error_specials'] = 'Export/Import: Відсутні товари у файлі імпорту або в списку товарів немає Значення для Акцій(Specials)';
$_['error_discounts'] = 'Export/Import: Відсутні товари у файлі імпорту або у списку товарів немає Значення для Знижок(Discounts)';
$_['error_rewards'] = 'Export/Import: Відсутні товари у файлі імпорту або в списку товарів немає значення для Бонусних балів(Rewards)';
$_['error_product_attributes'] = 'Export/Import: Відсутні товари у файлі імпорту або в списку товарів немає значення для атрибутів товару(ProductAttributes)';
$_['error_attributes'] = 'Export/Import: Відсутні Групи атрибутів(AttributeGroups)у файлі імпорту або у списку атрибутів немає значення (AttributeGroups)';
$_['error_attributes_2'] = 'Export/Import: У значенні атрибутів у файлі імпорту також очікуються Групи атрибутів (AttributeGroups) у файлі імпорту';
$_['error_category_filters'] = 'Export/Import: Немає Категорії у файлі імпорту або в списку категорій немає значення для Категорії фільтра (CategoryFilters)';
$_['error_product_filters'] = 'Export/Import: Немає товарів у файлі імпорту або в списку товарів немає Значення для Фільтр товарів (ProductFilters)';
$_['error_filters'] = 'Export/Import: Відсутні Групи фільтрів (FilterGroups) у файлі імпорту або їх немає у списку фільтрів (Filters)';
$_['error_filters_2'] = 'Export/Import: Фільтри(Filters) файлу імпорту також очікуються значення Груп фільтра (FilterGroups)у файлі імпорту';
$_['error_option_values'] = 'Export/Import: Немає Опції(Options)у файлі імпорту або опцій немає у списку Значень опцій(OptionValues)';
$_['error_option_values_2'] = 'Export/Import: Значення опцій (OptionValues) у файлі імпорту також очікуються самі Опції (Options) у файлі імпорту';
$_['error_post_max_size'] = 'Розмір файлу більше, ніж %1 (перевірте налаштування PHP \'post_max_size\')';
$_['error_upload_max_filesize'] = 'Розмір файлу більше, ніж %1 (перевірте налаштування PHP \'upload_max_filesize\')';
$_['error_select_file'] = 'Виберіть файл, клацнувши на \'Import\'';
$_['error_id_no_data'] = 'Не вибрані дані для Початковий id та Завершальний id.';
$_['error_page_no_data'] = 'Більше даних немає.';
$_['error_param_not_number'] = 'Діапазон значень даних має бути цілими числами.';
$_['error_upload_name'] = 'Не вказано файл для завантаження';
$_['error_upload_ext'] = 'Завантажений файл не є одним з \'.xls\', \'.xlsx\' or \'.ods\' файлів, інші типи файлів не підтримуються!';
$_['error_notifications'] = 'Неможливо завантажити повідомлення з MHCCORP.COM.';
$_['error_no_news'] = 'Немає повідомлень';
$_['error_batch_number'] = 'Batch number must be greater than 0';
$_['error_min_item_id'] = 'Початковий id повинен бути більшим за 0';
$_['error_option_name'] = 'Опція \'%1\' вказана кілька разів!<br />';
$_['error_option_name'] .= 'У вкладці Налаштування активуйте значення:<br />';
$_['error_option_name'] .= "Використовувати <em>option_id</em> замість <em>option name</em> у файлах 'ProductOptions' та 'ProductOptionValues'";
$_['error_option_value_name'] = 'Значення опцій \'%1\' is defined multiple times within its option!<br />';
$_['error_option_value_name'] .= 'У вкладці Налаштування активуйте значення:<br />';
$_['error_option_value_name'] .= "Використовувати <em>option_value_id</em> замість <em>option_value name</em> у файлі 'ProductOptionValues'";
$_['error_attribute_group_name'] = 'Групи атрибутів(AttributeGroup) \'%1\' вказані кілька разів!<br />';
$_['error_attribute_group_name'] .= 'У вкладці Налаштування активуйте значення:<br />';
$_['error_attribute_group_name'] .= "Використовувати <em>attribute_group_id</em> замість <em>attribute_group name</em> у файлах 'ProductAttributes'";
$_['error_attribute_name'] = 'Attribute \'%1\' is defined multi times within its attribute group!<br />';
$_['error_attribute_name'] .= 'У вкладці Налаштування активуйте значення:<br />';
$_['error_attribute_name'] .= "Використовувати <em>attribute_id</em> замість <em>attribute name</em> у файлі 'ProductAttributes'";
$_['error_filter_group_name'] = 'Групи фільтрів(FilterGroup) \'%1\' вказані кілька разів!<br />';
$_['error_filter_group_name'] .= 'У вкладці Налаштування активуйте значення:<br />';
$_['error_filter_group_name'] .= "Використовувати <em>filter_group_id</em> замість <em>filter_group name</em> у файлах 'ProductFilters'";
$_['error_filter_name'] = 'Фільтр(Filter) \'%1\' вказаний кілька разів,без вказівки Групи фільтра (filter group)!<br />';
$_['error_filter_name'] .= 'У вкладці Налаштування активуйте значення:<br />';
$_['error_filter_name'] .= "Використовувати <em>filter_id</em> замість <em>filter name</em> у файлі 'ProductFilters'";

$_['error_missing_customer_group'] = 'Export/Import: Немає customer_groups у файлі \'%1\'!';
$_['error_invalid_customer_group'] = 'Export/Import: Невідоме значення customer_group \'%2\' у файлі імпорту \'%1\'!';
$_['error_missing_product_id'] = 'Export/Import: Немає product_ids у файлі \'%1\'!';
$_['error_missing_option_id'] = 'Export/Import: Відсутні option_ids у файлі \'%1\'!';
$_['error_invalid_option_id'] = 'Export/Import: Невідоме значення option_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_missing_option_name'] = 'Export/Import: Відсутні option_names у файлі \'%1\'!';
$_['error_invalid_product_id_option_id'] = 'Export/Import: Option_id \'%3\' не вказується для product_id \'%2\' у файлі \'%4\', але є у файлі імпорту \'%1\' !';
$_['error_missing_option_value_id'] = 'Export/Import: Немає option_value_ids у файлі \'%1\'!';
$_['error_invalid_option_id_option_value_id'] = 'Export/Import: Невідоме значення option_value_id \'%3\' для option_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_missing_option_value_name'] = 'Export/Import: Немає option_value_names у файлі \'%1\'!';
$_['error_invalid_option_id_option_value_name'] = 'Export/Import: Невідоме значення option_value_name \'%3\' для optiion_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_option_name'] = 'Export/Import: Невідоме значення option_name \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_product_id_option_name'] = 'Export/Import: Option_name \'%3\' не вказується для product_id \'%2\' у файлі \'%4\', але є у файлі імпорту \'%1\' !';
$_['error_invalid_option_name_option_value_id'] = 'Export/Import: Невідоме значення option_value_id \'%3\' для option_name \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_option_name_option_value_name'] = 'Export/Import: Невідоме значення option_value_name \'%3\' для option_name \'%2\' у файлі імпорту \'%1\'!';
$_['error_missing_attribute_group_id'] = 'Export/Import: Немає attribute_group_ids у файлі \'%1\'!';
$_['error_invalid_attribute_group_id'] = 'Export/Import: Невідоме значення attribute_group_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_missing_attribute_group_name'] = 'Export/Import: Немає attribute_group_names у файлі \'%1\'!';
$_['error_missing_attribute_id'] = 'Export/Import: Немає attribute_ids у файлі \'%1\'!';
$_['error_invalid_attribute_group_id_attribute_id'] = 'Export/Import: Невідоме значення attribute_id \'%3\' для attribute_group_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_missing_attribute_name'] = 'Export/Import: Немає attribute_names у файлі \'%1\'!';
$_['error_invalid_attribute_group_id_attribute_name'] = 'Export/Import: Невідоме значення attribute_name \'%3\' для optiion_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_attribute_group_name'] = 'Export/Import: Невідоме значення attribute_group_name \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_attribute_group_name_attribute_id'] = 'Export/Import: Невідоме значення attribute_id \'%3\' для attribute_group_name \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_attribute_group_name_attribute_name'] = 'Export/Import: Невідоме значення attribute_name \'%3\' для attribute_group_name \'%2\' у файлі імпорту \'%1\'!';
$_['error_missing_filter_group_id'] = 'Export/Import: Немає filter_group_ids у файлі \'%1\'!';
$_['error_invalid_filter_group_id'] = 'Export/Import: Невідоме значення filter_group_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_missing_filter_group_name'] = 'Export/Import: Немає filter_group_names у файлі \'%1\'!';
$_['error_missing_filter_id'] = 'Export/Import: Немає filter_ids у файлі \'%1\'!';
$_['error_invalid_filter_group_id_filter_id'] = 'Export/Import: Невідоме значення filter_id \'%3\' для filter_group_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_missing_filter_name'] = 'Export/Import: Немає filter_names у файлі \'%1\'!';
$_['error_invalid_filter_group_id_filter_name'] = 'Export/Import: Невідоме значення filter_name \'%3\' для optiion_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_filter_group_name'] = 'Export/Import: Невідоме значення filter_group_name \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_filter_group_name_filter_id'] = 'Export/Import: Невідоме значення filter_id \'%3\' для filter_group_name \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_filter_group_name_filter_name'] = 'Export/Import: Невідоме значення filter_name \'%3\' для filter_group_name \'%2\' у файлі імпорту \'%1\'!';
$_['error_invalid_product_id'] = 'Export/Import: Невірний product_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_duplicate_product_id'] = 'Export/Import: Дублювання product_id \'%2\' у файлі імпорту \'%1\'!';
$_['error_unlisted_product_id'] = 'Export/Import: файл імпорту \'%1\' не може використовувати значення product_id \'%2\' тому що товар відсутній у списку \'Каталог-Товари\'!';
$_['error_filter_not_supported'] = 'Export/Import: Ваша версія Ocstore/Opencart не підтримує вбудований Фільтр!';
$_['error_wrong_order_product_id'] = 'Export/Import: Файл імпорту \'%1\' використовує product_id \'%2\' у неправильному порядку.';
$_['error_missing_category_id'] = 'Export/Import: Відсутня category_ids у файлі імпорту \'%1\'!';
$_['error_invalid_category_id'] = 'Export/Import: Неправильне значення category_id \'%2\', яке використовується у файлі імпорту \'%1\'!';
$_['error_duplicate_category_id'] = 'Export/Import: Повторюваний category_id \'%2\', що використовується у файлі імпорту \'%1\'!';
$_['error_wrong_order_category_id'] = 'Export/Import: Файл імпорту \'%1\' використовує category_id \'%2\' у неправильному порядку.';
$_['error_unlisted_category_id'] = 'Export/Import: Файл імпорту \'%1\' не може використовувати category_id \'%2\' тому, що його немає в списку Файлу імпорту \'Categories\'!';
$_['error_addresses'] = 'Export/Import: Пропущено Покупці(Cutomers ) у файлі імпорту, або Покупці(Cutomers ) у файлі імпорту перебувають у списку перед значенням Адреси(Addresses)!';
$_['error_addresses_2'] = 'Export/Import: Адреси(Addresses) у файлі імпорту очікуються перед значенням Покупці(Customers) у файлі імпорту';
$_['error_invalid_store_id'] = 'Export/Import: Неправильне значення store_id=\'%1\' використовується у файлі імпорту \'%2\'!';
$_['error_missing_customer_id'] = 'Export/Import: Відсутнє значення customer_ids у файлі імпорту \'%1\'!';
$_['error_invalid_customer_id'] = 'Export/Import: Неправильне значення customer_id \'%2\' використовується у файлі імпорту \'%1\'!';
$_['error_duplicate_customer_id'] = 'Export/Import: Повторюваний customer_id \'%2\' використовується у файлі імпорту \'%1\'!';
$_['error_wrong_order_customer_id'] = 'Export/Import: Файл імпорту \'%1\' використовує значення customer_id \'%2\' у неправильному порядку.';
$_['error_unlisted_customer_id'] = 'Export/Import: Файл імпорту \'%1\' не може використовувати значення customer_id \'%2\' тому, що його немає у списку файлу імпорту імпорту \'Customers\'!';
$_['error_missing_country_col'] = 'Export/Import: У файлі імпорту \'%1\' відсутній заголовок \'country\' у колонці!';
$_['error_missing_zone_col'] = 'Export/Import: У файлі імпорту \'%1\' відсутній заголовок \'zone\' у колонці!';
$_['error_undefined_country'] = 'Export/Import: Невизначене значення країна \'%1\' використовується у файлі імпорту \'%2\'!';
$_['error_undefined_zone'] = 'Export/Import: Невизначене значення регіон \'%2\' для країни \'%1\' використовується у файлі імпорту \'%3\'!';
$_['error_incremental_only'] = 'Export/Import: Файл імпорту \'%1\' може бути імпортований лише в покроковому режимі зараз!';

// Tabs
$_['tab_import'] = 'Імпорт';
$_['tab_export'] = 'Експорт';
$_['tab_settings'] = 'Налаштування';

// Button labels
$_['button_import'] = 'Імпорт';
$_['button_export'] = 'Експорт';
$_['button_settings'] = 'Зберегти налаштування';
$_['button_export_id'] = 'За значенням id';
$_['button_export_page'] = 'З розбиттям на частини(партії)';

// Help
$_['help_range_type'] = '(Необов\'язково, залиште порожнім, якщо не потрібно)';
$_['help_category_filter'] = '(Необов\'язково, залиште порожнім, якщо не потрібно)';
$_['help_range_type'] = '(Необов\'язково, залиште порожнім, якщо не потрібно)';
$_['help_incremental_yes'] = '(Тільки оновити та/або додати дані)';
$_['help_incremental_no'] = '(Видалити всі старі дані перед імпортом)';
$_['help_import'] = 'Файл імпорту/експорту може містити категорії, товари, атрибути, опції або фільтри. ';
$_['help_import_old'] = 'Файл імпорту/експорту може містити категорії, товари, атрибути або опції. ';
$_['help_format'] = 'Перед імпортом переконайтеся,що ви завантажуєте формат файлу імпорту, що підтримується модулем!';
?>