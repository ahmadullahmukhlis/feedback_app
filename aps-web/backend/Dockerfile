FROM ubuntu:22.04
LABEL maintainer="Ahmad Edris Malia"
WORKDIR /var/www
RUN apt-get -y update
ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get install -y php8.1-fpm
RUN apt-get -y update
RUN apt-get install -y php8.1-cli
RUN apt-get install -y php8.1-common
RUN apt-get install -y php8.1-mysql
RUN apt-get install -y php8.1-zip
RUN apt-get install -y php8.1-gd
RUN apt-get install -y php8.1-mbstring
RUN apt-get install -y php8.1-curl
RUN apt-get install -y php8.1-xml
RUN apt-get install -y php8.1-bcmath
RUN apt-get install -y supervisor
RUN apt-get install -y mysql-client

RUN apt-get install -y software-properties-common
RUN apt-get install -y php-pear php8.1-dev
RUN curl https://packages.microsoft.com/keys/microsoft.asc | tee /etc/apt/trusted.gpg.d/microsoft.asc
RUN curl https://packages.microsoft.com/config/ubuntu/$(lsb_release -rs)/prod.list | tee /etc/apt/sources.list.d/mssql-release.list
RUN apt-get update
RUN ACCEPT_EULA=Y apt-get install -y msodbcsql18
RUN # optional: for bcp and sqlcmd
RUN ACCEPT_EULA=Y apt-get install -y mssql-tools18
RUN echo 'export PATH="$PATH:/opt/mssql-tools18/bin"' >> ~/.bashrc
RUN /bin/bash -c "source ~/.bashrc"
RUN # optional: for unixODBC development headers
RUN apt-get install -y unixodbc-dev
RUN pecl config-set php_ini /etc/php/8.1/fpm/php.ini

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN composer clear-cache
COPY ./composer.json .
RUN composer install --no-interaction --no-plugins --no-scripts --ignore-platform-req=ext-zip --ignore-platform-req=ext-sockets

COPY . .
RUN chown -R www-data.www-data /var/www/storage
RUN chown -R www-data.www-data /var/www/bootstrap/cache

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /usr/local/bin/start-container

EXPOSE 6001
EXPOSE 80
ENTRYPOINT ["start-container"]

