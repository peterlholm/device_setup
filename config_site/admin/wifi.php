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
    $aplist = get_ap_list();
    require('../menu.php');
    $resulttext = "";
    $disabled = "disabled";
    if (isset(($_REQUEST['submit']))) {
      $function = $_REQUEST['submit'];
      if ($function == "savessid") {
        $ssid = $_REQUEST['ssid'];
        $passphrase = $_REQUEST['passphrase'];
        if (strlen($ssid) == 0 || strlen($passphrase) == 0) {
          $resulttext = '<div class="col-10 text-danger">SSID and passphrase must be filled</div>';
          //return "error in config";
        } elseif (strlen($passphrase) < 8) {
          $resulttext = '<div class="col-10 text-danger">Passphrase must be minimum 8 characteers</div>';
        } else {
          add_wpa_config($ssid, $passphrase);
          $resulttext = '<div class="col-10 text-success">SSID is saved</div>';
          $disabled = "";
        }
      } elseif ($function == "reboot") system_reboot();
      else print("unknown function");
    }
    ?>

    <script>
      var element = document.getElementById("wifi");
      element.classList.add("active");
    </script>
    <div class="">
      <br>
      <h3 class='text-center'>Local WiFi Network</h3>
      <div class="row justify-content-center">
        <div class="col col-5">
          <table class="table table-sm">
            <thead>
              <tr>
                <th scope="col">Network</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($aplist as $l) {
                echo "<tr><td>$l</td></tr>";
              }
              ?>
            </tbody>
          </table>

        </div>
      </div>
      <hr>
      <h3 class='text-center'>Add WiFi network</h3>
      <br>
      <div class="row justify-content-center">
        <div class="col col-10">
          <form method="post">
            <div class="form-group row">
              <label for="network_ssid1" class="col-sm-4 col-form-label">Network SSID</label>
              <div class="col-sm-7">
                <datalist id="aplist">
                  <?php
                  foreach ($aplist as $l) {
                    echo '<option value="' . $l . "\">\n";
                  }
                  ?>
                </datalist>
                <input type="text" class="form-control" name="ssid" list="aplist">
              </div>
            </div>
            <div class="form-group row">
              <label for="exampleInputPassword1" class="col-sm-4 col-form-label">Passphrase</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="exampleInputPassword1" name="passphrase">
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-3 xoffset-4">
                <button type="submit" class="btn btn-primary fix-button" name="submit" value="savessid">Save</button>
              </div>
              <div class="col-3">
                <button type="submit" class="btn btn-danger fix-button <?=$disabled?>" <?=$disabled?> name="submit" value="reboot">Reboot</button>
              </div>
            </div>

          </form>
          <br>
          <div class="row justify-content-center">
            <?php
            echo $resulttext;
            ?>
          </div>
        </div>
      </div>

    </div>
  </div>
  <script src="/js/jquery-3.2.1.slim.min.js"></script>
  <script src="/js/popper.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</body>

</html>