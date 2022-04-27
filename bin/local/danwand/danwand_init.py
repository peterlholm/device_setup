#!/usr/bin/python3
#
# danwand init server
#
# temerature result from vcgencmd measure_temp

# pylint: disable=c-extension-no-member

import os
import platform
import subprocess
import time
import datetime
import signal
import json
import runpy
import urllib.parse
import configparser
import netifaces as ni
import requests
#import socket

PING_HOST="8.8.8.8"
REBOOT_CONFIG_TIME = 61
REGISTERINTERVAL = 300
APISERVER = "http://live.danbots.com"
COMPUTESERVER = "http://compute.danbots.com"
REGISTERPATH = "register"
xREGISTERAPI = "register?deviceid="
CONFIGFILE = "/etc/danwand.conf"
# CONFIGFILE="conf/danwand.conf"
INTERFACE = 'wlan0'
POWER_IDLE = 1.5  # watt
POWER_WIFI_IDLE = 0.9
POWER_CAMERA_ACTIVE = 1.5
CHARGE = "100"
SWVERSION = "0.1.1"
LOOPING = True

_DEBUG = False

def get_hw_info():
    try:
        hw_info = open('/proc/device-tree/model', 'r').read()
    except FileNotFoundError:
        hw_info = "Debug"
    return hw_info

HW_MODEL = urllib.parse.quote_plus(get_hw_info())

config = configparser.ConfigParser()

def check_internet():
    # start check ping google
    # Option for the number of packets as a function of
    param = '-n' if platform.system().lower()=='windows' else '-c'
    # Building the command. Ex: "ping -c 1 google.com"
    command = ['ping', param, '1', PING_HOST]
    loopcount = REBOOT_CONFIG_TIME / 60
    while loopcount>0:
        # test ping
        if subprocess.call(command) != 0:
            print("Cannot ping ", PING_HOST)
            loopcount -= 1
        else:
            return True
    return False

def goto_configmode():
    print("Starting Config Mode")
    command = ['sudu systemctl isolate config.target']
    subprocess.call(command)

def receive_signal(signal_number, frame):
    global LOOPING
    print('Received Signal:', signal_number)
    LOOPING = False

def save_config():
    with open(CONFIGFILE, 'w') as configfile:
        config.write(configfile)

def get_serial():
    try:
        wlan0 = open('/sys/class/net/wlan0/address', 'r').read()
    except FileNotFoundError:
        return None
    return wlan0.replace(':', '')

def get_ip():
    try:
        ni.ifaddresses('wlan0')
    except:
        return "Test"
    ip = ni.ifaddresses('wlan0')[ni.AF_INET][0]['addr']
    return ip

def create_url(apiserver=APISERVER):
    url = apiserver + REGISTERPATH
    return url

def create_param(deviceid, ipaddr, charge, computeserver, registerinterval):
    global HW_MODEL, SWVERSION
    params = "deviceid=" + deviceid + "&hwmodel=" + HW_MODEL + \
            "&swversion=" + SWVERSION + "&localip=" + ipaddr + "&charge=" + str(charge) + \
            "&computeserver=" + urllib.parse.quote_plus(computeserver) + \
            "&registerinterval=" + str(registerinterval)
    return params

def parse_request(data):
    update = False
    content = json.loads(data)
    if content.get('apiurl'):
        if config.get('server', 'ApiServer', fallback="") != content.get('apiurl'):
            config['server']['ApiServer'] = content.get('apiurl')
            update = True
    commandmode = content.get('commandmode')
    if commandmode == "picture":
        print("Starting picture")
        runpy.run_path('/home/danwand/danbots-scanapp/take_pic.py')
    if update:
        save_config()

def check_debug(config):
    "set debug modes"
    if config.has_section('debug'):
        if config['debug'].get('DIASLED',None):
            pass

############  starting #############

print(datetime.datetime.now(), "DanWand init Starting")

#signal.signal(signal.SIGHUP, receiveSignal)
signal.signal(signal.SIGTERM, receive_signal)
signal.signal(signal.SIGINT, receive_signal)

serial = get_serial()
if serial:
    config.read_file(open(CONFIGFILE, 'r'))
    if not config.has_section('device'):
        config.add_section('device')
    if serial != config['device'].get('deviceid'):
        config['device']['deviceid'] = serial
        save_config()

# check_debug(config)

if not check_internet():
    goto_configmode()

tick = 0
while LOOPING:
    tick -= 5
    if tick > 0:
        time.sleep(5)
        continue
    config.read_file(open(CONFIGFILE, 'r'))
    if _DEBUG:
        print('Sections: ', config.sections())
    apiserver = config['server'].get('apiserver',APISERVER)

    url = create_url(apiserver)
    deviceid = config['device']['DeviceID']
    ipaddr = get_ip()
    charge = 100
    computeserver = config['server'].get('computeserver',"")
    registerinterval = int(config['server'].get('registerinterval', REGISTERINTERVAL))
    params = create_param(deviceid, ipaddr, charge, computeserver, registerinterval)
    req_url = url + '?' + params
    tick = registerinterval
    if _DEBUG:
        print(req_url)
    try:
        r = requests.get(req_url)
    except requests.ConnectionError as ex:
        print(datetime.datetime.now(), "ConnectionError:", ex)
    except requests.Timeout:
        print(datetime.datetime.now(), "TimeOut:", ex)
    except requests.exceptions.RequestException as ex:
        print("RequestException:", ex)
    else:
        if r:
            print(datetime.datetime.now(),'Register')
            print(r.text)
            parse_request(r.text)
        else:
            print('Noget gik galt: ', r.status_code)
            print('URL:', req_url)

print(datetime.datetime.now(), "Receive signal - closing")
