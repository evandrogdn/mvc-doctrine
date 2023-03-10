FROM evandrogdn/docker-php-7

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 80