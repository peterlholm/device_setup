<!DOCTYPE html>
<html lang="uk">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, xheight=device-height, initial-scale=1.0">
  <title>Danwand Configuration</title>
  <!-- <link rel="manifest" href="/manifest.json" crossorigin="use-credentials"> -->
  <link rel="icon" href="db_logo_icon.png" type="image/png">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/site.css" />
</head>

<body>
  <div class="container">
    <?php
    require('func.php');
    require('dw_func.php');
    require('menu.php');
    $hidesignal = "";
    $ip = get_ip_address();
    $ssid = wifi_ssid();
    if ($ssid=='') $ssid = "DanWand";
    $power = battery_power_level();
    $signal = wifi_signal_level();
    if ($signal=="") $hidesignal="d-none";
    $internet = internet_connection()?"OK":"Error";
    $cloud_service = internet_connection(2)?"OK":"Error";
    $charging = "Charging";
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
          <label>WIFI SSID</label>
        </div>
        <div class="col-4">
          <?=$ssid?>
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
      <div class="row justify-content-center <?=$hidesignal?>">
        <div class="col-4">
          <label>WiFi Level</label>
        </div>
        <div class="col-4">
        <meter value="<?=$signal?>" min="-90" max="-40" low="-70" high="-50" optimum="-60" title="<?=$signal?> dBm"><?=$signal?> dBm</meter> <?=$signal?> dBm
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>IP Address</label>
        </div>
        <div class="col-4">
          <?=$ip?>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-4">
          <label>Internet access</label>
        </div>
        <div class="col-4">
          <?=$internet?>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>danBots Cloud Service</label>
        </div>
        <div class="col-4">
          <?= $cloud_service?>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-4">
          <label>Power Level</label>
        </div>
        <div class="col-4">
        <meter value="<?=$power?>" min="0" max="100" low="25" high="80" optimum="85" title="Charge <?=$power?>%"><?=$power?>%</meter> <?=$charging?>
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