<?php

use App\Models\ProductModel;
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productModel = new ProductModel();
    // if (Security::validateCsrfToken($requestData["token"])) { 
    $requestData = json_decode($_POST["order_id"], true);

    $result = $productModel->deleteOrder($requestData);
    header('Content-Type: application/json');
    echo json_encode($result);
    // }
}
