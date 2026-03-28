<?php
include('includes/auth.php');
include('includes/header.php');

$products = get_all_products();
?>

<div class="container">
    <h2>All Products</h2>
    
    <div class="products-grid">
        <?php if (empty($products)): ?>
            <p>No products available at the moment.</p>
        <?php else: ?>
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
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="price"><strong>Price: $<?php echo number_format($product['price'], 2); ?></strong></p>
                        <p class="stock">Stock Available: <?php echo $product['quantity']; ?> units</p>
                        <p class="category">Category: <?php echo htmlspecialchars($product['category']); ?></p>
                        
                        <?php if (is_logged_in() && $product['quantity'] > 0): ?>
                            <form method="POST" action="add_to_cart.php" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <div class="form-group">
                                    <label for="quantity_<?php echo $product['id']; ?>">Quantity:</label>
                                    <input type="number" id="quantity_<?php echo $product['id']; ?>" name="quantity" min="1" max="<?php echo $product['quantity']; ?>" value="1" required>
                                </div>
                                <button type="submit" class="btn">Add to Cart</button>
                            </form>
                        <?php elseif (!is_logged_in()): ?>
                            <p><a href="login.php" class="btn">Login to Purchase</a></p>
                        <?php else: ?>
                            <p class="out-of-stock">Out of Stock</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
