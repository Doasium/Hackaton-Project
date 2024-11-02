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
            <div class="col-md-3 sidebar">
                <h5 class="filter-title text-center" style="background: linear-gradient(45deg, #00dbde, #7AB2D3);">Kategoriler</h5>
                <a href="#" class="cato">- Yazılım Dünyası</a>
                <!-- Diğer kategoriler -->
            </div>

            <div class="col-md-9 ">
                <div class="quest">
                    <h4 id="quest_title">Soru #1</h4>
                    <p id="quest_details">Döngüyle 100 kere ahmet yazdırması gerekli.</p>
                </div>
                <div class="context d-flex">
                    <div id="uploadArea" class="upload-area">
                        <!-- Header -->
                        <div class="upload-area__header">
                            <h1 class="upload-area__title">Dosyayı Yükleyiniz</h1>

                        </div>
                        <!-- End Header -->

                        <!-- Drop Zoon -->
                        <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
                            <span class="drop-zoon__icon">
                                <i class='bx bxs-file-image'></i>
                            </span>
                            <p class="drop-zoon__paragraph">Drop your file here or Click to browse</p>
                            <span id="loadingText" class="drop-zoon__loading-text">Please Wait</span>
                            <img src="" alt="Preview Image" id="previewImage" class="drop-zoon__preview-image" draggable="false">
                            <input type="file" id="fileInput" class="drop-zoon__file-input" accept=".php,.txt,.js,.java,.py,.jar,.rb,.c,.cpp">
                        </div>
                        <!-- End Drop Zoon -->

                        <!-- File Details -->
                        <div id="fileDetails" class="upload-area__file-details file-details">
                            <h3 class="file-details__title">Uploaded File</h3>

                            <div id="uploadedFile" class="uploaded-file">
                                <div class="uploaded-file__icon-container">
                                    <i class='bx bxs-file-blank uploaded-file__icon'></i>
                                    <span class="uploaded-file__icon-text"></span> <!-- Data Will be Comes From Js -->
                                </div>

                                <div id="uploadedFileInfo" class="uploaded-file__info">
                                    <span class="uploaded-file__name">Proejct 1</span>
                                    <span class="uploaded-file__counter">0%</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button id="uploadButton" class="btn btn-primary">Gönder</button>

                            </div>
                        </div>
                        <!-- End File Details -->
                    </div>
                    <div id="resultContainer" class="upload-area" style="animation: slidDown 500ms ease;">
                        <div id="goalAi">
                            <h4 class="text-danger">AI:</h4>
                            <div class="result"></div>
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