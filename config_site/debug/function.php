<?php
$configdir = '/etc/';
$OS = 1;
print(PHP_OS);
if (PHP_OS == 'WINNT') {
    $configdir = "../conf/";
    $OS=0;
}

$function = false;
if (isset(($_REQUEST['function']))) {
    $function = $_REQUEST['function'];
    switch ($function) {
        case 'takepic':
            // Linux raspberrypi 5.10
            // exec('grep 'VERSION_ID="11"'VERSION=" /etc/os-release');
            switch($OS) {
                case 2:
                    print("libcam");
                    $res = exec('libcamera-still -o /var/www/danwand/tmp/pic.jpg', $out, $result);
                    break;
                case 1:
                    $res = exec('sudo raspistill -o /var/www/danwand/tmp/pic.jpg', $out, $result);
                    if ($result != 0) {
                        copy ('../pic/db_logo.jpg', '/tmp/pic.jpg');
                        $result = 0;
                    }
                    break;
                default:
                    copy ('../pic/db_logo.jpg', '/tmp/pic.jpg');
                    $res = 0;
                    break;
            }
            echo "out: $res <br>";
            echo "Result:  $result <br>";
            if ($result==70) echo "Camara not enabled in build<br>"; 
            echo "Output:<br>".implode($out);
            //header('Location: tmp/pic.jpg');
            if ($result == 0) header('Location: display-pic.php');
            break;
        case 'takevideo':
            # MP4Box -add pivideo.h264 pivideo.mp4
            $res = exec('raspivid -o /tmp/video.h264 -t 10000 ; MP4Box -add /tmp/video.h264 /var/www/danwand/tmp/video.mp4', $out, $result);
            echo "out: $res <br>";
            echo "Result:  $result <br>";
            if ($result==70) echo "Camara not enabled in build<br>"; 
            echo "Output:<br>".implode($out);
            //header('Location: tmp/pic.jpg');
            header('Location: display-video.php');
            break;
        case 'mjpeg':
            $res = exec('mjpeg-server.sh');
            echo $res;
            header('Location: /:8554');
            break;   
    }
}
?>
<!DOCTYPE html>
<html lang="uk">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danwand Configuration - debug</title>
  <link rel="icon" href="/pic/db_logo_icon.png" type="image/png">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/site.css" />
</head>

<htmlx class="onepage"/>

<body>
<br>
<?php
switch ($function) {
    case 'button':
    case 'longbutton':
    case 'doublebutton':
        echo "<h2>Button ". $function ."</h2><hr>";
        $inifilepath = $configdir . "danwand.conf";
        $config = parse_ini_file($inifilepath, true);
        $index = $function . "_press";
        if (isset($config['web'][$index])) {
            $cmd = $config['web'][$index];
            echo "<h3>udfører: $cmd </h3>";
            exec($cmd, $out, $res);
            echo "<p>Output:</p><pre>";
            echo htmlspecialchars(implode("\n",$out));
            echo "</pre><h3>Result: " . $res . "</h3>";
        }
    break;
    case 'stich':
        echo "<h2>Stich</h2><hr>";
        $cmd = "/home/pi/scanapp/scan_2d.py";
        echo "<h3>udfører: $cmd </h3>";
        exec($cmd, $out, $res);
        echo "<p>Output:</p><pre>";
        echo htmlspecialchars(implode("\n",$out));
        echo "</pre><h3>Result: " . $res . "</h3>";
        break;    
    }
?>  
<br><br>
<a href="/">
    <button formaction="/debug.php" type="button" name="submit" value="index" class="button" style="background-color: green">Return</button>
</a>
</body>
</html>