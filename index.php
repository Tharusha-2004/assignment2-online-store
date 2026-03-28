<?php
include('includes/auth.php');
include('includes/header.php');

$products = get_all_products();
?>

<div class="container">
    <h2>Welcome to Online Store</h2>
    
    <div class="hero-section">
        <h3>Shop Our Latest Products</h3>
        <p>Discover quality products at great prices</p>
    </div>
    
    <?php if (is_logged_in()): ?>
        <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>
    <?php else: ?>
        <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to start shopping.</p>
    <?php endif; ?>
    
    <h3>Featured Products</h3>
    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <?php if (!empty($product['image_url'])): ?>
                    <div class="product-image">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                <?php else: ?>
                    <div class="product-image placeholder">
                        <p>No Image</p>
                    </div>
                <?php endif; ?>
                <div class="product-info">
                    <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                    <p><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?></p>
                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    <p class="stock">Stock: <?php echo $product['quantity']; ?></p>
                    <p class="category">Category: <?php echo htmlspecialchars($product['category']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
