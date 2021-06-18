#!/bin/sh
cd /var/www
php artisan migrate  >> storage/logs/migration-logs.$(date +%Y-%m-%d_%H:%M).log 2>&1