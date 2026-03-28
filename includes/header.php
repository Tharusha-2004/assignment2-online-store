<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="<?php 
        $base_url = '';
        if (dirname($_SERVER['PHP_SELF']) !== '/' && strpos($_SERVER['PHP_SELF'], '/admin/') === false) {
            $base_url = '';
        } elseif (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
            $base_url = '../';
        }
        echo $base_url . 'assets/css/style.css';
    ?>">
</head>
<body>
<header>
    <div class="container">
        <div class="header-content">
            <h1 class="logo">Online Store</h1>
            <nav class="navbar">
                <ul>
                    <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : dirname($_SERVER['PHP_SELF']) . '/'; ?>index.php">Home</a></li>
                    <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : dirname($_SERVER['PHP_SELF']) . '/'; ?>products.php">Products</a></li>
                    <?php if (is_logged_in()): ?>
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : dirname($_SERVER['PHP_SELF']) . '/'; ?>dashboard.php">Dashboard</a></li>
                        <?php if (is_admin()): ?>
                            <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : dirname($_SERVER['PHP_SELF']) . '/'; ?>admin/index.php">Admin Panel</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : dirname($_SERVER['PHP_SELF']) . '/'; ?>logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : dirname($_SERVER['PHP_SELF']) . '/'; ?>register.php">Register</a></li>
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : dirname($_SERVER['PHP_SELF']) . '/'; ?>login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
<main>
