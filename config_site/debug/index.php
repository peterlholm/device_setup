<!DOCTYPE html>
<html lang="uk">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danwand Configuration</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/site.css" />
</head>

<body>
  <?php
  require('../func.php');
  require('../menu.php');

  //$aplist = get_ap_list();
  ?>

  <div class="container">
  
    <div class="">
      <h3 class='text-center'>Advanced 1</h3>
      <div class="menu">
            <a href="function.php?function=takepic"><button class="btn fix-button menubutton smallbutton">Take Picture</button></a>
            <a href="<?=$webservice?>pic/cam"><button class="btn fix-button menubutton smallbutton">Cam</button></a>
            <a href="<?=$webservice?>3d/3d"><button class="btn fix-button menubutton smallbutton">3D Scan</button></a>
        </div>

      <hr>
      <h3 class='text-center'>Advansed 2</h3>
 
    </div>
  </div>
  <script src="/js/bootstrap.min.js"></script>
</body>

</html>