<?php

use App\Models\ProductModel;
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["data"])) {
        $requestData = json_decode($_POST["data"], true);
    } else {
        $requestData = $_POST;
    }
    $result = [];

    if ($requestData && isset($requestData["type"])) {
        $productModel = new ProductModel();
        $supplierModel = new SupplierModel();

        switch ($requestData["type"]) {
            case "del":
                if (isset($requestData["id"])) {
                    $result = $productModel->deleteProduct($requestData["id"]);
                } else {
                    $result = ["success" => false, "message" => "ID missing"];
                }
                break;

            case "get":
                $result = $productModel->getProducts();
                break;

            case "getProduct":
                $result = $productModel->getProduct($requestData["id"]);
                break;
            case "fetchSuppliers":
                $result = $supplierModel->getSuppliers();
                break;

            case "getProductCategories":
                $result = $productModel->getAllCategory();
                break;

            case "new":
                if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] === UPLOAD_ERR_OK) {
                    $uploadResult = image_upload($_FILES["product_image"]);
                    if ($uploadResult['success']) {
                        $result = $productModel->newProduct($_POST, $uploadResult["filename"]);
                    } else {
                        $result = ["success" => false, "message" => $uploadResult['message']];
                    }
                } else {
                    $result = ["success" => false, "message" => "No file uploaded or upload error."];
                }
                break;

            case "remove":
                if (isset($requestData["id"])) {
                    $result = $productModel->deleteProduct($requestData["id"]);
                } else {
                    $result = ["success" => false, "message" => "ID missing"];
                }
                break;
                case "edit":
                    if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] === UPLOAD_ERR_OK) {
                        $uploadResult = image_upload($_FILES["product_image"]);
                    if (isset($requestData["product_id"])) {
                        $result = $productModel->editProduct($_POST,$uploadResult["filename"]);
                    } else {
                        $result = ["success" => false, "message" => "ID missing"];
                    } 
                } else {
                    $result = $productModel->editProduct($_POST);
                }
                    break;
            default:
                $result = ["success" => false, "message" => "Invalid type"];
                break;
        }
    } else {
        $result = ["success" => false, "message" => "Invalid request", "post" => $_POST, "file" => $_FILES["product_image"]];
    }

    header('Content-Type: application/json');
    echo json_encode($result);
}
