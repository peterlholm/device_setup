#
# Makefile for danwand configuration
#
# 220402	PLH	First version with config mode
#

CONFDIR=conf
HOME=/home/danwand
BACKUPDIR=$(HOME)/backupconf
WEBSITEDIR=/var/www/danwand

default:
	@echo "make install\tinstall sw and set default config"
	@echo "make raspbian-config\tConfigure raspbian for danwand and stop unused service"
	@echo "make help\tDisplay alternative options"

help :
	@echo "Use the following commands:\n"
	@echo "make install\tinstall all required basis sw"
	@echo "make debug\tdebug users and console"
	@echo "make console\tConfigure console for hdmi and keyboard for DK"
	@echo "make ipv6-disable\t,Disable ipv6"
	@echo "make website\tinstall website"
	@echo "make camera-util\tInstall camera dt-blop"
	@echo "--"
	@echo "make service\tinstall register service"
	@echo "make python\tinstall Phython requirements"
	@echo "make changehostname\tset new hostname"	
	@echo "make debugtools\tinstall debug sw"


# adjust raspian service

raspbian-config:
	timedatectl set-timezone Europe/Copenhagen
	@echo "disable bluetooth"
	systemctl disable hciuart.service
	systemctl stop hciuart.service
	@#systemctl disable bluealsa.service
	systemctl disable bluetooth.service
	systemctl stop bluetooth.service
	systemctl disable apt-daily.timer
	systemctl disable apt-daily-upgrade.timer
	systemctl enable ssh.service
	@# dtoverlay=pi3-disable-bt

std-sw:
	apt update 
	apt -y install hostapd dnsmasq php apache2 libapache2-mod-php 
	apt -y install python3-pip
	apt upgrade
raspi-config:
	@echo "configure with raspi-config"
	raspi-config nonint do_legacy 0
	#raspi-config nonint do_hostname danwand
	#@echo "GPU memmory"
	#vcgencmd get_mem gpu
	# 512 M  => max 384
	#vcgencmd get_config hdmi_mode
	#vcgencmd get_config disable_camera_led

	#raspi-config nonint do_boot_behaviour B1
	#raspi-config nonint do_camera 0
	#raspi-config nonint do_i2c 0

# debugging

ipv6_disable:
	echo "net.ipv6.conf.all.disable_ipv6=0" >>/etc/sysctl.conf
	echo "net.ipv6.conf.default.disable_ipv6=0" >>/etc/sysctl.conf
	echo "net.ipv6.conf.lo.disable_ipv6=0" >>/etc/sysctl.conf
	@echo ipv6 is disabled

console:
	@echo "enable console"
	sed -i /etc/default/keyboard -e "s/^XKBLAYOUT.*/XKBLAYOUT=\"dk\"/"
	sed -i /boot/config.txt -e "s/^#config_hdmi_boost.*/config_hdmi_boost=4/"
	timedatectl set-timezone Europe/Copenhagen
	@echo "You need to reboot before changes appear"

debugtools:
	@echo "Installing debug tools"
	apt install -y aptitude
	apt install -y avahi-utils
	apt install -y tcpdump dnsutils

make-user: *.user
	@echo Making $?

user-peter:
	@echo generating peter 
	id peter ||  useradd -m -c "Peter Holm" -G sudo -s /bin/bash peter 
	test -f /etc/sudoers.d/020_peter || echo "peter ALL=(ALL) NOPASSWD: ALL" >/etc/sudoers.d/020_peter
	usermod -a -G gpio,video peter
	mkdir -p -m 700 /home/peter/.ssh
	cp ./config_files/user/authorized_keys /home/peter/.ssh
	chown -R peter:peter /home/peter/.ssh
	echo 'peter:$y$j9T$5HEecDelneptGRDCNbiRe0$2kcInTe0Lkd1W7K/DCQDlvkUtWBFrDAA17EMJM7EE54?' | chpasswd -e

user-alexander:
	@echo generating alexander 
	id alexander ||  useradd -m -c "Alexander" -G sudo -s /bin/bash alexander 
	test -f /etc/sudoers.d/020_alexander || echo "alexander ALL=(ALL) NOPASSWD: ALL" >/etc/sudoers.d/020_alexander
	usermod -a -G gpio,video alexander
	mkdir -p -m 700 /home/alexander/.ssh
	cp ./config_files/user/authorized_keys /home/alexander/.ssh
	chown -R alexander:alexander /home/alexander/.ssh
	echo 'alexander:$y$j9T$5HEecDelneptGRDCNbiRe0$2kcInTe0Lkd1W7K/DCQDlvkUtWBFrDAA17EMJM7EE54?' | chpasswd -e

debug: console debugtools user-peter user-alexander

# standard linux services

hostapd:
	@echo "Installing hotspot"
	rfkill unblock wlan
	apt install hostapd
	systemctl stop hostapd
	cp ./config_files/etc/hostapd.conf /etc/hostapd/hostapd.conf
	systemctl unmask hostapd
	systemctl disable hostapd

dnsmasq:
	@echo "Installing dnsmasq"
	apt -y install dnsmasq
	systemctl stop dnsmasq
	systemctl unmask dnsmasq
	systemctl disable dnsmasq
	cp ./config_files/etc/dnsmasq.conf /etc/dnsmasq.d/danwand.conf
	cp ./config_files/etc/hostapd.conf /etc/hostapd/hostapd.conf

apache:
	@echo "Installing Apache Webserver"
	apt -y install apache2 php libapache2-mod-php
	sed -i /etc/apache2/mods-available/mpm_prefork.conf -e "/[StartServers|MinSpareServers]/s/5/3/"
	# allow apache to use camera and exec sudo
	usermod -aG video www-data
	usermod -aG sudo www-data

apache-config:
	cp ./config_files/apache/020_www-data /etc/sudoers.d/
	cp ./config_files/apache/passwords /etc/apache2/
	cp ./config_files/apache/groups /etc/apache2/
	#test -f /etc/sudoers.d/020_www-data || echo "www-data ALL=(ALL) NOPASSWD: ALL" >/etc/sudoers.d/020_www-data
	#systemctl stop apache2
	a2dissite 000-default
	systemctl restart apache2

/var/lib/danwand/install-system: raspbian-config console debug hostapd dnsmasq apache apache-config raspi-config
	@echo standard systemfiles Installed
	mkdir -p /var/lib/danwand
	touch /var/lib/danwand/install-system

install-system:	/var/lib/danwand/install-system
	@echo System files Installed
	
# commond danwand

config-file:	/home/danwand
	@echo "create configuration files"
	test -f /etc/danwand.conf || touch /etc/danwand.conf
	chown danwand /etc/danwand.conf
	chmod a+rw /etc/danwand.conf

danwand-lib:  /home/danwand
	mkdir -p /var/lib/danwand 
	chown danwand:www-data /var/lib/danwand
	chmod ug+rw /var/lib/danwand

/home/danwand:
	@echo generating danwand user
	id danwand ||  useradd -m -u 600 -c "DanWand user" -G sudo -s /bin/bash danwand 
	test -f /etc/sudoers.d/020_danwand || echo "danwand ALL=(ALL) NOPASSWD: ALL" >/etc/sudoers.d/020_danwand
	sudo usermod -a -G gpio,video danwand
	sudo mkdir -p -m 700 /home/danwand/.ssh
	sudo cp ./config_files/user/authorized_keys /home/danwand/.ssh
	sudo chown -R danwand:danwand /home/danwand/.ssh
	sudo echo "danwand:   " | chpasswd -e

hostname:
	@echo "Setting hostname to danwand"
	hostnamectl set-hostname danwand
	sed -i /etc/hosts -e '/127.0.1.1/s/127.0.1.1\t.*/127.0.1.1\tdanwand/'
	@echo hostname changed after reboot
	#raspi-config nonint do_hostname danwand

# standard services

danwand-services:
	@echo Installing danWand Services
	cp -r ./config_files/systemd/* /etc/systemd/system
	cp -r ./bin/local/* /usr/local/bin/
	systemctl enable danwand.service

# config site

website:	danwand-lib
	@echo "Installing config site"
	rm -fr /var/www/config
	cp -r ./config_site /var/www/config
	chgrp -R www-data /var/www/config
	cp ./config_files/apache/config.conf /etc/apache2/sites-available
	a2enmod authz_groupfile
	a2ensite config.conf
	systemctl reload apache2
	touch /var/log/apache2/config.err.log /var/log/apache2/config.log
	chmod o+r /var/log/apache2/config.err.log /var/log/apache2/config.log

configmode:	config-file danwand-services python-req
	@echo "Installing Configmode files"
	apt install avahi-utils
	cp ./config_files/etc/dw_dhcpcd.conf /etc
	cp ./config_files/etc/avahi-danwand.service /etc/avahi/services
	cp ./config_files/etc/avahi.hosts /etc/avahi/hosts
	#systemctl disable --now avahi-alias@wand.local.service
	systemctl enable dw_init.service
	systemctl enable danwand.service
	systemctl restart  dw_init.service danwand.service

./bin/local/man/danwand.conf.5:	./config_files/man/danwand.conf.5.md
	pandoc ./config_files/man/danwand.conf.5.md -s -t man -o ./bin/local/man/danwand.conf.5

man:	./bin/local/man/danwand.conf.5	
	@echo man page generated
# normal mode

normalmode:
	systemctl enable danwand.service

# untestet

camera-util:	/boot/dt-blob.bin
	echo camera utils in place
	
/boot/dt-blob.bin:
	sudo wget https://datasheets.raspberrypi.org/cmio/dt-blob-cam1.bin -O /boot/dt-blob.bin

python-req:
	@echo "install pip3 and requirements"
	apt update
	apt -y upgrade
	apt-get install python3-pip
	apt -y install python3-systemd
	pip3 install -r requirements.txt

install: install-system website configmode python-req danwand-services
	@echo "All SW Installed"
