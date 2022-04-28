<?php
//  220428  PLH first version

function get_hw_info()
{
    global $windows;
    if ($windows) return "Windows";
    $cmd = "cat /proc/device-tree/model";
    unset($output);
    $r = exec($cmd, $output, $result);
    return $output[0];
}

function battery_power_level() {
    return 88;
}

# internet

function internet_connection($server = 1)
{
    global $windows;
    switch ($server) {
        case 1:
            $addr = "8.8.8.8";
            break;
        case 2:
            $addr = "live.danbots.com";
            break;
        case 3:
            $addr = "dummy.holmnet.dk";
            break;
        default:
            $addr = "8.8.8.8";
    }
    if ($windows)
        $out = exec("ping -w 500 -n 1 $addr", $output, $res);
    else
        $out = exec("ping -w 1 -c 1 $addr", $output, $res);
    #print ("res ".$res);
    #print $out;
    if ($res==0) return true;
    return false;
    return "OK";
    return $out;
}

# mode shift

function system_set_mode($val = "reboot")
{
    switch ($val) {
        case "reboot":
            $cmd = "sudo systemctl reboot";
            break;
        case "config":
            $cmd = "sudo systemctl isolate config.target";
            break;
        case "halt":
            $cmd = "sudo systemctl halt";
            break;
        default:
            $cmd = "sudo systemctl isolate multi-user.target";
            break;
    }
    $cmd = "sudo systemctl reboot";
    $r = exec($cmd, $output, $result);
    return;
}


# config file functions

function read_config_file($file, &$ssid, &$passphrase)
{
    $content = parse_ini_file($file);
    $ssid = $content['ssid'];
    $passphrase = $content['passphrase'];
    return;
}


//print_r($_SERVER);
// $pl['HW Info'] = get_hw_info();
// $pl['Rasbian'] = exec('grep "VERSION=" /etc/os-release');
// $pl['HostName'] = gethostname();
// $pl["Server Software"] =  $_SERVER['SERVER_SOFTWARE'];
// $pl['Python 2'] = exec('python --version 2>&1');
// $pl['Python 3'] = exec('python3 --version 2>&1');
// $pl["ServerName"] =  $_SERVER['SERVER_NAME'];
// if (!$windows)
//     $pl["Server IP addr"] =  $_SERVER['SERVER_ADDR'];
// $pl["Ether MAC"] =  exec('ifconfig eth0 | grep ether | tr -s " " | cut -d " " -f 3');
// $pl["Wlan MAC"] =  exec('ifconfig wlan0 | grep ether | tr -s " " | cut -d " " -f 3');

// $totalmem = exec('grep MemTot /proc/meminfo| tr -s " " |cut -d " " -f 2');
// $freemem = exec('grep MemFree /proc/meminfo| tr -s " " |cut -d " " -f 2');
// unset($output);
// $mem = exec('head -5 /proc/meminfo', $output);
// $str = "";
// foreach ($output as $o) $str .= $o . "<br>";
// unset($output);
// $str2="";
// $mem = exec('df -h / /boot | tail -3',$output);
// foreach ($output as $o) $str2 .= $o . "<br>";
// $pl2["Memory"] = $str;
// $pl2["Total Disk"] = $str2;
// $pl2['Load'] = exec('cat /proc/loadavg');
// $pl2['Batteri Level'] = '<progress id="battery" value="90" max="100">90%</progress>';
// 

