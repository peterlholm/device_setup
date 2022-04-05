<!DOCTYPE html>
<html lang="uk">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, xheight=device-height, initial-scale=1.0">
  <title>Danwand Configuration</title>
  <!-- <link rel="manifest" href="/manifest.json" crossorigin="use-credentials"> -->
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/site.css" />
</head>

<body>
  <?php
  require('func.php');
  ?>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark xbg-primary">
      <a class="navbar-brand" href="#">
        <img src="/pic/db_logo.png" width="30" height="30" class="d-inline-block align-top" alt="logo">
        danWand
      </a>&nbsp;
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/wifi.php">WiFi Configuration</a>
          </li>
          <!-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li> -->
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Debug</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="background-wand">
      <h1 class="text-center">danWand configuration</h1>
      <br>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>WIFI SID</label>
        </div>
        <div class="col-4">
          FutureBox
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>ETH Mac Address</label>
        </div>
        <div class="col-4">
          <?php echo get_eth_mac() ?>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>WiFi Mac Address</label>
        </div>
        <div class="col-4">
          <?= get_wifi_mac() ?>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>IP Address</label>
        </div>
        <div class="col-4">
          <?php echo get_ip_address()?>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>Router</label>
        </div>
        <div class="col-4">
          192.168.1.1
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>Internet</label>
        </div>
        <div class="col-4">
          <?=internet_connection()?>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>HW info</label>
        </div>
        <div class="col-4">
          <?=get_hw_info()?>
        </div>
      </div>
   </div>
  </div>
  <script src="/js/bootstrap.min.js"></script>

</body>

</html>