FROM php:apache

EXPOSE 80/tcp

COPY ["000-default.conf", "test.sh", "setup.sh", "installComposer.sh", "/"]

# Instalação dos requisitos do projeto
RUN apt-get update && \
    apt-get install unzip libtool git nodejs npm -y && \
    apt-get clean && \
    a2enmod rewrite && \
    mv /000-default.conf /etc/apache2/sites-enabled/000-default.conf && \
    /installComposer.sh
