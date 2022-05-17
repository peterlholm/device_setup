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
 
  //$aplist = get_ap_list();
  ?>
  <script>
    var element = document.getElementById("debug");
    element.classList.add("active");
  </script>

  <div class="container">
  
    <div class="">
      <h3 class='text-center'>Advanced 1cc</h3>
      <div class="menu">
            <a href="function.php?function=takepic"><button class="btn btn-lg fix-button">Take Picture</button></a>
            <a href="<?=$webservice?>pic/cam"><button class="btn btn-lg fix-button">Cam</button></a>
            <a href="<?=$webservice?>3d/3d"><button class="btn btn-lg fix-button">3D Scan</button></a>
        </div>

      <hr>
      <h3 class='text-center'>Advansed 2</h3>
 
    </div>
  </div>
  <script src="/js/bootstrap.min.js"></script>
</body>

</html>