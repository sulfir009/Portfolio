<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/admin/');
define('HTTP_CATALOG', 'http://localhost/');

// HTTPS
define('HTTPS_SERVER', 'https://localhost/admin/');
define('HTTPS_CATALOG', 'https://localhost/');


// DIR
define('DIR_APPLICATION', 'C:/OSPanel/domains/localhost/admin/');
define('DIR_SYSTEM', 'C:/OSPanel/domains/localhost/system/');
define('DIR_IMAGE', 'C:/OSPanel/domains/localhost/image/');
//define('DIR_STORAGE', '/storage/');
define('DIR_STORAGE', DIR_SYSTEM . '/storage/');
define('DIR_CATALOG', 'C:/OSPanel/domains/localhost/catalog/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'atleti00_db');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');

// OpenCart API
define('OPENCART_SERVER', 'https://www.opencart.com/');
