<?php

$windows = 0;
if (PHP_OS == 'WINNT') {
    $windows = 1;
    $config_dir = "config";
}

# get OS information

function get_hw_info()
{
    global $windows;
    if ($windows) return "na";
    $cmd = "cat /proc/device-tree/model";
    unset($output);
    $r = exec($cmd, $output, $result);
    return $output[0];
}

# get networks information

function get_ip_address()
{
    global $windows;
    if ($windows) return("Unknown");
    return($_SERVER['SERVER_ADDR']);
}

function get_eth_mac()
{   
    global $windows;
    if ($windows) return("Unknown");
    $out = exec('ifconfig eth0 | grep ether | tr -s " " | cut -d " " -f 3');
    return $out;
}

function get_wifi_mac()
{
    $out =  exec('ifconfig wlan0 | grep ether | tr -s " " | cut -d " " -f 3');
    return($out);
}

function read_config_file($file, &$ssid, &$passphrase)
{
    $content = parse_ini_file($file);
    $ssid = $content['ssid'];
    $passphrase = $content['passphrase'];
    return;
}

# internet
function internet_connection()
{
    global $windows;
    if ($windows) 
        $out = exec('ping -w 500 -n 1 8.8.8.8', $output, $res);
    else
        $out = exec('ping -w 1 -c 1 8.8.8.8', $output, $res);
    #print ("res ".$res);
    #print $out;
    if ($res) return "Not OK";
    return "OK";
    return $out;
}

# get wifi information

function get_ap_list()
{   
    unset($output);
    // $cmd = 'wpa_cli scan_result | cut -f5';
    // $cmd = '/sbin/wpa_cli scan_result  ';
    $cmd = "sudo iwlist wlan0 scan | sed -n -e '/ESSID/s/" . '.*ESSID:"\(.*\)".*/\1/p' . "'";
    //echo $cmd;
    $r =    exec($cmd, $output, $result);
    // echo "Result: $result r: $r\n";
    // print_r($output);
    return array_unique($output);
}

function get_wifi_list() 
{
    $cmd = 'sudo iwlist wlan0 scan | egrep "Cell|ESSID|Signal|Rates"';
    $res = exec ($cmd, $output, $result);
    $out = implode("<br>\n", $output);
    return $out;
}

function create_wpa_config($path, $ssid, $passphrase)
{
    $config_content = "network={\nssid=\"$ssid\"\npsk=\"$passphrase\"\nkey_mgmt=WPA-PSK\n}\n";
    if (!file_put_contents($path, $config_content))
        echo "wpa_file_put_content went wrong";
}


function get_wifi_status()
{
    unset($output);
    $cmd = 'iwconfig wlan0';
    $r =    exec($cmd, $output, $result);
    //echo "Result: $result r: $r\n";
    //print_r($output);
    return "<pre>".implode("\n",$output)."</pre>"; 
}





//print_r($_SERVER);
$pl['HW Info'] = get_hw_info();
$pl['Rasbian'] = exec('grep "VERSION=" /etc/os-release');
$pl['HostName'] = gethostname();
$pl["Server Software"] =  $_SERVER['SERVER_SOFTWARE'];
$pl['Python 2'] = exec('python --version 2>&1');
$pl['Python 3'] = exec('python3 --version 2>&1');
$pl["ServerName"] =  $_SERVER['SERVER_NAME'];
if (!$windows)
    $pl["Server IP addr"] =  $_SERVER['SERVER_ADDR'];
$pl["Ether MAC"] =  exec('ifconfig eth0 | grep ether | tr -s " " | cut -d " " -f 3');
$pl["Wlan MAC"] =  exec('ifconfig wlan0 | grep ether | tr -s " " | cut -d " " -f 3');

$totalmem = exec('grep MemTot /proc/meminfo| tr -s " " |cut -d " " -f 2');
$freemem = exec('grep MemFree /proc/meminfo| tr -s " " |cut -d " " -f 2');
unset($output);
$mem = exec('head -5 /proc/meminfo', $output);
$str = "";
foreach ($output as $o) $str .= $o . "<br>";
unset($output);
$str2="";
$mem = exec('df -h / /boot | tail -3',$output);
foreach ($output as $o) $str2 .= $o . "<br>";
$pl2["Memory"] = $str;
$pl2["Total Disk"] = $str2;
$pl2['Load'] = exec('cat /proc/loadavg');
$pl2['Batteri Level'] = '<progress id="battery" value="90" max="100">90%</progress>';
?>


