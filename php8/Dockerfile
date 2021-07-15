FROM php:8.0.7-apache

ENV ACCEPT_EULA=Y

# primeira atualização
RUN apt-get update && apt-get upgrade -y

# aplicativos básicos para o servidor
RUN apt-get install -y apt-utils \
    libcurl4-gnutls-dev \
    libxml2-dev \
    wget \
    vim \
    unzip \
    redis-server \
    libxml2 \
    zlib1g-dev \
    libicu-dev \
    g++ \
    gnupg2 \
    freetype* \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libfreetype6-dev \
    libzip-dev \
    libaio1 \
    libonig-dev

# limpeza
RUN apt-get clean autoclean && apt-get autoremove -y && rm -rf /var/lib/{apt,dpkg,cache,log}/

# ORACLE oci 
RUN mkdir /opt/oracle && cd /opt/oracle     

# move o instant client pra o docker
ADD /instantclient-basic-linux.x64-12.1.0.2.0.zip /opt/oracle
ADD /instantclient-sdk-linux.x64-12.1.0.2.0.zip /opt/oracle

# Install Oracle Instantclient
RUN  unzip /opt/oracle/instantclient-basic-linux.x64-12.1.0.2.0.zip -d /opt/oracle \
    && unzip /opt/oracle/instantclient-sdk-linux.x64-12.1.0.2.0.zip -d /opt/oracle \
    && ln -s /opt/oracle/instantclient_12_1/libclntsh.so.12.1 /opt/oracle/instantclient_12_1/libclntsh.so \
    && ln -s /opt/oracle/instantclient_12_1/libclntshcore.so.12.1 /opt/oracle/instantclient_12_1/libclntshcore.so \
    && ln -s /opt/oracle/instantclient_12_1/libocci.so.12.1 /opt/oracle/instantclient_12_1/libocci.so \
    && rm -rf /opt/oracle/*.zip

ENV LD_LIBRARY_PATH  /opt/oracle/instantclient_12_1:${LD_LIBRARY_PATH}

# Microsoft SQL Server Prerequisites
RUN apt-get update \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/9/prod.list \
    > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get install -y --no-install-recommends \
    locales \
    apt-transport-https \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen \
    && apt-get update \
    && apt-get -y --no-install-recommends install \
    unixodbc-dev \
    msodbcsql17

# extensoes básicas do php e xdebug
RUN docker-php-ext-install curl \
    xml \
    mbstring \
    bcmath \
    gd \
    pdo \
    pdo_mysql \ 
    sockets \
    && pecl install xdebug && docker-php-ext-enable xdebug

#intl
RUN docker-php-ext-configure intl && docker-php-ext-install intl

# gd
#RUN docker-php-ext-configure gd --with-gd --with-webp-dir \
#    --with-png-dir --with-zlib-dir --with-xpm-dir \
#    --with-jpeg-dir=/usr/lib \
#    --with-freetype-dir=/usr/include/freetype2

# Install Oracle extensions
RUN echo 'instantclient,/opt/oracle/instantclient_12_1/' | pecl install oci8-3.0.1 && docker-php-ext-enable oci8 \ 
    && docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/opt/oracle/instantclient_12_1,12.1 && docker-php-ext-install pdo_oci 

# Install SQLSRV extensions
RUN pecl install sqlsrv pdo_sqlsrv && docker-php-ext-enable sqlsrv pdo_sqlsrv

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# cria a pasta publica e permissão geral
RUN mkdir /var/www/html/public
RUN chmod -R 777 /var/www/html/*

# configs báscias
COPY vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY php.ini /usr/local/etc/php/php.ini
COPY redis.conf /etc/redis/redis.conf

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite
RUN service apache2 restart
RUN service redis-server restart
