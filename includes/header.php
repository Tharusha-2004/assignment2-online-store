<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, maximum-scale=5.0">
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
            <div class="logo-section">
                <h1 class="logo">Online Store</h1>
            </div>
            <nav class="navbar">
                <?php
                    $is_admin_page = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
                    $base_url = $is_admin_page ? '../' : '';
                ?>
                <a href="<?php echo $base_url; ?>index.php">Home</a>
                <a href="<?php echo $base_url; ?>products.php">Products</a>
                <?php if (is_logged_in()): ?>
                    <a href="<?php echo $base_url; ?>dashboard.php">Dashboard</a>
                    <?php if (is_admin()): ?>
                        <a href="<?php echo $base_url; ?>admin/index.php">Admin Panel</a>
                    <?php endif; ?>
                    <a href="<?php echo $base_url; ?>logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a>
                <?php else: ?>
                    <a href="<?php echo $base_url; ?>register.php">Register</a>
                    <a href="<?php echo $base_url; ?>login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</header>
<main>
