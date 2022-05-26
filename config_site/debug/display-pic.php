<!DOCTYPE html>
<html lang="uk">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danwand Configuration - Display Picture</title>
  <link rel="icon" href="/pic/db_logo.png" type="image/png">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/site.css" />
</head>

<html class="xonepage" />

<body>
  <div class="container">
    <?php
        if (PHP_OS == 'WINNT') {
            $config_dir = "config";
        }
        ?>
    <h1>Camera Picture</h1>
    <div class="row">
      <div class="col">
        <br>

        <img src="/tmp/pic.jpg" alt="camera picture" class="img-fluid" xheight="400" xwidth="600">
        <br><br>
        <a href="./index.php"><button type="button" class="btn btn-lg">Return</button></a>

      </div>
      <div class="col">
        <?php

        function print_table($tab)
          {
            echo "Table<br>";
            foreach ($tab as $p => $d) {
              echo "<h5>$p</h5>";
              echo "<table>\n";
              foreach ($d as $ep => $e) {
                if (gettype($e) == 'array');
                echo "<tr><td>$ep</td><td>$e</td></tr>\n";
              }
              echo "</table>\n";
            }
          }

          $img = "/tmp/pic.jpg";
          $data = exif_read_data($img, NULL, true);

          foreach ($data as $p => $d) {
            echo "<h4>$p</h4>";
            echo "<table>\n";
            foreach ($d as $ep => $e) {
              if (gettype($e) == 'array') {
                echo "<tr><td>array</td></tr>";
              } else {
                      echo "<tr><td>$ep</td><td>$e</td></tr>\n";

              }
            }
            echo "</table>\n";

          }
          //print_r($data);


          ?>
      </div>
    </div>

</html>