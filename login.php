<?php
include('includes/auth.php');
include('includes/header.php');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        if (login($username, $password)) {
            $success = 'Login successful! Redirecting...';
            header('Refresh: 2; url=index.php');
        } else {
            $error = 'Invalid username or password';
        }
    }
}

if (is_logged_in()) {
    header('Location: index.php');
    exit;
}
?>

<div class="container">
    <div class="form-container">
        <h2>Login</h2>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        
        <div class="demo-credentials">
            <h3>Demo Credentials</h3>
            <p><strong>Admin Account:</strong> Username: admin | Password: admin123</p>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
