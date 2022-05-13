<?php
$configdir = '/etc/';
if (PHP_OS == 'WINNT') {
    $configdir = "../conf/";
}
$NEWOS = 1;

$function = false;
if (isset(($_REQUEST['function']))) {
    $function = $_REQUEST['function'];
    switch ($function) {
        case 'takepic':
            // Linux raspberrypi 5.10
            // exec('grep 'VERSION_ID="11"'VERSION=" /etc/os-release');
            if ($NEWOS) {
                print("libcam");
                $res = exec('libcamera-still -o /var/www/danwand/tmp/pic.jpg', $out, $result);
            } else {
                $res = exec('sudo raspistill -o /var/www/danwand/tmp/pic.jpg', $out, $result);
            }
            echo "out: $res <br>";
            echo "Result:  $result <br>";
            if ($result==70) echo "Camara not enabled in build<br>"; 
            echo "Output:<br>".implode($out);
            //header('Location: tmp/pic.jpg');
            header('Location: display-pic.php');
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
<html class="onepage">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Danwand Configuration</title>
    <meta name='viewport' content='width=device-width, height=device-height, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='wstyle.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='http://wand.danbots.net4us.dk/wand_0.1/wstyle.css'>
</head>

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