#!/bin/bash

#Install nginx
sudo apt-get update -y
sudo apt-get install nginx -y
sudo systemctl stop nginx.service
sudo systemctl start nginx.service
sudo systemctl enable nginx.service

#Install mongoDB
sudo wget -O mongodb-server.deb https://repo.mongodb.org/apt/ubuntu/dists/trusty/mongodb-org/4.0/multiverse/binary-amd64/mongodb-org-server_4.0.5_amd64.deb
sudo wget -O mongodb-client.deb https://repo.mongodb.org/apt/ubuntu/dists/trusty/mongodb-org/4.0/multiverse/binary-amd64/mongodb-org-shell_4.0.5_amd64.deb
sudo wget -O mongodb-tools.deb  https://repo.mongodb.org/apt/ubuntu/dists/trusty/mongodb-org/4.0/multiverse/binary-amd64/mongodb-org-tools_4.0.5_amd64.deb
sudo dpkg -i mongodb-server.deb
sudo dpkg -i mongodb-client.deb
sudo dpkg -i mongodb-tools.deb

#Install PHP 7.2
sudo apt-get install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update -y
sudo apt-get install php7.2-fpm php7.2-common php7.2-mongodb php-pear php7.2-dev -y

#Install MongoDB drivers
sudo pecl install mongodb -y
sudo bash
sudo echo "extension=mongodb.so" >> /etc/php/7.2/fpm/php.ini
sudo echo "extension=mongodb.so" >> /etc/php/7.2/cli/php.ini

#Create dir www
sudo mkdir /vagrant/www
sudo chmod 775 /vagrant/www
sudo chown www-data:www-data /vagrant/www
sudo ln -s /vagrant/www public_dir

#Configure nginx to support PHP 7.2-fpm
sudo cat > /etc/nginx/sites-available/default <<- EOM
server {
	listen 80 default_server;
	listen [::]:80 default_server ipv6only=on;
	root /vagrant/www;
	index index.php index.html index.htm;
	server_name mongoDB.localhost.com.br;
	location / {
		try_files \$uri \$uri/ /index.php?\$query_string;
	}
	location ~ \.php\$ {
		try_files \$uri /index.php =404;
		fastcgi_split_path_info ^(.+\.php)(/.+)\$;
		fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
		fastcgi_index index.php;
		fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
		include fastcgi_params;
	}
}
EOM
sudo service nginx restart
sudo service php7.2-fpm restart

#Install Composer
sudo apt-get install php7.2-zip unzip -y
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
HASH="$(wget -q -O - https://composer.github.io/installer.sig)"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

#Create swap allocate
sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
sudo /sbin/mkswap /var/swap.1
sudo /sbin/swapon /var/swap.1

#Install laravel
composer global require laravel/installer
export PATH=$HOME/.config/composer/vendor/bin:$PATH
source .bashrc

#Install nodejs
wget -O node-v10.15.0-linux-x64.tar.xz https://nodejs.org/dist/v10.15.0/node-v10.15.0-linux-x64.tar.xz
sudo mkdir /usr/local/lib/nodejs
sudo tar -xJvf node-v10.15.0-linux-x64.tar.xz -C /usr/local/lib/nodejs 
sudo mv /usr/local/lib/nodejs/node-v10.15.0-linux-x64 /usr/local/lib/nodejs/node-v10.15.0
sudo ln -s /usr/local/lib/nodejs/node-v10.15.0/bin/node /usr/bin/node
sudo ln -s /usr/local/lib/nodejs/node-v10.15.0/bin/npm /usr/bin/npm
sudo ln -s /usr/local/lib/nodejs/node-v10.15.0/bin/npx /usr/bin/npx
export NODEJS_HOME=/usr/local/lib/nodejs/node-v10.15.0/bin
export PATH=$NODEJS_HOME:$PATH
source .bashrc
node -v
npm version
npx -v

#Install Angular
npm install -g @angular/cli

#Install GIT
sudo apt-get install git-all -y

#Remove dependeces
sudo rm mongodb-client.deb
sudo rm mongodb-server.deb
sudo rm mongodb-tools.deb
sudo rm composer-setup.php
sudo rm node-v10.15.0-linux-x64.tar.xz
