% danwand.conf(5) danwand.conf 1.0.0
% Peter Holm
% May 2022

# NAME
danwand.conf - configuration file for the wand

# SYNOPSIS
dfodf

# DESCRITION
danwand.conf holds all the configuration options of the wand. The configuration options is
grouped in several section

# SECTIONS


## [server]


**apiserver**

        The url to the servicer the wand will connect to

**computeserver**

The url to the service the wand will send pictures for 3d computations

**register_interval**

The time between register function calls

**section2**

nr 2


apiserver

computeserver
register_interval

hw

led=i2c

web

# FILES
/etc/danwand.conf
        danwand configuration file

# ERRORS

Please be aware if the configuration file havin duplicate configurations, the parser will fail in using the configuratio
n

# CONFIGURATIION FILE EXAMPLE

[server]
apiserver = http://api.danbots.com/api/
computeserver = http://compute.danbots.com/api/
register_interval = 300

[hw]
led = i2c

[debug]
debug = False

[web]
button_press = /home/pi/scanapp/scan_2d.py
longbutton_press = ls

# AUTHOR
Peter Holm (peter@danbots.com)

# COPYRIGHT
danBots 2022

