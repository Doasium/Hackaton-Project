<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eğitimler Sayfası</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      background-color: #121212;
      color: white;
      padding-top: 56px; /* Navbar alanı için boşluk bırak */
    }
    .navbar {
      background-color: #1e1e1e;
    }
    .navbar .nav-link, .navbar-brand {
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
    .card {
      background-color: #1e1e1e;
      border: none;
      margin-bottom: 1rem;
    }
    .card-title {
      font-size: 1.1rem;
      font-weight: bold;
    }
    .level-badge {
      font-size: 0.8rem;
      padding: 0.2rem 0.5rem;
      border-radius: 0.2rem;
      color: white;
    }
    .basic-level { background-color: #28a745; }
    .intermediate-level { background-color: #ffc107; }
    .advanced-level { background-color: #dc3545; }
    .sidebar {
      background-color: #1e1e1e;
      padding: 20px;
      height: 100vh;
    }
    .filter-title {
      font-weight: bold;
      margin-bottom: 1rem;
    }
    .card-footer {
      background-color: #1e1e1e;
      border-top: none;
      color: #ccc;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Eğitim Platformu</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Anasayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Eğitimler</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Hakkımızda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">İletişim</a>
        </li>
      </ul>
      <form class="form-inline ml-lg-3 my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Arama yap" aria-label="Search">
        <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Ara</button>
      </form>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 sidebar">
      <h5 class="filter-title">Kategoriler</h5>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="kategori1">
        <label class="form-check-label" for="kategori1">Yazılım Dünyası</label>
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="kategori2">
        <label class="form-check-label" for="kategori2">Sistem Dünyası</label>
      </div>
      <!-- Diğer kategoriler -->
    </div>

    <!-- Main Content -->
    <div class="col-md-9">
      <h4 class="mt-3">Eğitimler</h4>
      <div class="row">
        <!-- Kart 1 -->
        <div class="col-md-4">
          <div class="card">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Kubernetes">
            <div class="card-body">
              <h5 class="card-title">Kubernetes</h5>
              <span class="level-badge intermediate-level">Orta Seviye</span>
            </div>
            <div class="card-footer d-flex justify-content-between">
              <span><i class="fas fa-thumbs-up"></i> 1</span>
              <span><i class="fas fa-users"></i> 567</span>
            </div>
          </div>
        </div>
        <!-- Kart 2 -->
        <div class="col-md-4">
          <div class="card">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Sızma Testi">
            <div class="card-body">
              <h5 class="card-title">Sızma Testi</h5>
              <span class="level-badge basic-level">Temel Seviye</span>
            </div>
            <div class="card-footer d-flex justify-content-between">
              <span><i class="fas fa-thumbs-up"></i> 1</span>
              <span><i class="fas fa-users"></i> 3.5K</span>
            </div>
          </div>
        </div>
        <!-- Kart 3 -->
        <div class="col-md-4">
          <div class="card">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Python İleri Seviye">
            <div class="card-body">
              <h5 class="card-title">İleri Seviye Python</h5>
              <span class="level-badge advanced-level">İleri Seviye</span>
            </div>
            <div class="card-footer d-flex justify-content-between">
              <span><i class="fas fa-thumbs-up"></i> 95</span>
              <span><i class="fas fa-users"></i> 5K</span>
            </div>
          </div>
        </div>
        <!-- Diğer kartlar burada benzer şekilde eklenebilir -->
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
</body>
</html>
