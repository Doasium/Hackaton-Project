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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <style>
        /* Stil ayarları */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            font-family: "Poppins", sans-serif;
            font-weight: 500;
            font-style: normal;
        }

        body {
            background: #f6f6f6;
            color: white;
            font-family: "Montserrat Alternates", sans-serif;
        }

        .navbar,
        .sidebar {
            background-color: #e5efff;
        }

        .navbar {
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
        }

        .sidebar {
            padding: 20px;
            border-radius: 10px;
        }

        .cato:hover,
        .nav-link:hover {
            color: #00dbde;
        }

        .chat-container {
            background-color: #2a2a2a;
            padding: 20px;
            border-radius: 5px;
            height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .loading-animation {
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(45deg, #0000007d, #0c044d66);
            color: #ffca28;
            font-size: 14px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1000;
        }

        .spinner {
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid #ffca28;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .bg-header {
            background: linear-gradient(45deg, #0000007d, #0c044d66), url("https://images.pexels.com/photos/1229042/pexels-photo-1229042.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            color: #ccc;
        }
    </style>
</head>

<body>
    <div class="loading-animation" id="loading-animation" style="display: none;">
        <div class="spinner"></div> Yanıt Bekleniyor...
    </div>
    <header class="header mb-5">
        <nav class="navbar navbar-expand-lg container">
            <a class="navbar-brand" href="/">Shark Edu</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="chat">ChatBot</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="login"><span class="material-icons-outlined">account_circle</span></a></li>
                </ul>
            </div>
        </nav>
    </header>

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
            <div class="col-md-9">
                <div class="chat-container" id="chat-container">
                    <div id="chat-messages"></div>
                </div>
                <div class="chat-input d-flex">
                    <input type="text" id="chat-input" name="message" class="form-control" placeholder="Mesaj yazın...">
                    <button id="send-button" class="btn btn-primary">Gönder</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        hljs.highlightAll();

        $(document).ready(() => {
            $('#send-button').on('click', sendMessage);
            $('#chat-input').on('keypress', (e) => {
                if (e.which === 13) sendMessage();
            });
        });

        function sendMessage() {
            const message = $('#chat-input').val().trim();
            if (!message) return;
            displayMessage("Sen", message, 'user');
            $('#chat-input').val('');
            getAIResponse(message);
        }

        function getAIResponse(userMessage) {
            $('#loading-animation').show();
            $.post('src/Ajax/hackathon/home/AiAjax.php', {
                    message: userMessage
                })
                .done((data) => {
                    const aiMessage = (typeof data === 'object' && data.message) ? data.message : data;
                    displayMessage("Cafer", aiMessage, 'ai');
                })
                .fail((error) => console.error("Hata:", error))
                .always(() => $('#loading-animation').hide());
        }

        function displayMessage(sender, message, messageType) {
            $('#chat-messages').append(`<div class="chat-message ${messageType}"><strong>${sender}:</strong> ${convertMarkdown(message)}</div>`);
            $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
            hljs.highlightAll();
        }

        function convertMarkdown(text) {
            return text
                .replace(/###### (.*?)\n/g, '<h6>$1</h6>')
                .replace(/##### (.*?)\n/g, '<h5>$1</h5>')
                .replace(/#### (.*?)\n/g, '<h4>$1</h4>')
                .replace(/### (.*?)\n/g, '<h3>$1</h3>')
                .replace(/## (.*?)\n/g, '<h2>$1</h2>')
                .replace(/# (.*?)\n/g, '<h1>$1</h1>')
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/```(.*?)```/gs, '<pre><code>$1</code></pre>');
        }
    </script>
</body>

</html>