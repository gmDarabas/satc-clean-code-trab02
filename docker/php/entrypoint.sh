#!/bin/sh

# Fix para copiar a vendor do processo de build
if [! -d "/var/www/html/vendor"]; then
    cp -r /var/www/vendor /var/www/html/vendor
fi

exec php-fpm
