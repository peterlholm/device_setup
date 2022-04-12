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
	@echo "make disable-services\tdisable unused raspbian services"
	@echo "make service\tinstall register service"
	@echo "make python\tinstall Phython requirements"
	@echo "make hostname\tset hostname and time zone"
	@echo "make changehostname\tset new hostname"
	@echo "make user\tcreate users"
	@echo "make website\tinstall website"
	@echo "make debugtools\tinstall debug sw"
	@echo "make hotspot\tcreate hostapd hotspot"

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

website:
	@echo "Installing config site"
	rm -fr /var/www/config
	cp -r ./config_site /var/www/config
	chown -R pi:www-data /var/www/config
	cp ./config_files/apache/config.conf /etc/apache2/sites-available
	a2ensite config.conf
	systemctl reload apache2
	touch /var/log/apache2/config.err.log /var/log/apache2/config.log
	chmod o+r /var/log/apache2/config.err.log /var/log/apache2/config.log
	

configmode:	hostapd dnsmasq
	@echo "Installing Configmode files"
	cp ./config_files/systemd/* /etc/systemd/system
	cp -r ./bin/local/ /usr/local/bin/
	cp ./config_files/etc/dw_dhcpcd.conf /etc

console:
	@echo "enable console"
	sed -i /etc/default/keyboard -e "s/^XKBLAYOUT.*/XKBLAYOUT=\"dk\"/"
	sed -i /boot/config.txt -e "s/^#config_hdmi_boost.*/config_hdmi_boost=4/"

debugtools:
	@echo "Installing debug tools"
	apt install aptitude

raspbian-config:
	timedatectl set-timezone Europe/Copenhagen
	@echo "disable bluetooth"
	systemctl disable hciuart.service
	systemctl stop hciuart.service
	@#systemctl disable bluealsa.service
	systemctl disable bluetooth.service
	systemctl stop bluetooth.service

	@#systemctl disable cups.service
	@#systemctl disable cups-browsed.service
	@# dtoverlay=pi3-disable-bt


install: raspbian-config apache website console  configmode
	@echo "All SW Installed"
