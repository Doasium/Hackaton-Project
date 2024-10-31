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

        .chat-container {
            background-color: black;
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
        .card{
            background: #0078ff;
            background: linear-gradient(45deg, #00dbde, #7AB2D3);
            color: white;
        }
        .btn{
            width: 100%;
            background-color: black;
            color: white;
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
                        <a class="nav-link" href="/" style="background: #0078ff;
            background: linear-gradient(45deg, #00dbde, #7AB2D3);">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="chat">ChatBot</a>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   

</body>

</html>