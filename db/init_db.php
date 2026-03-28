<?php
// Initialize Database Tables
$conn = include('config.php');

// Create users table
$users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('user', 'admin') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($users_table) === TRUE) {
    echo "Users table created successfully.<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create products table
$products_table = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) UNIQUE NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT DEFAULT 0,
    image_url VARCHAR(255),
    category VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($products_table) === TRUE) {
    echo "Products table created successfully.<br>";
} else {
    echo "Error creating products table: " . $conn->error . "<br>";
}

// Create orders table (relates users and products)
$orders_table = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    order_status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)";

if ($conn->query($orders_table) === TRUE) {
    echo "Orders table created successfully.<br>";
} else {
    echo "Error creating orders table: " . $conn->error . "<br>";
}

// Insert sample admin user (username: admin, password: admin123)
$admin_password = password_hash('admin123', PASSWORD_DEFAULT);
$insert_admin = "INSERT IGNORE INTO users (username, email, password, full_name, role, status) 
                 VALUES ('admin', 'admin@onlinestore.com', '$admin_password', 'Administrator', 'admin', 'active')";

if ($conn->query($insert_admin) === TRUE) {
    echo "Admin user created successfully.<br>";
} else {
    echo "Admin user may already exist or error: " . $conn->error . "<br>";
}

// Insert sample products with images
$sample_products = [
    ['Laptop', 'High-performance laptop for work and gaming', 1200.00, 10, 'Electronics', 'assets/images/laptop.png'],
    ['Smartphone', 'Latest smartphone with advanced features', 800.00, 15, 'Electronics', 'assets/images/smartphone.jpg'],
    ['Tablet', 'Portable tablet for reading and browsing', 450.00, 8, 'Electronics', 'assets/images/tablet.jpg'],
    ['Headphones', 'Noise-cancelling wireless headphones', 150.00, 20, 'Accessories', 'assets/images/headset.jpg'],
    ['USB Cable', 'High-speed USB-C charging cable', 15.00, 50, 'Accessories', 'assets/images/usb.jpg'],
];

foreach ($sample_products as $product) {
    $insert_product = "INSERT IGNORE INTO products (name, description, price, quantity, category, image_url, status) 
                       VALUES ('{$product[0]}', '{$product[1]}', {$product[2]}, {$product[3]}, '{$product[4]}', '{$product[5]}', 'active')";
    
    if ($conn->query($insert_product) === TRUE) {
        echo "Product '{$product[0]}' inserted successfully.<br>";
    } else {
        echo "Error inserting product: " . $conn->error . "<br>";
    }
}

echo "<br><strong>Database initialization complete!</strong><br>";
echo "Admin Login: username=<strong>admin</strong>, password=<strong>admin123</strong>";
echo "<br><br><strong>⚠️ Note: This page should only be run once during initial setup.</strong><br>";
echo "Running this again will not duplicate products due to UNIQUE constraints.<br>";

$conn->close();
?>
