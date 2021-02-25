#!/bin/bash
# Habilita o Shell para o usuário www-data
chsh -s /bin/bash www-data
# Roda os testes
runuser www-data -c /var/www/html/vendor/bin/phpunit
# Remove acesso ao Shell
chsh -s /usr/sbin/nologin www-data
