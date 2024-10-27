<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;

use App\Models\CustomerModel;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode($_POST['data'], true);
    $userModel = new CustomerModel();
    $response = $userModel->newCustomer($requestData);
    header('Content-Type: application/json');
    echo json_encode($response);
}
