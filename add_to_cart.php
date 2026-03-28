<?php
include('includes/auth.php');

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $user_id = $_SESSION['user_id'];
    
    if ($product_id > 0 && $quantity > 0) {
        $product = get_product_by_id($product_id);
        
        if ($product && $product['quantity'] >= $quantity) {
            $total_price = $product['price'] * $quantity;
            
            $conn = include('db/config.php');
            $sql = "INSERT INTO orders (user_id, product_id, quantity, total_price, order_status) 
                    VALUES ($user_id, $product_id, $quantity, $total_price, 'completed')";
            
            if ($conn->query($sql) === TRUE) {
                // Update product quantity
                $new_quantity = $product['quantity'] - $quantity;
                $update_sql = "UPDATE products SET quantity = $new_quantity WHERE id = $product_id";
                $conn->query($update_sql);
                
                $_SESSION['success'] = 'Order placed successfully!';
            }
        }
    }
}

header('Location: dashboard.php');
exit;
?>
