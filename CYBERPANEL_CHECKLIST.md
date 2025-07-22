# CyberPanel Deployment Checklist

## ✅ Completed Steps
- [x] Created database: `trac_expenses`
- [x] Created database user: `trac_expenses`
- [x] Uploaded database backup
- [x] Uploaded application files

## 📋 Remaining Steps

### 1. Update .env file
Replace your current .env with the content from `cyberpanel-env-update.txt`

### 2. SSH into your server and run these commands:
```bash
cd /home/tracker.golamrabbi.dev/public_html

# Install dependencies
composer install --optimize-autoloader --no-dev

# Clear and cache configurations
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (if needed)
php artisan migrate --force

# Create storage link
php artisan storage:link

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R tracker.golamrabbi.dev:tracker.golamrabbi.dev /home/tracker.golamrabbi.dev/public_html
```

### 3. Configure Document Root in CyberPanel
1. Go to Websites → List Websites → Manage
2. Click on "vHost Conf"
3. Find the line with `docRoot`
4. Change it to: `docRoot /home/tracker.golamrabbi.dev/public_html/public`
5. Save and restart LiteSpeed

### 4. Enable SSL Certificate
1. Go to Websites → List Websites → Manage
2. Click on "SSL" → "Issue SSL"
3. Select Let's Encrypt and issue certificate

### 5. Create .htaccess in public_html directory
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 6. Verify Installation
- Visit https://tracker.golamrabbi.dev
- Check for any errors in `/home/tracker.golamrabbi.dev/public_html/storage/logs/laravel.log`

## 🔧 Troubleshooting

### If you get 500 Error:
1. Check file permissions
2. Verify PHP version is 8.2
3. Check error logs: `tail -f /home/tracker.golamrabbi.dev/public_html/storage/logs/laravel.log`

### If database connection fails:
1. Verify database credentials in .env
2. Test connection: `php artisan tinker` then `DB::connection()->getPdo();`

### If assets not loading:
1. Run `php artisan storage:link`
2. Check public/storage symlink exists
3. Verify APP_URL in .env matches your domain

## 📧 Email Configuration (Optional)
If you need email functionality, update the MAIL_* settings in .env with your SMTP credentials.
