# Utilise une image PHP-FPM avec Apache
FROM php:8.2-apache

# Installer des dépendances système et PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    git \
    zip \
    curl \
    npm \
    && docker-php-ext-install pdo pdo_mysql

# Installer les extensions PHP nécessaires
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions intl opcache

# Installer Composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

ENV APP_ENV=dev

# Copier le code du projet
COPY . /var/www/
WORKDIR /var/www/

RUN composer install --optimize-autoloader --classmap-authoritative

# Permissions
RUN chown -R www-data:www-data /var/www 

# Instaurer un ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY apache.conf /etc/apache2/conf-available/servername.conf
RUN a2enconf servername

ENTRYPOINT ["apache2-foreground"]

# Exposer le port 80
EXPOSE 80
