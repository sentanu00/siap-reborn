#FROM php:7.4-apache
# FROM php:7.2-apache
FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    libzip-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    nano \
    git \
    wget \
    curl \
    && rm -r /var/lib/apt/lists/* \
#    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    &&curl -sS https://getcomposer.org/installer | php -- --version=2.5.8 --install-dir=/usr/local/bin --filename=composer


RUN docker-php-ext-install mysqli pdo pdo_mysql mbstring zip gd

RUN a2enmod ssl 
RUN a2enmod socache_shmcb
RUN a2enmod rewrite
# Copy Apache virtual host configuration




RUN a2dissite 000-default.conf
COPY .apache2_conf/siap.conf /etc/apache2/sites-available/siap.conf
COPY .apache2_conf/SSL2024/ChainCA2.crt /var/imported/ssl/ChainCA2.crt
COPY .apache2_conf/SSL2024/private_key.txt /var/imported/ssl/private_key.txt
COPY .apache2_conf/SSL2024/star_probolinggokab_go_id.crt /var/imported/ssl/star_probolinggokab_go_id.crt




RUN a2ensite siap.conf

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY bkd_ci /var/www/html

# Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html

RUN cd /usr/local/etc/php/ \
    ls \
    cp php.ini-production php.ini

RUN cd /var/www/html \
  #  composer config --no-plugins audit.block-insecure false \
    composer update \
    && composer require phpoffice/phpspreadsheet:1.19.0 
#    && composer require phpoffice/phpspreadsheet:1.19.0 --ignore-platform-reqs

#RUN cd /var/www/html \
#    && composer update --no-audit \
#    && composer require phpoffice/phpspreadsheet:1.19.0 --ignore-platform-reqs --no-audit





CMD ["apache2ctl", "-D", "FOREGROUND"]
