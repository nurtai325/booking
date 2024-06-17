FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      ca-certificates \
      git && \
      docker-php-ext-configure pcntl --enable-pcntl \
      && docker-php-ext-install \
      pcntl && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

ENV NVM_DIR /usr/local/nvm
RUN mkdir -p "$NVM_DIR"; \
    curl -o- \
        "https://raw.githubusercontent.com/nvm-sh/nvm/master/install.sh" | \
        bash \
    ; \
    . $NVM_DIR/nvm.sh; \
    nvm install --lts --latest-npm

ENV NVM_DIR /usr/local/nvm
RUN mkdir -p "$NVM_DIR" \
    && curl -o- "https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh" \
    && . $NVM_DIR/nvm.sh \
    && nvm install 19.9.0

WORKDIR /var/www

ENTRYPOINT ["docker/app/start-container"]
