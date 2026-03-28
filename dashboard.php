<?php
include('includes/auth.php');
include('includes/header.php');

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$user_info = get_user_info($_SESSION['user_id']);

// Get user's orders
$user_id = $_SESSION['user_id'];
$orders_sql = "SELECT o.id, p.name, p.price, o.quantity, o.total_price, o.order_date, o.order_status 
               FROM orders o 
               JOIN products p ON o.product_id = p.id 
               WHERE o.user_id = $user_id 
               ORDER BY o.order_date DESC";

$conn = include('db/config.php');
$orders_result = $conn->query($orders_sql);
$orders = [];
if ($orders_result && $orders_result->num_rows > 0) {
    $orders = $orders_result->fetch_all(MYSQLI_ASSOC);
}
?>

<div class="container">
    <h2>User Dashboard</h2>
    
    <div class="dashboard-section">
        <h3>Account Information</h3>
        <table class="info-table">
            <tr>
                <td><strong>Username:</strong></td>
                <td><?php echo htmlspecialchars($user_info['username']); ?></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><?php echo htmlspecialchars($user_info['email']); ?></td>
            </tr>
            <tr>
                <td><strong>Full Name:</strong></td>
                <td><?php echo htmlspecialchars($user_info['full_name']); ?></td>
            </tr>
            <tr>
                <td><strong>Member Since:</strong></td>
                <td><?php echo date('F j, Y', strtotime($user_info['created_at'])); ?></td>
            </tr>
        </table>
    </div>
    
    <div class="dashboard-section">
        <h3>Your Orders</h3>
        
        <?php if (empty($orders)): ?>
            <p>You haven't placed any orders yet. <a href="products.php">Start shopping</a></p>
        <?php else: ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['name']); ?></td>
                            <td>$<?php echo number_format($order['price'], 2); ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                            <td><?php echo date('M j, Y', strtotime($order['order_date'])); ?></td>
                            <td><span class="status-<?php echo $order['order_status']; ?>"><?php echo ucfirst($order['order_status']); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
