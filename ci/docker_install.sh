#!/bin/bash

[[ ! -e /.dockerenv ]] && exit 0

set -xe

apt-get update -yqq
apt-get install -yqq --fix-missing \
  apt-utils \
  git \
  libz-dev zlib1g-dev libzip-dev \
  zip unzip

pecl install -o -f \
  redis \
  memcache \
  xdebug

rm -rf /tmp/pear

docker-php-ext-install \
  zip

docker-php-ext-enable \
  redis \
  memcache \
  xdebug

# Install composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
composer install