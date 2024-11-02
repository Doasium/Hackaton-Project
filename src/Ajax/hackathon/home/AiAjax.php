<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;
session_start();
use App\Operation\AIOperation;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel = new AIOperation();

    if (isset($_POST['message'])) {
        $response = $userModel->chatBot($_POST['message']);
    } elseif (isset($_POST['fileContent'])) {
        $response = $userModel->codeAnaliz($_POST['fileContent']);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
