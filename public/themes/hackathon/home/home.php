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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <style>
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

        .navbar {
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;

        }
        .navbar,
        .sidebar {
            background-color: #e5efff;
        }
        .cato:hover,
        .nav-link:hover {
            color: #00dbde;
        }

        .chat-container {
            background-color: #e5efff;
            padding: 20px;
            border-radius: 5px;
            overflow-y: auto;
        }
        .chat-message {
            margin: 5px 0;
        }

        .user {
            color: #2ba0ff;
            /* Kullanıcı mesaj rengi */
        }


        .sidebar {
            padding: 20px;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-bottom: 20px;
            }
        }
        .cato:hover,
        .nav-link:hover {
            color: #00dbde;
        }
        
        .bg-header {
            background: linear-gradient(45deg, #0000007d, #0c044d66), url("https://images.pexels.com/photos/1229042/pexels-photo-1229042.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            color: #ccc;
        }
        .cato:hover,
        .nav-link:hover {
            color: #00dbde;
        }
        .btn{
            width: 100%;
            background-color: black;
            color: white;
        }
    </style>
</head>

<body>

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
                    <div id="chat-messages">
                        <div class="row">
                            <div class="col-lg-5 m-3">
                            <div class="card" style="width: 18rem;">
                              <img class="card-img-top" src="..." alt="Card image cap">
                              <div class="card-body">
                                <h5 class="card-title">Başlık</h5>
                                <p class="card-text">Açıklama</p>
                                <a href="#" class="btn">Katıl</a>
                              </div>
                            </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   

</body>

</html>