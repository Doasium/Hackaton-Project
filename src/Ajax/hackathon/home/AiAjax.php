<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;

use App\Operation\AIOperation;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = $_POST;
    $userModel = new AIOperation();
    $response = $userModel->chatBot($requestData);
    header('Content-Type: application/json');
    echo json_encode($response);
}
