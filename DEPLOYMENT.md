# Deployment Guide for CyberPanel

## Prerequisites
- CyberPanel installed on your server
- Domain name pointed to your server
- SSL certificate (Let's Encrypt recommended)

## Database Setup
1. Create a MySQL database in CyberPanel
2. Import the database backup: `expense_backup_20250722_191343.sql`
3. Note down the database credentials

## Application Deployment

### 1. Create Website in CyberPanel
- Log in to CyberPanel
- Create Website > Fill in domain details
- Select PHP 8.2 (matching your local environment)

### 2. Upload Application Files
- Upload all files to `/home/yourdomain/public_html/`
- Ensure proper permissions:
  ```bash
  chmod -R 755 storage bootstrap/cache
  chown -R yourusername:yourusername /home/yourdomain/public_html
  ```

### 3. Environment Configuration
Create `.env` file with the following content (update with your actual values):

```env
APP_NAME="SolveEz Expense Tracker Web App"
APP_ENV=production
APP_KEY=base64:dfq1YIwmFjfTBNyCmb41beUg6gMf9EWVOxAWlH9OYOw=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
```

### 4. Install Dependencies
SSH into your server and run:
```bash
cd /home/yourdomain/public_html
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Set Document Root
In CyberPanel, set the document root to `/public` directory:
- Websites > List Websites > Manage > vHost Conf
- Update document root to: `/home/yourdomain/public_html/public`

### 6. Configure Rewrite Rules
Add to .htaccess in public directory:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 7. Final Steps
```bash
php artisan migrate --force
php artisan storage:link
```

## Security Recommendations
- Enable SSL/HTTPS
- Set proper file permissions
- Disable debug mode in production
- Configure firewall rules
- Regular backups

## Troubleshooting
- Check Laravel logs: `storage/logs/laravel.log`
- Verify PHP version: 8.2.28
- Ensure all required PHP extensions are enabled
- Check file permissions if getting 500 errors
