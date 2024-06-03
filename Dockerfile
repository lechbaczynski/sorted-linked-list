FROM ubuntu:24.04

WORKDIR /sortedlist

COPY  . .

RUN apt-get update
RUN apt install -y php-cli unzip curl php-xml php-mbstring
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
# RUN HASH=`curl -sS https://composer.github.io/installer.sig` php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('/tmp/composer-setup.php'); } echo PHP_EOL;"
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN composer install

CMD vendor/bin/phpunit tests/
