<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;

use App\Models\UserModel;
use App\Core\Security; // CSRF koruması için

// Sadece POST taleplerini işliyoruz
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gelen POST verilerini JSON formatında alıyoruz
    $requestData = $_POST;

    // CSRF token kontrolü
    if (Security::validateCsrfToken($requestData["token"])) {
        // UserModel nesnesi oluşturuluyor
        $userModel = new UserModel();

        // İletişim formu işlemleri yapılıyor
        $response = $userModel->contact($requestData);

        // JSON olarak cevap dönüyoruz
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // CSRF token geçersizse hata mesajı
        header('Content-Type: application/json', true, 403);
        echo json_encode(['status' => 'error', 'message' => 'CSRF token is invalid.', "token" => $requestData["token"]]);
    }
}
