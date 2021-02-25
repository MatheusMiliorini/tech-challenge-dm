FROM php:apache

EXPOSE 80/tcp

COPY 000-default.conf /etc/apache2/sites-enabled/000-default.conf

# Instalação dos requisitos do Laravel
RUN apt-get update && \
    apt-get install unzip libtool -y && \
    apt-get clean && \
    a2enmod rewrite
