<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Danwand Debug</title>
    <meta name='viewport' content='width=device-width, height=device-height, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='wstyle.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='http://wand.danbots.net4us.dk/wand_0.1/wstyle.css'>
</head>

<body>
   <div class="container">
    <h1>DanWand Debug</h1>
         <?php
         $configdir = '/etc/';
        if (PHP_OS == 'WINNT') {
            $configdir = "../conf/";
            if (isset($_REQUEST['test'])) {
                $cmd = "ls";
                echo $cmd;
                $ud =system($cmd);
                echo $ud;
            }
        }

        $webservice = "http://" . $_SERVER['SERVER_ADDR'] . ":8080/";
        if (PHP_OS == 'WINNT') {
            $config_dir = "config";
        }

        if (isset($_REQUEST['button'])) {
            $inifilepath = $configdir . "danwand.conf";
            $config = parse_ini_file($inifilepath,true);
            #print_r($config);

            $button = $_REQUEST['button'];
            switch ($button) {
                case "train1":
                case "train2":
                case "train3":
                        if (isset($config['web'][$button])) {
                        $cmd = $config['web'][$button];
                        echo $cmd;
                        echo(exec($cmd, $out, $res));
                        echo "<p>Output:</p><pre>";
                        echo htmlspecialchars(implode("\n",$out));
                        echo "</pre><h3>Result: " . $res . "</h3>";
                    }
                    else
                        echo "no config in /etc/danwand.conf";
                    break;
                default:
                    echo "Button $button is not implemented yet";
                    break;
            }
        }
        ?>
        <div class="menu">
            <a href="function.php?function=takepic"><button class="btn btn-large menubutton btn-danger xfix-button">Take Picture</button></a>
            <a href="<?=$webservice?>pic/cam"><button class="menubutton smallbutton">Cam</button></a>
            <a href="<?=$webservice?>3d/3d"><button class="menubutton smallbutton">3D Scan</button></a>
        </div>
        <br>

        <div class="menu">
            <a href="<?=$webservice?>3d/3dias"><button class="menubutton smallbutton">Take Training Set</button></a>
            <a href="function.php?function=takevideo"><button class="menubutton smallbutton">Take Video</button></a>
            <a href="display.php?function=log&file=/var/log/syslog"><button class="menubutton smallbutton">Syslog</button></a>
        </div>
        <br>
        <div class="menu">
            <a href="display.php?function=log&file=/var/log/apache2/danwand.log"><button class="menubutton smallbutton">Website  log</button></a>
            <a href="display.php?function=log&file=/var/log/apache2/danwand.err.log"><button class="menubutton smallbutton">Website error log</button></a>
            <a href="display.php?function=log&file=/var/log/apache2/error.log"><button class="menubutton smallbutton">Apache error log</button></a>
        </div>
        <br>
        <div class="menu">
            <a href="display.php?function=log&file=/var/log/webservice.log"><button class="menubutton smallbutton">Webservice Log</button></a>
            <a href="display.php?function=log&file=/var/log/danwand.log"><button class="menubutton smallbutton">DanWand log</button></a>
            <a href="/"><button class="menubutton smallbutton">Return</button></a>
        </div>
        <br>
        <!-- <div class="menu">
            <a href="debug.php?button=train1"><button class="menubutton smallbutton">Train 1</button></a>
            <a href="debug.php?button=train2"><button class="menubutton smallbutton">Train 2</button></a>
            <a href="debug.php?button=train3"><button class="menubutton smallbutton">Train 3</button></a>
        </div>
        <br>
        <div class="menu">
            <a href="debug.php?button=1"><button class="menubutton smallbutton">Debug 1</button></a>
            <a href="debug.php?button=2"><button class="menubutton smallbutton">Debug 2</button></a>
            <a href="debug.php?button=3"><button class="menubutton smallbutton">Debug 3</button></a>
        </div> -->
        <br>
        <a href="/">Return</a>
    </div>
</body>

</html>