<?php

use App\Models\ProductModel;
use App\Models\UserModel;
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', $root . '/error_log');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    if (isset($_POST["data"])) {
        $requestData = json_decode($_POST["data"], true);
    } else {
        $requestData = $_POST;
    }

    if ($requestData && isset($requestData["type"])) {
        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $userModel = new UserModel();
        $result = [];

        switch ($requestData["type"]) {
            case "del":
                if (isset($requestData["id"])) {
                    $del = $orderModel->deleteOrder($requestData["id"]);
                    $result = ["success" => true];
                } else {
                    $result = ["success" => false, "message" => "ID missing"];
                }
                break;
            case "getAdd":
                $getAllCustomers = $userModel->getAllCustomers();
                $products = $productModel->getAllProductList();
                $result = [
                    "success" => true,
                    "data" => [
                        "customers" => $getAllCustomers["data"],
                        "products" => $products["data"]
                    ]
                ];
                break;
            case "get":
                $orders = $orderModel->getAllOrders();
                $result = [
                    "success" => true,
                    "data" => [
                        "orders" => $orders,
                    ]
                ];
                break;
            case "editGetDetails":
                $result = $orderModel->editGetDetails($requestData["id"]);
                $result["products"] =  $productModel->getAllProductList();
                break;
            case "new":
                $add = $orderModel->newOrderAdd($requestData);
                $result = ["success" => true];
                break;
            case "edit":
                if (isset($requestData["order_id"]) && isset($requestData["products"])) {
                    $edit = $orderModel->editOrder($requestData["order_id"], $requestData);
                    $result = ["success" => $edit['success'], "message" => $edit];
                } else {
                    $result = ["success" => false, "message" => "ID or data missing"];
                }
                break;
            case "getStatus":
                $result = $orderModel->getStatus();
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
