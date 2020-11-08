#!/bin/bash

composer install && 
rm -rf /root/.composer &&
chmod -R 777 ./storage 

# Starting FPM
[ ! -z  ${TEST_MODE} ] && vendor/bin/phpunit || php-fpm
