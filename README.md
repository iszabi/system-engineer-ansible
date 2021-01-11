# System Engineer – Homework
## Description

It is a configuration management solution that configures linux-server01, based on what is shown in the image

  - The solution runs on the latest release of the CentOS Linux distribution
  - alma.com resolved on locally only
  - PHP script can be run on linux-server01 when a request arrives to http://alma.com.

(Updated for latest PHP version)

```php
<?php
	$link = mysqli_connect('localhost', 'dbuser', 'dbpassword', 'dbname');
	if (!$link) {
	die('Could not connect: ' . mysql_error());
	}
	echo 'Alma.com served successfully';
	mysqli_close($link);
?>
```
More information for rules can be found in docs/System Engineer - Homework 2020.pdf
## Prerequisites: 

- Deploy a virtual server used latest CentOS8 ISO [image](http://quantum-mirror.hu/mirrors/pub/centos/8.3.2011/isos/x86_64/CentOS-8.3.2011-x86_64-dvd1.iso) with following resources (2vCPU, 40GB disk, 2GB RAM)
- Prepaire Ansible control and target node for automated deployment
  - Install Ansible on servers
  - Create ansible user with access sudo, 
  - Reconfigure Open-SSH server for Publickey access, 
  - Configure network on same subnet on target host.

## Run playbook

After cloned emarsys repository into your Ansible control node, prepare target host,


```
$ cd ~/emarsys/alma_dot_com
$ ansible-playbook playbook.yml -i host
```
## Folder structure for Ansible Playbook

```
$ tree /home/ansible/emarsys/alma_dot_com
├── ansible.cfg
├── files
│   ├── httpd.conf
│   └── index.php
├── hosts
├── playbook.yml
├── roles
│   ├── alma.com
│   │   └── tasks
│   │       └── main.yml
│   ├── apache
│   │   ├── handlers
│   │   │   └── main.yml
│   │   └── tasks
│   │       └── main.yml
│   ├── firewall
│   │   └── tasks
│   │       └── main.yml
│   ├── hosts
│   │   ├── tasks
│   │   │   └── main.yml
│   │   └── templates
│   │       └── hosts.j2
│   ├── mysql
│   │   ├── handlers
│   │   │   └── main.yml
│   │   ├── tasks
│   │   │   └── main.yml
│   │   └── templates
│   │       └── my.cnf.j2
│   ├── php
│   │   └── tasks
│   │       └── main.yml
│   └── repos
│       └── tasks
│           └── main.yml
└── vars
    └── default.yml
```
## Server Environments

```
$ cat /etc/os-release
NAME="CentOS Linux"
VERSION="8"
ID="centos"
ID_LIKE="rhel fedora"
VERSION_ID="8"
PLATFORM_ID="platform:el8"
PRETTY_NAME="CentOS Linux 8"
ANSI_COLOR="0;31"
CPE_NAME="cpe:/o:centos:centos:8"
HOME_URL="https://centos.org/"
BUG_REPORT_URL="https://bugs.centos.org/"
CENTOS_MANTISBT_PROJECT="CentOS-8"
CENTOS_MANTISBT_PROJECT_VERSION="8"
```

- RHLE/CentOs 8
```
$ uname -a
Linux linux-server01 4.18.0-240.1.1.el8_3.x86_64 #1 SMP Thu Nov 19 17:20:08 UTC 2020 x86_64 x86_64 x86_64 GNU/Linux
```

- PHP 8

```
$ php -v
PHP 8.0.0 (cli) (built: Nov 24 2020 17:04:03) ( NTS gcc x86_64 )
Copyright (c) The PHP Group
Zend Engine v4.0.0-dev, Copyright (c) Zend Technologies
     with Zend OPcache v8.0.0, Copyright (c), by Zend Technologies
```
- MySQL

```
# mysql -V
mysql  Ver 8.0.21 for Linux on x86_64 (Source distribution)
```
## For testing results

- Check alma.com vitual domain after logged in linux-server01 over SSH console:

```
$ links http://alma.com/
```
Result is :  Alma.com served successfully

## Comment:

- There were some outdated extension used in PHP script what I've updated for newest PHP version.
- mysql_connection, mysqli_close extensions has been deprecated in PHP 5.5.0, I've used mysqli_connection in my PHP scripts for PHP 8. More info: [mysqli_close](https://www.php.net/manual/en/mysqli.close.php), [mysqli_connection](https://www.php.net/manual/en/function.mysql-connect.php)
- I have created a database for alma.com PHP script by treated separately from the root user
- All variables can be found in /vars/default.yml 

Created by Szabolcs Illes (szabolcs.illes@yahoo.com) / 30.12.2020
