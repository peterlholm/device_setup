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
          <button type="submit" class="btn btn-primary" name="submit" value="setconfig">Set Configmode</button>
          <button type="submit" class="btn btn-primary" name="submit" value="resetconfig">Reset Configmode</button>
          <button type="submit" class="btn btn-primary" name="submit" value="reboot">Reboot to normal</button>
          <button type="submit" class="btn btn-primary" name="submit" value="config">Reboot to Config Mode</button>
        </div>

    </div>
    <?php
    $configfile = "/var/lib/danwand/configmode";
    if (isset(($_REQUEST['submit']))) {
      $function = $_REQUEST['submit'];
      if ($function == "setconfig") {
        file_put_contents($configfile, "");
        echo "<h4>Holding device in config mode</h4><br>";
      }
      if ($function == "resetconfig") {
        unlink($configfile);
        echo "<h4>deleting config mode</h4><br>";
      }
      if ($function == "reboot") {
        system_reboot();
        echo "<h4>System rebooting</h4><br>";
      }
      if ($function == "config") {
        config_reboot();
        echo "<h4>System rebooting</h4><br>";
      }
    }
    ?>
  </div>
  <script src="/js/jquery-3.2.1.slim.min.js"></script>
  <script src="/js/popper.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</body>

</html>