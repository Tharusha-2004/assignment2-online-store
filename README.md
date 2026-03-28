# Online Store - Assignment 2

A fully functional dynamic website for an online store built with PHP, MySQL, and HTML/CSS.

## Features

### 1. **Database Management**
- **Users Table**: Stores user information (username, email, password, role, status)
- **Products Table**: Manages product inventory (name, description, price, quantity, category)
- **Orders Table**: Records customer orders with foreign keys to users and products
- Proper relationships and data integrity

### 2. **User Authentication**
- Secure user registration with password hashing
- Login system with session management
- Logout functionality
- Role-based access control (User/Admin)

### 3. **Public Website**
- Homepage with featured products
- Products catalog page
- User dashboard to view profile and order history
- Shopping functionality (add to cart/place orders)
- Responsive design

### 4. **Admin Panel**
- Dashboard with statistics (total users, products, orders, revenue)
- **User Management**: View, activate/deactivate, and delete users
- **Product Management**: Add, edit, and delete products
- **Order Management**: View and update order status
- Admin navigation menu

## Project Structure

```
Assignment2/
├── db/
│   ├── config.php           # Database configuration
│   └── init_db.php         # Database initialization
├── includes/
│   ├── auth.php            # Authentication functions
│   ├── header.php          # Header template
│   └── footer.php          # Footer template
├── admin/
│   ├── index.php           # Admin dashboard
│   ├── manage_users.php    # User management
│   ├── manage_products.php # Product management
│   └── manage_orders.php   # Order management
├── css/
│   └── style.css           # Styling
├── index.php               # Homepage
├── register.php            # User registration
├── login.php               # User login
├── logout.php              # User logout
├── products.php            # Products catalog
├── dashboard.php           # User dashboard
├── add_to_cart.php         # Order processing
└── README.md               # This file
```

## Installation Instructions

### Prerequisites
- PHP 7.0 or higher
- MySQL 5.7 or higher
- Local server (XAMPP, WAMP, or MAMP)

### Setup Steps

1. **Move project folder**
   - Place the `Assignment2` folder in your web server root directory
   - XAMPP: `C:\xampp\htdocs\`
   - WAMP: `C:\wamp\www\`
   - MAMP: `/Applications/MAMP/htdocs/`

2. **Start your server**
   - Start Apache and MySQL services

3. **Initialize the database**
   - Open browser and navigate to: `http://localhost/Assignment2/db/init_db.php`
   - The database and tables will be created automatically

4. **Access the website**
   - Open: `http://localhost/Assignment2/`

## Default Admin Credentials

- **Username**: `admin`
- **Password**: `admin123`
- **Email**: `admin@onlinestore.com`

## Database Tables

### Users Table
```sql
- id (Primary Key)
- username (Unique)
- email (Unique)
- password (Hashed)
- full_name
- role (user/admin)
- status (active/inactive)
- created_at
```

### Products Table
```sql
- id (Primary Key)
- name
- description
- price
- quantity
- image_url
- category
- status (active/inactive)
- created_at
- updated_at
```

### Orders Table
```sql
- id (Primary Key)
- user_id (Foreign Key)
- product_id (Foreign Key)
- quantity
- total_price
- order_status (pending/completed/cancelled)
- order_date
```

## Functionalities

### Public Features
1. ✅ User Registration with validation
2. ✅ User Login with authentication
3. ✅ View product catalog
4. ✅ Place orders
5. ✅ User dashboard with order history
6. ✅ Responsive UI

### Admin Features
1. ✅ Dashboard with statistics
2. ✅ Add new products
3. ✅ Edit existing products
4. ✅ Delete products
5. ✅ Manage users (activate/deactivate/delete)
6. ✅ Manage orders (update status)
7. ✅ View order history

## Sample Data

The system comes pre-loaded with:
- 1 Admin user
- 5 Sample products (Laptop, Smartphone, Tablet, Headphones, USB Cable)
- Each product can be managed through the admin panel

## User Testing Steps

### 1. Test Registration
- Click "Register" on homepage
- Fill in all fields (Username, Email, Password, Full Name)
- Create new user account

### 2. Test Login
- Click "Login"
- Use credentials you registered or admin credentials
- Successfully log in

### 3. Test Shopping
- Browse products on "Products" page
- Add items to order (requires login)
- View order in dashboard

### 4. Test Admin Panel
- Login as admin
- Access admin panel from dashboard
- Add, edit, delete products
- Manage users and orders

## Security Features

- ✅ Password hashing using PHP's password_hash()
- ✅ SQL injection prevention with real_escape_string()
- ✅ Session-based authentication
- ✅ Role-based access control
- ✅ Foreign key relationships for data integrity
- ✅ Input validation on forms

## Browser Compatibility

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Notes

- The database must be created from the init_db.php page before first use
- All passwords are securely hashed
- Session-based authentication system
- The admin panel has a separate navigation to prevent accidental access

## Support

For any issues:
1. Ensure MySQL is running
2. Check that PHP version is 7.0+
3. Verify database was initialized properly
4. Clear browser cache if styling issues occur

---

**Submission Date**: April 2, 2026
