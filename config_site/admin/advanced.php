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
  //$aplist = get_ap_list();
  ?>

  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark xbg-light">
      <a class="navbar-brand" href="/#">
        <img src="/pic/db_logo.png" width="30" height="30" class="d-inline-block align-top" alt="logo">
        danWand
      </a>&nbsp;
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/admin/wifi.php">WiFi Configuration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="/admin/advanced.php#">Advanced</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Change password</a>
          </li>

        </ul>
      </div>
    </nav>
    <div class="">
      <h3 class='text-center'>Advanced 1</h3>
      <hr>
      <h3 class='text-center'>Advansed 2</h3>
 
    </div>
  </div>
  <script src="/js/bootstrap.min.js"></script>
</body>

</html>