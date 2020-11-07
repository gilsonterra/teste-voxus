#!/bin/bash

composer install && rm -rf /root/.composer

# Starting FPM
[ ! -z  ${TEST_MODE} ] && vendor/bin/phpunit || php-fpm
