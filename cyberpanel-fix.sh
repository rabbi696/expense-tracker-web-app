#!/bin/bash

# Fix for CyberPanel deployment issues

echo "Fixing Laravel deployment issues..."

# 1. First, manually remove the config cache
echo "Removing config cache..."
rm -f bootstrap/cache/config.php

# 2. Clear all caches manually
echo "Clearing all caches manually..."
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# 3. Ensure .env is properly loaded
echo "Checking .env file..."
if [ -f .env ]; then
    echo ".env file exists"
    
    # Check if DB_CONNECTION is mysql
    if grep -q "DB_CONNECTION=mysql" .env; then
        echo "DB_CONNECTION is correctly set to mysql"
    else
        echo "ERROR: DB_CONNECTION is not set to mysql in .env"
        exit 1
    fi
else
    echo "ERROR: .env file not found!"
    exit 1
fi

# 4. Regenerate caches with correct config
echo "Regenerating application caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Try cache:clear again (should work now)
echo "Clearing application cache..."
php artisan cache:clear || echo "Cache clear failed, but continuing..."

# 6. Run migrations
echo "Running migrations..."
php artisan migrate --force

# 7. Fix permissions
echo "Fixing permissions..."
chmod -R 755 storage bootstrap/cache

# 8. Find the correct user for chown
echo "Finding correct user for file ownership..."
WEB_USER=$(stat -c '%U' /home/tracker.golamrabbi.dev/public_html)
WEB_GROUP=$(stat -c '%G' /home/tracker.golamrabbi.dev/public_html)
echo "Web user: $WEB_USER, Web group: $WEB_GROUP"

# Set ownership
chown -R $WEB_USER:$WEB_GROUP /home/tracker.golamrabbi.dev/public_html

echo "Deployment fixes completed!"
echo ""
echo "Please check your site at: https://tracker.golamrabbi.dev"
echo "If you see any errors, check: tail -f storage/logs/laravel.log"
