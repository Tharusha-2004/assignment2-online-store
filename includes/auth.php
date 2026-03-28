<?php
// Authentication functions
session_start();

$conn = include(__DIR__ . '\..\db\config.php');

function login($username, $password) {
    global $conn;
    
    $username = $conn->real_escape_string($username);
    $sql = "SELECT id, username, email, password, role FROM users WHERE username = '$username' AND status = 'active'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
    }
    return false;
}

function register($username, $email, $password, $full_name) {
    global $conn;
    
    $username = $conn->real_escape_string($username);
    $email = $conn->real_escape_string($email);
    $full_name = $conn->real_escape_string($full_name);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if user already exists
    $check_user = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($check_user);
    
    if ($result && $result->num_rows > 0) {
        return ['success' => false, 'message' => 'Username or email already exists'];
    }
    
    $sql = "INSERT INTO users (username, email, password, full_name, role, status) 
            VALUES ('$username', '$email', '$hashed_password', '$full_name', 'user', 'active')";
    
    if ($conn->query($sql) === TRUE) {
        return ['success' => true, 'message' => 'Registration successful! Please login.'];
    } else {
        return ['success' => false, 'message' => 'Error: ' . $conn->error];
    }
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function logout() {
    session_destroy();
}

function get_user_info($user_id) {
    global $conn;
    
    $user_id = intval($user_id);
    $sql = "SELECT id, username, email, full_name, role, status, created_at FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

function get_all_users() {
    global $conn;
    
    $sql = "SELECT id, username, email, full_name, role, status, created_at FROM users ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}

function get_all_products() {
    global $conn;
    
    $sql = "SELECT id, name, description, price, quantity, category, image_url, status, created_at FROM products WHERE status = 'active' ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}

function get_product_by_id($product_id) {
    global $conn;
    
    $product_id = intval($product_id);
    $sql = "SELECT * FROM products WHERE id = $product_id AND status = 'active'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}
?>
