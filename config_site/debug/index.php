<!DOCTYPE html>
<html lang="uk">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danwand Configuration - debug</title>
  <link rel="icon" href="db_logo_icon.png" type="image/png">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/site.css" />
</head>

<body>
  <?php
  require('../func.php');
  require('../menu.php');

  $webservice = "http://" . $_SERVER['SERVER_ADDR'] . ":8080/";
 
  ?>
  <script>
    var element = document.getElementById("debug");
    element.classList.add("active");
  </script>

  <div class="container">
    <h3 class='text-center'>Debug</h3>
    <div class="row">
      <a href="function.php?function=takepic" class="btn btn-lg btn-primary fix-button">Take Picture</a>
      <a href="<?=$webservice?>pic/cam"><button class="btn btn-lg btn-primary fix-button">Cam</button></a>
      <a href="<?=$webservice?>3d/3d"><button class="btn btn-lg btn-primary fix-button">3D Scan</button></a>
    </div>
    <div class="row">
      <a href="display.php?function=log&file=/var/log/apache2/danwand.log"
        class="btn btn-lg btn-primary fix-button">Website log</a>
      <a href="display.php?function=log&file=/var/log/apache2/danwand.err.log"
        class="btn btn-lg btn-primary fix-button">Website error log</a>
      <a href="display.php?function=log&file=/var/log/apache2/error.log"
        class="btn btn-lg btn-primary fix-button">Apache error log</a>
    </div>
    <br>
    <div class="row">
      <a href="display.php?function=log&file=/var/log/webservice.log"
        class="btn btn-lg btn-primary fix-button">Webservice Log</a>
      <a href="display.php?function=log&file=/var/log/danwand.log" class="btn btn-lg btn-primary fix-button">DanWand
        log</a>
    </div>
    <hr>
    <div class="row">
      <a href="/" class="btn btn-lg btn-primary fix-button">Return</a>
    </div>
    <script src="/js/bootstrap.min.js"></script>
</body>

</html>