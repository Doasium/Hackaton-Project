<?php

use App\Models\CustomerModel;
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode($_POST["data"], true);

    if ($requestData && isset($requestData["type"])) {
        $customerModel = new CustomerModel();
        $result = [];

        switch ($requestData["type"]) {
            case "del":
                if (isset($requestData["id"])) {
                    $result = $customerModel->deleteCustomer($requestData["id"]);
                } else {
                    $result = ["success" => false, "message" => "ID missing"];
                }
                break;
            case "get":
                $result = $customerModel->customers();
                break;
            case "getPerson":
                $result = $customerModel->getCustomer($requestData["id"]);
                break;
                case "edit":
                    $result = $customerModel->editCustomer($requestData);
                    break;
            default:
                $result = ["success" => false, "message" => "Invalid type"];
                break;
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Invalid request"]);
    }
}
