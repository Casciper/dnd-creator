FROM ubuntu:focal

ARG DEBIAN_FRONTEND=noninteractive
ARG ACCEPT_EULA=Y

# Утановка системных пакетов и настройка системы
RUN apt-get update \
    && apt-get install -y \
        gnupg curl ca-certificates unzip libssl1.1 odbcinst unixodbc unixodbc-dev libgss3 libpng-dev locales git  \
    	apt-transport-https software-properties-common\
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen

RUN add-apt-repository ppa:ondrej/php -y


RUN apt-get update  \
    && apt-get upgrade -y  \
    && apt-get install -y ca-certificates php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl php8.1-bcmath php8.1-gd  \
    php8.1-imagick imagemagick mysql-client php8.1-soap php8.1-zip --no-install-recommends
#
RUN apt-get install -y php8.1-cli unzip
    # Composer install
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin \
    && echo "alias composer='composer'" >> /root/.bashrc \
    && rm -rf ~/.composer
    # NodeJS install
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 9000
CMD ["php-fpm8.1"]
