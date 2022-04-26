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
  <div class="container">
  <?php
  require('../func.php');
  //$aplist = get_ap_list();
  require('../menu.php');
  ?>
    <script>
    var element = document.getElementById("advanced");
    element.classList.add("active");
  </script>
  <br>
    <div class="">

      <form>
      <h3 class='text-center'>Advanced 1</h3>
      <hr>
      <h3 class='text-center'>Special Functions</h3>
      <div class="col-sm-2">
                <button type="submit" class="btn btn-primary" name="submit" value="reboot">Reboot</button>
              </div>

    </div>
    <?php        
      if (isset(($_REQUEST['submit']))) {
          $function = $_REQUEST['submit'];
          if ($function == "savessid") {
            $ssid = $_REQUEST['ssid'];
            $passphrase = $_REQUEST['passphrase'];
            if (strlen($ssid)==0 || strlen($passphrase)==0) {
              echo ("empty fields");
              return "error in config";
            }
            add_wpa_config($ssid, $passphrase);
            echo "<h4>Saving $ssid and $passphrase</h4><br>";
          }
        elseif ($function == "reboot") system_reboot();
        else print("unknown function");
      }
      ?>
  </div>
  <script src="/js/bootstrap.min.js"></script>
</body>

</html>