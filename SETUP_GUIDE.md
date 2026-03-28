# Setup and Configuration Guide

## Quick Start Guide

### 1. System Requirements
- **Apache/IIS** with PHP support
- **PHP**: 7.0 or higher
- **MySQL**: 5.7 or higher
- **Browser**: Any modern browser

### 2. Installation on XAMPP (Windows)

#### Step 1: Download and Extract
1. Download XAMPP from https://www.apachefriends.org/
2. Extract the project to `C:\xampp\htdocs\Assignment2\`

#### Step 2: Start Services
1. Open XAMPP Control Panel
2. Click "Start" next to Apache
3. Click "Start" next to MySQL

#### Step 3: Create Database
1. Open browser and go to: `http://localhost/phpmyadmin/`
2. Create a new database (optional - init_db.php will do this automatically)

#### Step 4: Initialize the Project
1. Navigate to: `http://localhost/Assignment2/db/init_db.php`
2. The system will automatically create all tables and sample data
3. You'll see confirmation messages

#### Step 5: Access the Website
1. Go to: `http://localhost/Assignment2/`
2. You're ready to use the site!

### 3. Installation on WAMP (Windows)

- Similar steps to XAMPP
- Default location: `C:\wamp\www\Assignment2\`
- Access via: `http://localhost:3000/Assignment2/`

### 4. Installation on Mac (MAMP)

- Extract to `/Applications/MAMP/htdocs/Assignment2/`
- Default port: 8888
- Access via: `http://localhost:8888/Assignment2/`

### 5. Installation on Linux

```bash
# Navigate to web root
cd /var/www/html

# Copy project
cp -r Assignment2 ./

# Set permissions
sudo chown -R www-data:www-data Assignment2
sudo chmod -R 755 Assignment2

# Start services
sudo systemctl start apache2
sudo systemctl start mysql
```

## Database Configuration

### Default Configuration (db/config.php)
```php
DB_HOST = localhost
DB_USER = root
DB_PASS = (empty for XAMPP default)
DB_NAME = online_store
```

### Custom Configuration

If your MySQL has different credentials:

1. Open `db/config.php`
2. Modify the constants at the top:
```php
define('DB_HOST', 'your_host');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

## Admin Login

### First Time Login
- **Username**: admin
- **Password**: admin123
- **URL**: http://localhost/Assignment2/admin/

### Create New Admin User (Optional)

1. Open MySQL/PhpMyAdmin
2. Go to `online_store` database → `users` table
3. Insert new row with:
   - username: your_username
   - email: your_email@example.com
   - password: [Use MySQL's MD5() or use the UI to hash]
   - role: admin
   - status: active

## Testing Checklist

### ✅ Database Tests
- [ ] Database created (`online_store`)
- [ ] All 3 tables created (users, products, orders)
- [ ] Sample data loaded
- [ ] Foreign keys established

### ✅ User Management Tests
- [ ] Register new user
- [ ] Login with new user credentials
- [ ] Login with admin credentials
- [ ] Logout functionality works
- [ ] Admin can view all users

### ✅ Admin Panel Tests
- [ ] Dashboard shows correct statistics
- [ ] Add new product
- [ ] Edit product
- [ ] Delete product (except demo products if desired)
- [ ] Manage users (deactivate/activate)
- [ ] Manage orders (change status)

### ✅ Public Site Tests
- [ ] Homepage displays products
- [ ] Products page works
- [ ] Login required for placing orders
- [ ] Logged-in user can place order
- [ ] Order appears in user dashboard
- [ ] Mobile responsive design

## Troubleshooting

### Error: "Connection failed"
**Solution**:
1. Ensure MySQL is running
2. Check DB_HOST, DB_USER, DB_PASS in `db/config.php`
3. Try: `http://localhost/Assignment2/db/init_db.php` again

### Error: "Database not selected"
**Solution**:
1. Run `http://localhost/Assignment2/db/init_db.php`
2. This creates the database automatically

### Error: "Table doesn't exist"
**Solution**:
1. Go to: `http://localhost/Assignment2/db/init_db.php`
2. All tables will be recreated

### Login not working
**Solution**:
1. Verify admin user exists in users table
2. Try default credentials: admin / admin123
3. Check if user status is 'active'

### CSS not loading
**Solution**:
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh (Ctrl+F5)
3. Verify CSS file exists in `/css/style.css`

### Products not showing
**Solution**:
1. Check products table has data
2. Ensure product status is 'active'
3. Verify product price > 0

## Database Backup

### Backup Using PhpMyAdmin
1. Open: http://localhost/phpmyadmin/
2. Select `online_store` database
3. Click "Export"
4. Choose "SQL" format
5. Click "Go"

### Backup Using Command Line (MySQL)
```bash
mysqldump -u root -p online_store > backup.sql
```

### Restore Backup
```bash
mysql -u root -p online_store < backup.sql
```

## Performance Tips

1. **For large product catalogs**: Add pagination to products.php
2. **For scaling**: Consider indexing frequently queried columns
3. **Security**: Change admin password immediately after first login

## Mobile Responsiveness

The site is fully responsive with breakpoints at:
- 768px (tablets)
- 1024px (desktops)
- 1200px (large screens)

## Deployment to Production

### Using cPanel:
1. Zip the project folder
2. Upload to public_html via File Manager
3. Extract the zip
4. Create database via cPanel
5. Update db/config.php with hosting credentials

### Using FTP:
1. Connect to FTP server
2. Upload all files to public_html
3. Create database via hosting control panel
4. Update database credentials

## Additional Notes

- All passwords are hashed and cannot be recovered
- To reset admin password, update directly in database using MD5
- The system uses sessions (cookies) for authentication
- Database queries use prepared statements where possible
- All user input is validated and sanitized

---

For more help, refer to README.md
