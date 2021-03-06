# INSTALL

This document explains about how to install and setup playSMS version 1.0.0


## Requirements

Most of on the requirements on this list must be fulfilled. Please read this
part before starting the installation.

**Minimum required hardware:**

* Web server capable hardware

Optional hardware or infrastructure:

* GSM modem, single/modem pool (only when you plan to use Kannel, Gammu, Gnokii
  or smstools gateway plugins)
* Internet connection (only when you plan to use Clickatell, Nexmo, Twilio,
  Infobip gateway plugins)
* LAN (only when you plan to link 2 playSMS on different server in the same
  network using Uplink gateway plugin)

**Minimum required softwares:**

* Operating System Linux
* Web server software (for example Apache2, nginx or lighttpd)
* Database Server MySQL 5.x.x or latest stable release
* PHP 5.3 or latest stable release with mysql module enabled
* PHP CLI (very important, do not forget this)
* PHP PEAR and PHP PEAR-DB (very important, do not forget this)
* PHP gettext extension (for text translation)
* PHP mbstring extension (for unicode detection)
* PHP GD extension (to draw graphs)
* Access to SMTP server (playSMS will use this to send email)
* Console browser such as lynx, wget or curl
* Downloaded playSMS package from SF.net or latest source code from
  Github
* Properly installed composer from https://getcomposer.org

**Minimum required server administrator (or developer):**

* Understand howto make sure required softwares are installed
* Understand howto make sure installed PHP has MySQL module
  enabled/loaded
* Understand howto create/drop MySQL database
* Understand howto insert SQL statements into created database
* Basic knowledges to manage Linux (skill to navigate in console mode)


## Installation

There are 2 methods explained in this document to install playSMS:

1. Installation on Linux using install-script
2. Installation on Linux step by step

You should pick only one method, do not do both methods.


### Method 1: Installation on Linux using install-script

Install playSMS using install script `install-playsms.sh`

1. Extract playSMS package somewhere (For example in /usr/local/src).

   ```
   tar -zxf playsms-1.0.0.tar.gz -C /usr/local/src
   ls -l /usr/local/src/
   cd /usr/local/src/playsms-1.0.0/
   ```

2. Copy install.conf.dist to install.conf and edit install.conf. 
   Then read install.conf and make changes to suit your system configuration

   ```
   cp install.conf.dist install.conf
   vi install.conf
   ```

3. Run installer script

   ```
   ./install-playsms.sh
   ```

4. Configure rc.local to get playsmsd started on boot
   
   Look for rc.local on /etc, /etc/init.d, /etc/rc.d/init.d
      
      When you found it edit that rc.local and put:

      `/usr/local/bin/playsmsd start`

      on the bottom of the file (before exit if theres an exit command).
      This way playsmsd will start automatically on boot.
      
      You can use the provided script for debian/ubuntu
      ```
      cp daemon/playsms /etc/init.d/playsms
      update-rc.d-insserv playsms defaults
      ```

Note:
   
* After successful installation, please run command `ps ax` and see if
  playsmsd is running

  ```
  ps ax | grep playsms
  4069 pts/12  S    0:00 /usr/bin/php -q /usr/local/bin/playsmsd schedule
  4071 pts/12  S    0:00 /usr/bin/php -q /usr/local/bin/playsmsd dlrssmsd
  4073 pts/12  S    0:00 /usr/bin/php -q /usr/local/bin/playsmsd recvsmsd
  4075 pts/12  S    0:00 /usr/bin/php -q /usr/local/bin/playsmsd sendsmsd
  ```

* Run several checks

  ```
  playsmsd status
  playsmsd check
  ```

* Stop here and review your installation steps when playsmsd is not running
* Consider to ask question in playSMS forum when you encountered a problem
* If all seems to be correctly installed you may try to login from web by
  browsing `http://<your web server IP>/playsms/` and login using default
  administrator user

  ```
  username: admin
  password: admin
  ```


### Method 2: Installation on Linux step by step

Install playSMS by following step-by-step:

1. Extract playSMS package somewhere (For example in /usr/local/src).

   ```
   tar -zxf playsms-1.0.0.tar.gz -C /usr/local/src
   ls -l /usr/local/src
   ```

2. Create playSMS web root, log, lib and set ownership to user www-data or
   web server user

   ```
   mkdir -p /var/www/playsms /var/log/playsms /var/lib/playsms
   chown -R www-data /var/www/playsms /var/log/playsms /var/lib/playsms
   ```
   
   There are Linux distributions using 'apache' as web server user instead of 'www-data'.

3. Copy files and directories inside 'web' directory to playSMS web root
   and set ownership again to user www-data or web server user, just to
   make sure

   ```
   cp -rR /usr/local/src/playsms-1.0.0/web/* /var/www/playsms
   chown -R www-data /var/www/playsms
   ```

4. Setup database (import database)

   ```
   mysqladmin -u root -p create playsms
   mysql -u root -p playsms < /usr/local/src/playsms-1.0.0/db/playsms.sql
   ```

   You don't need to use MySQL root access nor this method to setup playSMS
   database, but this is beyond our scope.
 
   You should read MySQL manual for custom installation method or howto insert
   SQL statements into existing database.

5. Copy config-dist.php to config.php and then edit config.php

   ```
   cp /var/www/playsms/config-dist.php /var/www/playsms/config.php
   vi /var/www/playsms/config.php
   ```

   Please read and fill all fields with correct values

6. Enter daemon/linux directory, copy files and folder inside

   ```
   cd /usr/local/src/playsms-1.0.0/daemon/linux
   cp etc/playsmsd.conf /etc/playsmsd.conf
   cp bin/playsmsd /usr/local/bin/playsmsd
   ```

7. Just to make sure every paths are correct, please edit /etc/playsmsd.conf

   ```
   vi /etc/playsmsd.conf
   ```

   Make sure that PLAYSMS_PATH is pointing to a correct playSMS installation
   path (in this example to /var/www/playsms), and make sure that PLAYSMS_BIN
   is pointing to a correct playSMS daemon scripts path (in this example to
   /usr/local/bin)

8. Start playsmsd now from Linux console, no need to reboot

      ```
      playsmsd start
      ```

9. Configure rc.local to get playsmsd started on boot
   
   Look for rc.local on /etc, /etc/init.d, /etc/rc.d/init.d
      
      When you found it edit that rc.local and put:

      `/usr/local/bin/playsmsd start`

      on the bottom of the file (before exit if theres an exit command).
      This way playsmsd will start automatically on boot.

Note:
   
* After successful installation, please run command `ps ax` and see if
  playsmsd is running

  ```
  ps ax | grep playsms
  4069 pts/12  S    0:00 /usr/bin/php -q /usr/local/bin/playsmsd schedule
  4071 pts/12  S    0:00 /usr/bin/php -q /usr/local/bin/playsmsd dlrssmsd
  4073 pts/12  S    0:00 /usr/bin/php -q /usr/local/bin/playsmsd recvsmsd
  4075 pts/12  S    0:00 /usr/bin/php -q /usr/local/bin/playsmsd sendsmsd
  ```

* Run several checks

  ```
  playsmsd status
  playsmsd check
  ```

* Stop here and review your installation steps when playsmsd is not running
* Consider to ask question in playSMS forum when you encountered a problem
* If all seems to be correctly installed you may try to login from web by
  browsing `http://<your web server IP>/playsms/` and login using default
  administrator user

  ```
  username: admin
  password: admin
  ```


## Gateway Installation

Next, choose a gateway.

If you have GSM modem and plan to use it with playSMS, please continue to follow
instructions in INSTALL_SMSSERVERTOOLS to use SMS Server Tools (smstools3) as
your gateway module, or follow INSTALL_KANNEL if you want to use Kannel.

Gnokii and Gammu also supported, please follow INSTALL_GNOKII if you want to use
Gnokii as your gateway module, or INSTALL_GAMMU if you want to use Gammu.
