ARG PHP_VERSION
ARG COMPOSER_VERSION

FROM composer:${COMPOSER_VERSION} AS composer
FROM php:${PHP_VERSION}-fpm AS php-fpm

RUN apt update && apt install -y \
    procps \
    acl \
    apt-transport-https \
    build-essential \
    ca-certificates \
    coreutils \
    curl \
    file \
    gettext \
    git \
    wget \
    zip \
    unzip \
    libssl-dev \
    mariadb-client \
    odbcinst \
    libodbc1

# Setup Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Setup extensões
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions xdebug oci8 sockets amqp soap gd mongodb pdo_mysql pdo_odbc

# Setup NodeJS
RUN curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.35.0/install.sh | bash
ENV NVM_DIR=/root/.nvm
ENV NODE_VERSION=8.11.4
RUN . "$NVM_DIR/nvm.sh" && nvm install v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
