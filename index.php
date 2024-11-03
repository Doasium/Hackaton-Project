<?php

// Yapılandırma dosyasının yolunu doğru belirleyin
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';

// Autoload dosyasını dahil et
require_once AUTOLOAD_PATH;

// Router ve Controller sınıflarını dahil et
use App\Core\Router;
use App\Config\App;

// Router nesnesini oluştur
$router = new Router();

// Uygulama yapılandırmasını kontrol et
if (App::globalMaintenanceMode) {
    $router->enableMaintenanceMode();
} else {
    $router->disableMaintenanceMode();
}

// Routing yapılandırmasını yükle
require_once ROOT_DIR . '/src/Config/routes.php';

// İstekleri yönlendir
$requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// URL'yi yönlendirin
$router->handleRequest($requestUrl, $requestMethod);

