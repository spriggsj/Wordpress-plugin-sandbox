# Wordpress-plugin-sandbox
Generic Wordpress Vagrant Environment to develop Wordpress plugins 

# Set Up Local environment using Virtual Box and Vagrant

# Vagrant box ubuntu/trusty64
GO INTO GIT BASH

- mkdir new-project-name in projects folder
- cd into your new-project-name folder
- vagrant init ubuntu/trusty64

GO INSIDE VAGRANTFILE

     4. uncomment localhost:8080 on line 25 or uncomment 192.168.33.10 on line 29......either one works, your preference

AT THE BOTTOM OF THE VAGRANTFILE BEFORE THE WORD "end"

- type in config.vm.provision "shell", path: "scripts/wp-provision.sh"
- exit out of Vagrantfile

SCRIPTS FOLDER

     7.  make a scripts folder inside of your new-project-folder

- copy and paste wp-provision.sh file into scripts folder

```
#!/bin/bash
# simple vagrant provisioning script
# some coloring in outputs.
COLOR="\033[;35m"
COLOR_RST="\033[0m"
echo -e "${COLOR}---updating system---${COLOR_RST}"
apt-get update
echo -e "${COLOR}---installing some tools: zip,unzip,curl, python-software-properties---${COLOR_RST}"
apt-get install -y software-properties-common
apt-get install -y python-software-properties
apt-get install -y zip unzip
apt-get install -y curl
apt-get install -y build-essential
apt-get install -y vim
# installing mysql
# pre-loading a default password --> yourpassword
debconf-set-selections <<< "mysql-server mysql-server/root_password password secret"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password secret"
echo -e "${COLOR}---installing MySql---${COLOR_RST}"
apt-get install -y mysql-server mysql-client
# installing apache2
echo -e "${COLOR}---installing Apache---${COLOR_RST}"
apt-get install -y apache2
rm -rf /var/www/html
ln -fs /vagrant /var/www/html
# installing php 5.3
echo -e "${COLOR}---installing php---${COLOR_RST}"
apt-get install -y php5 libapache2-mod-php5 php5-mcrypt php5-curl php5-mysql php5-xdebug php5-gd
#setup the database
cd /vagrant
mysql -u root -psecret -e "DROP DATABASE IF EXISTS wordpress;"
mysql -u root -psecret -e "create database wordpress;"
mysql -u root -psecret -e "grant usage on *.* to wordpress@localhost identified by 'password';"
mysql -u root -psecret -e "grant all privileges on wordpress.* to wordpress@localhost;"
#ensure apache runs as vagrant
echo -e "${COLOR}---run apache as vagrant to avoid issues with permissions---${COLOR_RST}"
sudo sed -i 's_www-data_vagrant_' /etc/apache2/envvars
# enable mod rewrite for apache2
echo -e "${COLOR}---enabling rewrite module---${COLOR_RST}"
if [ ! -f /etc/apache2/mods-enabled/rewrite.load ] ; then
    a2enmod rewrite
fi
#deflat module for apache2
if [ ! -f /etc/apache2/mods-enabled/deflate.load ] ; then
    a2enmod deflate
fi
#enable modrewrite for htaccess
echo -e "${COLOR}---enable FollowSymLinks---${COLOR_RST}"
sudo sed -i "/VirtualHost/a <Directory /var/www/html/> \n Options Indexes FollowSymLinks MultiViews \n AllowOverride All \n Order allow,deny \n  allow from all \n </Directory>" /etc/apache2/sites-available/000-default.conf
# restart apache2
echo -e "${COLOR}---restarting apache2---${COLOR_RST}"
service apache2 restart
# install wordpress
echo -e "${COLOR}---installing wordpress---${COLOR_RST}"
cd /var/www/html
sudo wget http://wordpress.org/latest.tar.gz
sudo tar xfz latest.tar.gz
mv wordpress/* ./
rmdir ./wordpress/
rm -f latest.tar.gz
```


- GO BACK INTO GITBASH

- vagrant up

GO TO BROWSER

- refresh localhost:8080

GO BACK TO GIT BASH

- vagrant ssh
- sudo apt-get install -y phpmyadmin

2 POP UP BOXES SHOULD POP UP

- check apache2
- check yes
- make a new password = secret
- enter password = secret
- confirm password = secret

BACK IN GIT BASH

- sudo nano /etc/apache2/apache2.conf

IN NANO

----- FOR MAC USER ONLY -----

- ctrl+w for search
- search for 'user'
- add vagrant to User and add vagrant to Group

----- END OF FOR MAC USER ONLY -----

IN NANO AT THE BOTTOM OF PAGE

- type in Include /etc/phpmyadmin/apache.conf
- save and exit

BACK IN GIT BASH

- sudo service apache2 restart

GO TO BROWSER

- localhost:8080/phpmyadmin
- enter in username = root
- enter in password = secret

INSIDE OF PHPMYADMIN CREATING DATABASES

- click on Users in nav links
- click on add user
- enter in a new username
- enter in a new password
- re-type the password
- check mark the first box under Database for user
- at the bottom of the page click GO

WP_ADMIN

- in the browser go to localhost:8080/wp-admin
- highlight English (United States) then click Continue
- click Let's go

- Database Name: type in your username on line 26
- User Name: type in your username on line 26
- Password: type in your password on line 27
- LEAVE EVERYTHING ELSE AS IS

- click Run the install button

WELCOME TO WORDPRESS

**THE INFORMATION ON THIS PAGE IS DIFFERENT FROM THE PREVIOUS PAGE

- Site Title: Name it whatever you like
- Username: Use a username you will remember
- Password: Use a password you remember
- Check mark Confirm Password
- Enter in your email
- Check mark the Search Engine Visibility
- Click Install Wordpress button

LOGIN PAGE TO WORDPRESS

- Username: type in username on line 40
- Password: type in password on line 41

CONGRATS YOU ARE IN WORDPRESS ADMIN

# add .gitignore
- touch .gitignore
- nano .gitignore
- paste in the following script

```
/*
!.gitignore
!wp-content/

# Ignore Everything in the wp-content directory except for themes & plugins
wp-content/*
!wp-content/themes/
!wp-content/plugins/

# Ignore Misc File Types and Files
*.log
*.back
*.bak
*.sql
.htaccess
.maintenance`
```
