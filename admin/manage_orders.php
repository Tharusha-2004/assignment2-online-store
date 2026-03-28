<?php
include('../includes/auth.php');
include('../includes/header.php');

if (!is_logged_in() || !is_admin()) {
    header('Location: ../login.php');
    exit;
}

$conn = include('../db/config.php');
$message = '';

// Update order status
if (isset($_GET['update_status'])) {
    $order_id = intval($_GET['update_status']);
    $status = $conn->real_escape_string($_GET['status'] ?? 'pending');
    
    $valid_statuses = ['pending', 'completed', 'cancelled'];
    if (in_array($status, $valid_statuses)) {
        if ($conn->query("UPDATE orders SET order_status = '$status' WHERE id = $order_id")) {
            $message = 'Order status updated';
        }
    }
}

// Get all orders with details
$orders_result = $conn->query("
    SELECT o.id, u.username, u.email, p.name as product_name, o.quantity, o.total_price, o.order_date, o.order_status 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    JOIN products p ON o.product_id = p.id 
    ORDER BY o.order_date DESC
");
$orders = $orders_result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
    <div class="admin-header">
        <h2>Manage Orders</h2>
    </div>
    
    <div class="admin-nav">
        <a href="index.php" class="admin-nav-link">Dashboard</a>
        <a href="manage_users.php" class="admin-nav-link">Manage Users</a>
        <a href="manage_products.php" class="admin-nav-link">Manage Products</a>
        <a href="manage_orders.php" class="admin-nav-link active">Manage Orders</a>
    </div>
    
    <?php if ($message): ?>
        <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    
    <div class="admin-section">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                        <td><?php echo date('M j, Y', strtotime($order['order_date'])); ?></td>
                        <td><span class="status-<?php echo $order['order_status']; ?>"><?php echo ucfirst($order['order_status']); ?></span></td>
                        <td>
                            <select onchange="updateOrderStatus(<?php echo $order['id']; ?>, this.value)" class="status-select">
                                <option value="">Update Status</option>
                                <option value="pending" <?php echo $order['order_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?php echo $order['order_status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo $order['order_status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function updateOrderStatus(orderId, status) {
    if (status) {
        window.location.href = '?update_status=' + orderId + '&status=' + status;
    }
}
</script>

<?php include('../includes/footer.php'); ?>
