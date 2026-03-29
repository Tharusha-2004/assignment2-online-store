
<?php
include('../includes/auth.php');
include('../includes/header.php');

if (!is_logged_in() || !is_admin()) {
    header('Location: ../login.php');
    exit;
}

$conn = include('../db/config.php');

// Get statistics
$users_count_result = $conn->query("SELECT COUNT(*) as count FROM users");
$users_count = $users_count_result->fetch_assoc()['count'];

$products_count_result = $conn->query("SELECT COUNT(*) as count FROM products");
$products_count = $products_count_result->fetch_assoc()['count'];

$orders_count_result = $conn->query("SELECT COUNT(*) as count FROM orders");
$orders_count = $orders_count_result->fetch_assoc()['count'];

$total_revenue_result = $conn->query("SELECT SUM(total_price) as total FROM orders WHERE order_status = 'completed'");
$total_revenue_row = $total_revenue_result->fetch_assoc();
$total_revenue = $total_revenue_row['total'] ?? 0;
?>

<div class="container">
    <div class="admin-header">
        <h2>Admin Dashboard</h2>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    </div>
    
    <div class="admin-nav">
        <a href="index.php" class="admin-nav-link active">Dashboard</a>
        <a href="manage_users.php" class="admin-nav-link">Manage Users</a>
        <a href="manage_products.php" class="admin-nav-link">Manage Products</a>
        <a href="manage_orders.php" class="admin-nav-link">Manage Orders</a>
    </div>
    
    <div class="statistics-grid">
        <div class="stat-card">
            <h3>Total Users</h3>
            <p class="stat-number"><?php echo $users_count; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Products</h3>
            <p class="stat-number"><?php echo $products_count; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p class="stat-number"><?php echo $orders_count; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Revenue</h3>
            <p class="stat-number">$<?php echo number_format($total_revenue, 2); ?></p>
        </div>
    </div>
    
    <div class="admin-section">
        <h3>Recent Orders</h3>
        <?php
        $recent_orders_result = $conn->query("
            SELECT o.id, u.username, p.name, o.quantity, o.total_price, o.order_date, o.order_status 
            FROM orders o 
            JOIN users u ON o.user_id = u.id 
            JOIN products p ON o.product_id = p.id 
            ORDER BY o.order_date DESC 
            LIMIT 10
        ");
        
        if ($recent_orders_result->num_rows > 0):
        ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $recent_orders_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['username']); ?></td>
                            <td><?php echo htmlspecialchars($order['name']); ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                            <td><?php echo date('M j, Y', strtotime($order['order_date'])); ?></td>
                            <td><span class="status-<?php echo $order['order_status']; ?>"><?php echo ucfirst($order['order_status']); ?></span></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
