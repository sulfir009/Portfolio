<?php
ini_set("display_errors",1);
error_reporting(E_ALL);

define('ADMIN_DIR', dirname(__FILE__) . '/../admin/');

// Config file
if ( file_exists(ADMIN_DIR . 'config.php') ) {
    require_once (ADMIN_DIR . 'config.php');
} else {
    echo 'ERROR: cli cannot access to config.php' . PHP_EOL;
    die();
}

if (!isset($_SERVER['SERVER_PORT'])) {
    $_SERVER['SERVER_PORT'] = getenv('SERVER_PORT');
}

// Startup
require_once (DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

$db->query("SET SESSION wait_timeout = 86400");

// Settings
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0'");

foreach ($query->rows as $setting) {
    if (!$setting['serialized']) {
        $config->set($setting['key'], $setting['value']);
    } else {
        $config->set($setting['key'], json_decode($setting['value'], true));
    }
}

// Url
$url = new Url(HTTP_SERVER, $config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER);
$registry->set('url', $url);

// log File
$log = new Log(date("Y-m-d") . '_update.log');
$registry->set('log', $log);

// Request
$request = new Request();
$registry->set('request', $request);

// Response
$response = new Response();
$registry->set('response', $response);

// Cache
$registry->set('cache', new Cache('file'));

// Language
$languages = array();

$query = $db->query("SELECT * FROM `" . DB_PREFIX . "language`");

foreach ( $query->rows as $result ) {
    $languages[$result['code']] = $result;
}

$config->set('config_language_id', $languages[$config->get('config_admin_language')]['language_id']);

// Language
$language = new Language($languages[$config->get('config_admin_language')]['directory']);
$language->load($languages[$config->get('config_admin_language')]['directory']);
$registry->set('language', $language);

// Default Store
$config->set('config_store_id', 0);

// Event
$event = new Event($registry);
$registry->set('event', $event);

$query = $db->query("SELECT * FROM " . DB_PREFIX . "event");

foreach ( $query->rows as $result ) {
    $event->register($result['trigger'], new Action($result['action']));
}

// Front
$controller = new Front($registry);

// Action
$action = new Action('extension/module/open_specials/index_cli');

// Dispatch
$controller->dispatch($action, new Action('error/not_found'));

// Output
$response->output();
