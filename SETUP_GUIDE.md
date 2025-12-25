# iRoom - Local Development Setup Guide

This guide will help you set up the iRoom project on your local laptop for development.

## Project Overview

iRoom is a PHP-based room scheduling system for universities with the following features:
- Course and room management
- Schedule creation and management
- User authentication via CAS/SSO
- Equipment tracking
- Exam scheduling

## Prerequisites

Before you begin, ensure you have the following installed on your laptop:

1. **PHP** (version 7.0 or higher)
   - Check: `php -v`

2. **MySQL** (version 5.7 or higher) or **MariaDB** (version 10.2 or higher)
   - Check: `mysql --version`

3. **Apache** or **Nginx** web server
   - Apache: `apache2 -v` or `httpd -v`
   - Nginx: `nginx -v`

4. **Composer** (optional, for dependency management)
   - Check: `composer --version`

5. **Git** (to clone the repository)
   - Check: `git --version`

## Installation Steps

### 1. Clone the Repository

```bash
# If you haven't cloned it yet
git clone <your-repository-url> iroom-claude
cd iroom-claude
```

### 2. Database Setup

#### Option A: Create Database Manually

1. Start MySQL server:
```bash
# Linux/Mac
sudo service mysql start
# or
sudo systemctl start mysql

# Windows
net start mysql
```

2. Login to MySQL:
```bash
mysql -u root -p
```

3. Create database and user:
```sql
CREATE DATABASE iRoom CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER 'iroom'@'localhost' IDENTIFIED BY 'your_password_here';
GRANT ALL PRIVILEGES ON iRoom.* TO 'iroom'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Option B: Use the provided SQL file

If you have the `program.sql` file, you can import it:
```bash
mysql -u root -p < program.sql
```

### 3. Configure Database Connection

1. Copy the template file:
```bash
cp connectDBTEMPLATE.php connectDB.php
```

2. Edit `connectDB.php` with your local database settings:
```php
<?php
include 'errorReporting.php';

// Local development settings
$host = 'localhost';  // or '127.0.0.1'
$dbname = 'iRoom';
$user = 'iroom';
$pass = 'your_password_here';  // Use the password you set

try {
    // For TCP connection
    $dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $dbh->query('set character_set_client=utf8');
    $dbh->query('set character_set_connection=utf8');
    $dbh->query('set character_set_results=utf8');
    $dbh->query('set character_set_server=utf8');

} catch(PDOException $e) {
    die('Connection error:' . $e->getMessage());
}

if (empty($dbh)) {
    die("Cannot connect to database");
}
?>
```

### 4. Create Database Schema

Run the database creation script to set up all tables:

```bash
php createDB.php
```

**Note:** Before running this, make sure to update the database credentials in `createDB.php` to match your local setup:
- Change `$host` to `'localhost'` or `'127.0.0.1'`
- Update `$user` and `$pass` to your MySQL credentials

### 5. Web Server Configuration

#### For Apache

1. Enable required modules:
```bash
sudo a2enmod rewrite
sudo a2enmod php
sudo service apache2 restart
```

2. Create a virtual host (optional but recommended):

Create `/etc/apache2/sites-available/iroom.conf`:
```apache
<VirtualHost *:80>
    ServerName iroom.local
    DocumentRoot /path/to/iroom-claude

    <Directory /path/to/iroom-claude>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/iroom-error.log
    CustomLog ${APACHE_LOG_DIR}/iroom-access.log combined
</VirtualHost>
```

3. Enable the site:
```bash
sudo a2ensite iroom.conf
sudo service apache2 reload
```

4. Add to `/etc/hosts`:
```
127.0.0.1    iroom.local
```

#### For PHP Built-in Server (Quick Testing)

For quick testing without Apache/Nginx:
```bash
cd /path/to/iroom-claude
php -S localhost:8000
```

Then access: `http://localhost:8000`

### 6. File Permissions

Ensure the web server can read the files:
```bash
# If using Apache
sudo chown -R www-data:www-data /path/to/iroom-claude

# If using your user account with PHP built-in server
chmod -R 755 /path/to/iroom-claude
```

### 7. CAS/SSO Configuration (Optional for local testing)

The system uses CAS authentication. For local testing, you may need to:

1. Comment out CAS authentication temporarily in `login_cas.php`
2. Use direct login through `login.php` instead
3. Default admin credentials (after running createDB.php):
   - Email: admin@admin.gr
   - Password: admin

## Testing Your Setup

1. Start your web server (Apache/Nginx or PHP built-in)
2. Open your browser and navigate to:
   - If using virtual host: `http://iroom.local`
   - If using built-in server: `http://localhost:8000`
   - If using Apache default: `http://localhost/iroom-claude`

3. You should see the login page
4. Try logging in with the default admin credentials

## Troubleshooting

### Database Connection Issues

- **Error: "Connection error: SQLSTATE[HY000] [2002] No such file or directory"**
  - This means the socket path is wrong. Change to TCP connection using `host=localhost` instead of `unix_socket`

- **Error: "Access denied for user"**
  - Check your username and password in `connectDB.php`
  - Make sure you granted privileges correctly

### PHP Errors

- **Error: "Call to undefined function phpCAS::client()"**
  - The CAS library is missing. For local development, you can bypass CAS authentication

- **White screen / No output**
  - Check PHP error logs
  - Enable error reporting by checking `errorReporting.php`

### Permission Errors

- **Error: "Permission denied"**
  - Check file permissions: `chmod -R 755 /path/to/iroom-claude`
  - Check ownership matches web server user

## Development Workflow

1. **Make changes** to PHP files
2. **Refresh browser** (PHP doesn't require compilation)
3. **Check errors** in browser console and PHP error logs
4. **Test features** through the web interface

## Project Structure

```
iroom-claude/
├── CAS/                    # CAS authentication library
├── Course/                 # Course management
├── Departament_University/ # Department management
├── Equipment_rooms/        # Equipment and room management
├── Schedule/               # Schedule management
├── Semester/               # Semester management
├── Users/                  # User management
├── css/                    # Stylesheets
├── js/                     # JavaScript files
├── images/                 # Image assets
├── certs/                  # SSL certificates for CAS
├── connectDB.php           # Database connection (create from template)
├── createDB.php            # Database initialization script
├── index.php               # Main entry point
├── login.php               # Login page
├── header.php              # Common header
├── footer.php              # Common footer
└── program.sql             # Database dump
```

## Next Steps

After setting up:
1. Explore the admin panel
2. Create departments and courses
3. Add rooms and equipment
4. Create schedules
5. Test the booking system

## Support

For issues or questions:
- Check the code comments in PHP files
- Review database schema in `createDB.php`
- Check Apache/PHP error logs

## Security Notes for Production

**This is for LOCAL DEVELOPMENT only!** Before deploying to production:
- Change all default passwords
- Enable HTTPS
- Configure CAS/SSO properly
- Set appropriate file permissions
- Enable PHP security settings
- Use environment variables for sensitive data
