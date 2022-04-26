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
  <div class="container">
    <?php
    require('func.php');
    require('menu.php');
    ?>
    <script>
    var element = document.getElementById("home");
    element.classList.add("active");
  </script>
 
    <div class="background-wand">
      <br>
      <h1 class="text-center">danWand configuration</h1>
      <br><br>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>WIFI SID</label>
        </div>
        <div class="col-4">
          <?=get_current_ssid();?>
        </div>
      </div>
      <div class="row justify-content-center">
        <!-- <div class="col-4">
          <label>ETH Mac Address</label>
        </div>
        <div class="col-4">
          <?php echo get_eth_mac() ?>
        </div> -->
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
          <?php echo get_ip_address() ?>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-4">
          <label>Internet</label>
        </div>
        <div class="col-4">
          <?= internet_connection() ?>
        </div>
      </div>
      <div class="row justify-content-center">
      </div>
    </div>
  </div>
  <script src="/js/jquery-3.2.1.slim.min.js"></script>
  <script src="/js/popper.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>

</body>

</html>