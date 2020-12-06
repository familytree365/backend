FROM php:7.4-apache

  # Install packages
RUN apt-get update && apt-get install -y \
git \
zip \
curl \
sudo \
unzip \
libicu-dev \
libbz2-dev \
libpng-dev \
libjpeg-dev \
libmcrypt-dev \
libreadline-dev \
libfreetype6-dev \
g++

  # Apache configuration
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers

  # Common PHP Extensions
RUN docker-php-ext-install \
bz2 \
intl \
iconv \
bcmath \
opcache \
calendar \
pdo_mysql

  # Ensure PHP logs are captured by the container
ENV LOG_CHANNEL=stderr

  # Set a volume mount point for your code
VOLUME /var/www/html

  # Copy code and run composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/tmp
RUN cd /var/www/tmp && composer install --no-dev

  # Ensure the entrypoint file can be run
RUN chmod +x /var/www/tmp/docker-entrypoint.sh
ENTRYPOINT ["/var/www/tmp/docker-entrypoint.sh"]

  # The default apache run command
CMD ["apache2-foreground"]
