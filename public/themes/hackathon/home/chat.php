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
    exit; // PHP işlemi burada sona erdir
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sohbet Alanı</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />

    <style>
        body {
            background: rgb(48,84,124);
            background: linear-gradient(90deg, rgba(48,84,124,1) 0%, rgba(30,62,98,1) 35%, rgba(50,103,162,1) 100%);
            color: white;
            font-family: "Montserrat Alternates", sans-serif;
        }

        .navbar {
            background-color: black;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .navbar .nav-link,
        .navbar-brand {
            color: white !important;
        }

        .navbar .form-control {
            background-color: #2a2a2a;
            color: white;
            border: none;
        }

        .navbar .btn-outline-light {
            border-color: #555;
            color: #ccc;
        }

        .chat-container {
            background-color: black;
            padding: 20px;
            border-radius: 5px;
            height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .chat-input {
            display: flex;
            margin-top: 10px;
        }

        .chat-message {
            margin: 5px 0;
        }

        .user {
            color: #0078ff;
            /* Kullanıcı mesaj rengi */
        }

        .ai {
            color: #00dbde;
            /* Yapay zeka mesaj rengi */
        }

        .sidebar {
            background-color: black;
            padding: 20px;
            border-radius: 10px;
        }

        .container {
            max-width: 1120px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-bottom: 20px;
            }
        }
        .cato{
          text-decoration: none;
          list-style: none;
          color: white;
        }
        .cato:hover{
          color: white;
          text-decoration: none;
        }
        ul li a{
            border-radius: 20px;
        }
        ul li a:hover{
            background: #0078ff;
            background: linear-gradient(45deg, #00dbde, #7AB2D3);
        }
        .btn{
            background: #0078ff;
            background: linear-gradient(45deg, #00dbde, #7AB2D3);
        }
    </style>
</head>

<body>

<header class="header mb-5" id="header">
        <nav class="navbar navbar-expand-lg container">
            <a class="navbar-brand" href="/">Shark Edu</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                        <a class="nav-link" href="/" >Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="chat" style="background: #0078ff;
            background: linear-gradient(45deg, #00dbde, #7AB2D3);">ChatBot</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login">
                        <span class="material-symbols-outlined">
                            account_circle
                            </span>
                          
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container mt-5">
        <div class="row">
        <div class="col-md-3 sidebar">
                <h5 class="filter-title text-center" style=" background: #0078ff; border-radius: 20px; background: linear-gradient(45deg, #00dbde, #7AB2D3);">Kategoriler</h5>
                <div class="Kategoriler">
                    <a href="#" class="cato"> - Yazılım Dünyası</a>
                </div>
                <!-- Diğer kategoriler -->
            </div>

            <div class="col-md-9">
                <div class="chat-container" id="chat-container">
                    <div id="chat-messages"></div>
                </div>
                <div class="chat-input">
                    <input type="text" id="chat-input" class="form-control" placeholder="Mesaj yazın...">
                    <button id="send-button" class="btn">Gönder</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#send-button').click(function() {
                const message = $('#chat-input').val();
                if (message.trim() !== '') {
                    // Kullanıcı mesajını ekle
                    $('#chat-messages').append(`<div class="chat-message user"><strong>Sen:</strong> ${message}</div>`);
                    $('#chat-input').val(''); // Giriş alanını temizle
                    $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight); // Aşağı kaydır

                    // Yapay zeka yanıtını al
                    getAIResponse(message);
                }
            });

            $('#chat-input').keypress(function(e) {
                if (e.which == 13) { // Enter tuşuna basıldığında
                    $('#send-button').click();
                }
            });
        });

        function getAIResponse(userMessage) {
            $.ajax({
                url: 'src/Ajax/hackathon/home/AiAjax.php', // AJAX isteği için URL
                type: 'POST',
                data: {
                    message: userMessage
                },
                success: function(response) {
                    // Eğer yanıt bir nesne ise, metni al
                    const aiMessage = typeof response === 'object' ? response.message : response;
                    typeOutResponse("Cafer", aiMessage); // Yapay zeka yanıtını yazdır
                },
                error: function(error) {
                    console.error("Hata:", error);
                }
            });
        }

        function typeOutResponse(name, response) {
            let index = 0;
            const typingSpeed = 10; // Harfler arası gecikmeyi azalt (ms)
            // Yeni bir mesaj alanı oluştur
            const aiMessageContainer = $(`<div class="chat-message ai"><strong>${name}:</strong> <span id="ai-response-${Date.now()}"></span></div>`);
            $('#chat-messages').append(aiMessageContainer); // Mesaj alanını ekle
            const aiResponseContainer = aiMessageContainer.find('span'); // Yeni mesaj alanındaki span'ı bul

            const type = () => {
                if (index < response.length) {
                    aiResponseContainer.append(response[index]);
                    index++;
                    setTimeout(type, typingSpeed);
                } else {
                    $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight); // Aşağı kaydır
                }
            };

            type();
        }
    </script>

</body>

</html>