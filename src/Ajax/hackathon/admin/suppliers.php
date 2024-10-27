 <?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;

$response = ["success" => false, "message" => "Invalid request"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode($_POST["data"], true);
    if ($requestData && isset($requestData["type"])) {
        $supplierModel = new SupplierModel();
        $result = [];

        switch ($requestData["type"]) {
            case "del":
                if (isset($requestData["id"])) {
                    $result = $supplierModel->delSuppliers($requestData["id"]);
                } else {
                    $result = ["success" => false, "message" => "ID missing"];
                }
                break;
            case "get":
                $result = $supplierModel->getSuppliers();
                break;
            case "new":
                $result = $supplierModel->newSupplier($requestData);
                break;
            case "editPriceSupplier":
                $result = $supplierModel->editSupplier($requestData);
                break;
            case "getTotalSales":
                $result = $supplierModel->getTotalSales();
                break;
            case "getPerson":
                $result = $supplierModel->getPersonSupplier($requestData["id"]);
                break;
            case "editPerson":
                $result = $supplierModel->editPersonSupplier($requestData);
                break;
            default:
                $result = ["success" => false, "message" => "Invalid type"];
                break;
        }
        $response = $result;
    }
}

echo json_encode($response);
?>
