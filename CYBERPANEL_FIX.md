# CyberPanel Deployment Fix

The error you're seeing is because Laravel is trying to use SQLite instead of MySQL. Here's how to fix it:

## Quick Fix Commands

Run these commands in order on your server:

```bash
cd /home/tracker.golamrabbi.dev/public_html

# 1. Remove old config cache
rm -f bootstrap/cache/config.php

# 2. Clear cache directories manually
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# 3. Verify your .env file has correct database settings
cat .env | grep DB_

# Should show:
# DB_CONNECTION=mysql
# DB_HOST=localhost
# DB_PORT=3306
# DB_DATABASE=trac_expenses
# DB_USERNAME=trac_expenses
# DB_PASSWORD=A8f0Glp028uamkpN

# 4. Regenerate config cache with correct settings
php artisan config:cache

# 5. Now cache:clear should work
php artisan cache:clear

# 6. Continue with other commands
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# 7. Fix permissions
chmod -R 755 storage bootstrap/cache

# 8. Find correct user (CyberPanel usually uses nobody:nobody)
ls -la /home/tracker.golamrabbi.dev/ | grep public_html

# 9. Set ownership (adjust user if needed)
chown -R nobody:nobody /home/tracker.golamrabbi.dev/public_html
```

## Alternative: Upload the fix script

1. Upload `cyberpanel-fix.sh` to `/home/tracker.golamrabbi.dev/public_html/`
2. Make it executable: `chmod +x cyberpanel-fix.sh`
3. Run it: `./cyberpanel-fix.sh`

## Check if site is working

Visit: https://tracker.golamrabbi.dev

## If you still see errors

1. Check Laravel logs:
   ```bash
   tail -100 storage/logs/laravel.log
   ```

2. Check PHP error logs:
   ```bash
   tail -100 /usr/local/lsws/logs/error.log
   ```

3. Verify database connection:
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

## Common CyberPanel Users

- `nobody:nobody` - Most common
- `www-data:www-data` - Sometimes used
- The domain name as user (less common)

To check which user your web server is using:
```bash
ps aux | grep lsphp
```
