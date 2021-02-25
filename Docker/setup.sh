#!/bin/bash
cd /var/www/html
composer install
cp .env.example .env
php artisan key:generate
npm i -D
