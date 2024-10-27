<?php

// Yapılandırma dosyasının yolunu doğru belirleyin
require_once $_SERVER["DOCUMENT_ROOT"]. '/src/Config/config.php';

// Autoload dosyasını dahil et
require_once AUTOLOAD_PATH;

// Router ve Controller sınıflarını dahil et
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Config\App;

// Router ve Controller nesnelerini oluştur
$router = new Router();
$homeController = new HomeController();
$adminController = new AdminController();

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

$router->handleRequest($requestUrl, $requestMethod);



// API URL


// function sendPostRequest($url, $dataArray) {
//     $data = json_encode($dataArray);

//     $ch = curl_init($url);

//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

//     $response = curl_exec($ch);

//     if (curl_errno($ch)) {
//         echo 'Error: ' . curl_error($ch);
//     } else {
//         return $response;
//     }

//     curl_close($ch);
// }

// $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=AIzaSyDJwdS9G-dlzrtASyDnZpxRAAQXnlTM4Nc';

// $dataArray = array(
//     'contents' => array(
//         array(
//             'parts' => array(
//                 array('text' => 'eray 19 yaşında yazılımla uğraşıyor eraya yazılımla alakalı ne önerirsin'),
//             )
//         )
//     )
// );

// $response = sendPostRequest($url, $dataArray);

// $responseArray = json_decode($response, true);

// if (isset($responseArray['candidates'][0]['content']['parts'][0]['text'])) {
//     echo htmlspecialchars($responseArray['candidates'][0]['content']['parts'][0]['text']);
// } else {
//     echo "Yanıt içerisinde beklenen veri bulunamadı.";
// }
