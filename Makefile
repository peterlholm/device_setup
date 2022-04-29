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
	@echo "make apache\tinstall and configure apache modules"
	@echo "make console\tConfigure console for hdmi and keyboard for DK"
	@echo "make raspbian-config\tdisable unused raspbian services"
	@echo "make ipv6-disable\t,Disable ipv6"
	@echo "make website\tinstall website"
	@echo "make camera-util\tInstall camera dt-blop"
	@echo "--"
	@echo "make service\tinstall register service"
	@echo "make python\tinstall Phython requirements"
	@echo "make hostname\tset hostname and time zone"
	@echo "make changehostname\tset new hostname"
	@echo "make user\tcreate users"
	
	@echo "make debugtools\tinstall debug sw"
	@echo "make hotspot\tcreate hostapd hotspot"

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
	@#systemctl disable cups.service
	@#systemctl disable cups-browsed.service
	@# dtoverlay=pi3-disable-bt

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
	apt install aptitude
	apt install avahi-utils
	apt install tcpdump dnsutils

user-peter:
	@echo generating peter 
	id peter ||  useradd -m -c "Peter Holm" -G sudo -s /bin/bash peter 
	test -f /etc/sudoers.d/020_peter || echo "peter ALL=(ALL) NOPASSWD: ALL" >/etc/sudoers.d/020_peter
	sudo usermod -a -G gpio,video peter
	sudo mkdir -p -m 700 /home/peter/.ssh
	sudo cp ./config_files/user/authorized_keys /home/peter/.ssh
	sudo chown -R peter:peter /home/peter/.ssh

debug: console debugtools user-peter

# standard linux services

hostapd:
	@echo "Installing hotspot"
	rfkill unblock wlan
	apt install hostapd
	systemctl stop hostapd
	systemctl disable hostapd
	cp ./config_files/etc/hostapd.conf /etc/hostapd/hostapd.conf
	systemctl unmask hostapd

dnsmasq:
	@echo "Installing dnsmasq"
	apt install dnsmasq
	systemctl stop dnsmasq
	systemctl unmask dnsmasq
	systemctl disable dnsmasq
	cp ./config_files/etc/dnsmasq.conf /etc/dnsmasq.d/danwand.conf
	cp ./config_files/etc/hostapd.conf /etc/hostapd/hostapd.conf

avahi:
	@echo "Installing avahi services"
	cp ./config_files/etc/avahi-danwand.service /etc/avahi/services/danwand.service

apache:
	@echo "Installing Apache Webserver"
	apt install apache2 php libapache2-mod-php
	# allow apache to use camera and exec sudo
	usermod -aG video www-data
	usermod -aG sudo www-data
	cp ./config_files/apache/020_www-data /etc/sudoers.d/
	cp ./config_files/apache/passwords /etc/apache2/
	cp ./config_files/apache/groups /etc/apache2/
	#test -f /etc/sudoers.d/020_www-data || echo "www-data ALL=(ALL) NOPASSWD: ALL" >/etc/sudoers.d/020_www-data
	#systemctl stop apache2
	a2dissite 000-default
	systemctl restart apache2

# config site

website:	danwand-state
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

config-file:
	@echo "create configuration files"
	test -f /etc/danwand.conf || cp ./conf/danwand.conf /etc/danwand.conf
	chown danwand /etc/danwand.conf


configmode:	hostapd dnsmasq
	@echo "Installing Configmode files"
	apt install avahi-utils
	cp ./config_files/systemd/* /etc/systemd/system
	cp -r ./bin/local/* /usr/local/bin/
	cp ./config_files/etc/dw_dhcpcd.conf /etc
	cp ./config_files/etc/avahi-danwand.service /etc/avahi/services
	cp ./config_files/etc/avahi.hosts /etc/avahi/hosts
	systemctl enable --now avahi-alias@wand.local.service

camera-util:	/boot/dt-blob.bin
	echo camera utils in place
	
/boot/dt-blob.bin:
	sudo wget https://datasheets.raspberrypi.org/cmio/dt-blob-cam1.bin -O /boot/dt-blob.bin

# /home/pi/.ssh/id_rsa
init-service: user-danwand config-file 
	@echo "creating danwand service"
	#test -d /home/danwand/init ||mkdir /home/danwand/init
	@echo "install pip3"
	apt-get install python3-pip
	pip3 install -r requirements.txt
	#cp ./bin/danwand_init.py /home/danwand/init/
	cp ./conf/danwand.service /etc/systemd/system/
	systemctl enable danwand.service
	systemctl restart danwand.service




users:	user-danwand 

danwand-lib:  user-danwand
	mkdir -p /var/lib/danwand 
	chown danwand:www-data /var/lib/danwand
	chmod ug+rw /var/lib/danwand

user-danwand:
	@echo generating danwand users
	id danwand ||  useradd -m -u 600 -c "DanWand user" -G sudo -s /bin/bash danwand 
	test -f /etc/sudoers.d/020_danwand || echo "danwand ALL=(ALL) NOPASSWD: ALL" >/etc/sudoers.d/020_danwand
	sudo usermod -a -G gpio,video danwand
	sudo mkdir -p -m 700 /home/danwand/.ssh
	sudo cp ./config_files/user/authorized_keys /home/danwand/.ssh
	sudo chown -R danwand:danwand /home/danwand/.ssh

hostname:
	@echo "Setting hostname to danwand"
	hostnamectl set-hostname danwand



install: raspbian-config apache website console  configmode
	@echo "All SW Installed"
