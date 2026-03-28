<?php
include('../includes/auth.php');
include('../includes/header.php');

if (!is_logged_in() || !is_admin()) {
    header('Location: ../login.php');
    exit;
}

$conn = include('../db/config.php');
$message = '';
$error = '';

// Delete user
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    if ($user_id !== 1) { // Prevent deleting admin user
        if ($conn->query("DELETE FROM users WHERE id = $user_id")) {
            $message = 'User deleted successfully';
        } else {
            $error = 'Error deleting user';
        }
    } else {
        $error = 'Cannot delete the primary admin user';
    }
}

// Update user status
if (isset($_GET['toggle_status'])) {
    $user_id = intval($_GET['toggle_status']);
    $current_status_result = $conn->query("SELECT status FROM users WHERE id = $user_id");
    $current_status = $current_status_result->fetch_assoc()['status'];
    $new_status = $current_status === 'active' ? 'inactive' : 'active';
    
    if ($conn->query("UPDATE users SET status = '$new_status' WHERE id = $user_id")) {
        $message = 'User status updated';
    }
}

// Get all users
$users = get_all_users();
?>

<div class="container">
    <div class="admin-header">
        <h2>Manage Users</h2>
    </div>
    
    <div class="admin-nav">
        <a href="index.php" class="admin-nav-link">Dashboard</a>
        <a href="manage_users.php" class="admin-nav-link active">Manage Users</a>
        <a href="manage_products.php" class="admin-nav-link">Manage Products</a>
        <a href="manage_orders.php" class="admin-nav-link">Manage Orders</a>
    </div>
    
    <?php if ($message): ?>
        <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <div class="admin-section">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo ucfirst($user['role']); ?></td>
                        <td><span class="status-<?php echo $user['status']; ?>"><?php echo ucfirst($user['status']); ?></span></td>
                        <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                        <td>
                            <a href="?toggle_status=<?php echo $user['id']; ?>" class="btn-small">
                                <?php echo $user['status'] === 'active' ? 'Deactivate' : 'Activate'; ?>
                            </a>
                            <?php if ($user['id'] !== 1): ?>
                                <a href="?delete=<?php echo $user['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
