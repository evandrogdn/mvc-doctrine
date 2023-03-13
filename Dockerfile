FROM php:8.2.0-alpine

ARG UID=root 
ARG GID=root 
ARG USER

# Install extensions neededs from php
RUN apk add --update --no-cache \
        alpine-sdk autoconf curl curl-dev freetds-dev \
        libxml2-dev jpeg-dev openldap-dev libmcrypt-dev \
        libpng-dev libxslt-dev postgresql-dev libzip

RUN docker-php-ext-install \
    bcmath \
    calendar \
    curl \
    dom \
    fileinfo \
    gd \
    mysqli \
    pgsql \
    pdo \
    pdo_dblib \
    pdo_mysql \
    pdo_pgsql \
    xml \
    xsl

# Install Git (Used by composer to download some packeages)
RUN apk add --update --no-cache git

# Install Composer
RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Setando o user:group do conteiner para o user:group da máquina host (ver arquivo .env e docker-compose.yml)
# Assim, o Composer passa a usar o mesmo user:group do usuário do host
# Configura também as pastas para o novo usuário
RUN chown -R ${UID}:${GID} /var/www/html
RUN chown -R ${UID}:${GID} /root/.composer
RUN mkdir -p /.composer && chown -R ${UID}:${GID} /.composer
RUN mkdir -p /.config && chown -R ${UID}:${GID} /.config

# RUN rm -rf vendor/ && composer install --no-dev --ignore-platform-reqs -o -n

VOLUME /var/www/html
VOLUME /root/.composer
VOLUME /.composer
VOLUME /.config
USER ${UID}

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]