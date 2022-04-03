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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">DanWand</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="/wifi.php">WiFi Configuration</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Debug</a>
        </li>
      </ul>
    </div>
  </nav>
  <div>
    <h2>Current WiFi configuration</h2>

    <?php
    $cmd = "sudo /usr/sbin/wpa_cli list_networks";
    $res = exec($cmd, $out, $result);
    print_r($out);
    print("result". $result);
    print('res'. $res);
    ?>
    <br>
    <hr>
    <form>
      <h2>Configure new WIFI network</h2>
      <div class="form-group">
        <label for="network_ssid1">Network SSID</label>
        <input type="network_ssid" class="form-control" id="network_ssid1" aria-describedby="emailHelp"
          placeholder="Enter SSID">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    Finito
</div>
    <script src="/js/bootstrap.min.js"></script>

</body>

</html>