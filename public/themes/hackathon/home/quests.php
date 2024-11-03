<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/src/Config/config.php';
require_once AUTOLOAD_PATH;

use App\Operation\AIOperation;


// Mesajın geldiği yer (örneğin bir AJAX isteği)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'] ?? ''; // Mesajı POST'tan alıyoruz

    // Mesajın boş olmadığından emin olalım
    if (!empty($message) && is_string($message)) {
        $aiOperation = new AIOperation();
        $response = $aiOperation->chatBot($message); // Mesajı chatBot metoduna gönderiyoruz

        echo json_encode(['response' => $response]); // Yanıtı JSON olarak döndürüyoruz
    } else {
        echo json_encode(['error' => 'Message must be a non-empty string']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sohbet Alanı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <link rel="stylesheet" href="/public/themes/hackathon/home/assets/css/styles.css">
    <link rel="stylesheet" href="/public/themes/hackathon/home/assets/css/upload.css">
</head>

<body>
    <div class="loading-animation" id="loading-animation" style="display: none;">
        <div class="spinner"></div> Yanıt Bekleniyor...
    </div>

    <?php include 'templates/navbar.php'; ?>

    <div class="container bg-header rounded">
        <div class="header_card text-white p-5 text-center h-100">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo suscipit delectus esse in. Eveniet adipisci atque aperiam laboriosam architecto unde quaerat facere, libero temporibus corporis voluptate quod? Error, eius quod.
        </div>
    </div>


    <div class="container mt-5">

        <div class="row">
            <?php include 'templates/sidebar.php'; ?>

            <div class="col-md-9 ">
                <div class="context text-decoration-none">
                    <div class="container">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                            <?= $quests_categories; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/public/themes/hackathon/home/assets/js/script.js"></script>
</body>

</html>