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

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $description = $conn->real_escape_string($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $category = $conn->real_escape_string($_POST['category'] ?? '');
    $image_url = $conn->real_escape_string($_POST['image_url'] ?? '');
    
    if (empty($name) || $price <= 0) {
        $error = 'Please fill in all required fields';
    } else {
        $sql = "INSERT INTO products (name, description, price, quantity, category, image_url, status) 
                VALUES ('$name', '$description', $price, $quantity, '$category', '$image_url', 'active')";
        
        if ($conn->query($sql) === TRUE) {
            $message = 'Product added successfully';
        } else {
            $error = 'Error adding product: ' . $conn->error;
        }
    }
}

// Delete product
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    if ($conn->query("DELETE FROM products WHERE id = $product_id")) {
        $message = 'Product deleted successfully';
    } else {
        $error = 'Error deleting product';
    }
}

// Update product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $product_id = intval($_POST['product_id']);
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $description = $conn->real_escape_string($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $category = $conn->real_escape_string($_POST['category'] ?? '');
    $status = $conn->real_escape_string($_POST['status'] ?? 'active');
    $image_url = $conn->real_escape_string($_POST['image_url'] ?? '');
    
    $sql = "UPDATE products SET name='$name', description='$description', price=$price, quantity=$quantity, category='$category', status='$status', image_url='$image_url' WHERE id=$product_id";
    
    if ($conn->query($sql) === TRUE) {
        $message = 'Product updated successfully';
    } else {
        $error = 'Error updating product';
    }
}

// Get all products
$products_result = $conn->query("SELECT id, name, description, price, quantity, category, status, image_url FROM products ORDER BY created_at DESC");
$products = $products_result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
    <div class="admin-header">
        <h2>Manage Products</h2>
    </div>
    
    <div class="admin-nav">
        <a href="index.php" class="admin-nav-link">Dashboard</a>
        <a href="manage_users.php" class="admin-nav-link">Manage Users</a>
        <a href="manage_products.php" class="admin-nav-link active">Manage Products</a>
        <a href="manage_orders.php" class="admin-nav-link">Manage Orders</a>
    </div>
    
    <?php if ($message): ?>
        <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <div class="admin-section">
        <h3>Add New Product</h3>
        <form method="POST" class="form-inline">
            <input type="hidden" name="action" value="add">
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Product Name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="category" placeholder="Category" required>
                </div>
                <div class="form-group">
                    <input type="number" name="price" placeholder="Price" step="0.01" required>
                </div>
                <div class="form-group">
                    <input type="number" name="quantity" placeholder="Quantity" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <textarea name="description" placeholder="Description"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="image_url" placeholder="Image URL (e.g., assets/images/product.svg)">
                </div>
            </div>
            <button type="submit" class="btn">Add Product</button>
        </form>
    </div>
    
    <div class="admin-section">
        <h3>Products List</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td>
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 50px; max-height: 50px;">
                            <?php else: ?>
                                <span style="color: #999;">No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><span class="status-<?php echo $product['status']; ?>"><?php echo ucfirst($product['status']); ?></span></td>
                        <td>
                            <button class="btn-small" onclick="editProduct(<?php echo $product['id']; ?>, '<?php echo htmlspecialchars(json_encode($product)); ?>')">Edit</button>
                            <a href="?delete=<?php echo $product['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Edit modal would go here in a full implementation -->
</div>

<script>
function editProduct(id, productJson) {
    const product = JSON.parse(productJson);
    const name = prompt('Product Name:', product.name);
    if (name === null) return;
    
    const category = prompt('Category:', product.category);
    if (category === null) return;
    
    const price = prompt('Price:', product.price);
    if (price === null) return;
    
    const quantity = prompt('Quantity:', product.quantity);
    if (quantity === null) return;
    
    const status = confirm('Active? (OK=active, Cancel=inactive)') ? 'active' : 'inactive';
    const description = prompt('Description:', product.description);
    if (description === null) return;
    
    const image_url = prompt('Image URL:', product.image_url || '');
    if (image_url === null) return;
    
    // Submit via hidden form
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="product_id" value="${id}">
        <input type="hidden" name="name" value="${name}">
        <input type="hidden" name="category" value="${category}">
        <input type="hidden" name="price" value="${price}">
        <input type="hidden" name="quantity" value="${quantity}">
        <input type="hidden" name="status" value="${status}">
        <input type="hidden" name="description" value="${description}">
        <input type="hidden" name="image_url" value="${image_url}">
    `;
    document.body.appendChild(form);
    form.submit();
}
</script>

<?php include('../includes/footer.php'); ?>
