<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sohbet Alanı</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="/public/themes/hackathon/home/assets/css/styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
  <link rel="stylesheet" href="/public/themes/hackathon/home/assets/css/videoplayer.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">

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

        <div class="context d-flex">
          <div class="video-container">
            <div id="video_player">
              <div class="videoSpinner">

              </div>
              <video preload="metadata" id="main-video">
                <source src="<?= $leasson_video; ?>" type="video/mp4">
              </video>
              <div class="thumbnail"></div>
              <div class="progressAreaTime">0:00</div>

              <div class="controls">
                <div class="progress-area">
                  <input type="range" name="progressBar" id="id_progressBar" step="0.1" min="0" max="100" value="0" class="progress-bar">
                  <span></span>
                </div>

                <div class="controls-list">
                  <div class="controls-left">
                    <span class="icon">
                      <i class="material-icons play_pause">play_arrow</i>
                    </span>
                    <span class="icon">
                      <i class="material-icons volume">volume_up</i>
                      <input type="range" min="0" max="100" value="100" class="volume_range" />
                    </span>
                    <div class="timer">
                      <span class="current">0:00</span> /
                      <span class="duration">0:00</span>
                    </div>
                  </div>

                  <div class="controls-right">
                    <span class="icon">
                      <i class="material-icons settingsBtn">settings</i>
                    </span>
                    <span class="icon">
                      <i class="material-icons picture_in_picutre">picture_in_picture_alt</i>
                    </span>
                    <span class="icon">
                      <i class="material-icons fullscreen">fullscreen</i>
                    </span>
                  </div>
                </div>
              </div>

              <div id="settings">
                <div class="playback">
                  <span>Playback Speed</span>
                  <ul>
                    <li data-speed="0.25">0.25</li>
                    <li data-speed="0.5">0.5</li>
                    <li data-speed="0.75">0.75</li>
                    <li data-speed="1" class="active">Normal</li>
                    <li data-speed="1.25">1.25</li>
                    <li data-speed="1.5">1.5</li>
                    <li data-speed="1.75">1.75</li>
                    <li data-speed="2">2</li>
                  </ul>
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
  <script src="/public/themes/hackathon/home/assets/js/videoplayer.js"></script>
</body>

</html>