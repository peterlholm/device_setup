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
	@echo "make raspbian\tConfigure raspbian for danwand and stop unused service"
	@echo "make help\tDisplay alternative options"

help :
	@echo "Use the following commands:\n"
	@echo "make install\tinstall all required basis sw"
	@echo "make apache\tinstall and configure apache modules"

	@echo "make disable-services\tdisable unused raspbian services"
	@echo "make service\tinstall register service"
	@echo "make python\tinstall Phython requirements"
	@echo "make hostname\tset hostname and time zone"
	@echo "make changehostname\tset new hostname"
	@echo "make user\tcreate users"
	@echo "make website\tinstall website"
	@echo "make debug\tinstall debug sw"
	@echo "make hotspot\tcreate hostapd hotspot"

hotspot:
	@echo "Installing hotspot"
	apt install hostapd
	#systemctl stop hostapd
	#systemctl disable hostapd
	cp ./config_files/systemd/hostapd.conf /etc/hostapd/hostapd.conf

dnsmasq:
	@echo "Installing dnsmasq"
	apt install dnsmasq
	#systemctl stop dnsmasq
	#systemctl unmask dnsmasq
	#systemctl disable dnsmasq
	cp ./config_files/dnsmasq.conf /etc/dsmasq.conf

apache:
	@echo "Installing Apache Webserver"
	apt install apache2 php libapache2-mod-php
	# allow apache to use camera and exec sudo
	usermod -aG video www-data
	usermod -aG sudo www-data
	test -f /etc/sudoers.d/020_www-data || echo "www-data ALL=(ALL) NOPASSWD: ALL" >/etc/sudoers.d/020_www-data
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
	chmod o+r /var/log/apache2/config.err.log /var/log/apache2/config.log
	

configmode:	hotspot
	@echo "Installing configmode"
	cp ./config_files/systemd/danwand_config.target /etc/systemd/system

install: apache website

