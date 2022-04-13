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
  $aplist = get_ap_list();


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
            <a class="nav-link active" href="/admin/wifi.php">WiFi Configuration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Advanced</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Change password</a>
          </li>

        </ul>
      </div>
    </nav>
    <div class="">
      <h3 class='text-center'>WiFi in reach</h3>
      <div class="row justify-content-center">
        <div class="col col-4">
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
      <h3 class='text-center'>Add WiFi configuration</h3>
      <div class="row justify-content-center">
        <div class="col col-10">
          <form  method="post">
            <div class="form-group row">
              <label for="network_ssid1" class="col-sm-3 col-form-label">Network SSID</label>
              <div class="col-sm-7">
                <datalist id="aplist">
                  <?php
                  foreach ($aplist as $l) {
                    echo '<option value="' . $l . "\">\n";
                  }
                  ?>
                </datalist>
                <input type="text" class="form-control" name="ssid" list="aplist">
                <!-- <input type="network_ssid" class="form-control" id="network_ssid1" aria-describedby="emailHelp" placeholder="Enter SSID"> -->
              </div>
            </div>
            <div class="form-group row">
              <label for="exampleInputPassword1" class="col-sm-3 col-form-label">Passphrase</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="exampleInputPassword1" name="passphrase">
              </div>
              <div class="col-sm-2">
                <button type="submit" class="btn btn-primary" name="submit" value="savessid">Submit</button>
              </div>
            </div>
          </form>
        </div>
        <?php
        if (isset(($_REQUEST['submit']))) {
          $function = $_REQUEST['submit'];
          if ($function == "savessid") {
            $ssid = $_REQUEST['ssid'];
            $passphrase = $_REQUEST['passphrase'];
            echo "<h4>Saving $ssid and $passphrase</h4><br>";
          }
        }
        ?>
      </div>
    </div>
  </div>
  <script src="/js/bootstrap.min.js"></script>
</body>

</html>