# Test Cases and User Flow

## Test Case Documentation

### TC001: Database Initialization
**Objective**: Verify database is properly created with all tables and relationships

**Steps**:
1. Navigate to: `http://localhost/Assignment2/db/init_db.php`

**Expected Results**:
- ✅ Users table created successfully
- ✅ Products table created successfully
- ✅ Orders table created successfully
- ✅ Admin user created (username: admin, password: admin123)
- ✅ 5 sample products inserted

**Status**: Should show all success messages

---

### TC002: User Registration
**Objective**: Test user can create new account

**Steps**:
1. Go to homepage
2. Click "Register"
3. Fill in form:
   - Full Name: John Doe
   - Username: johndoe
   - Email: john@example.com
   - Password: password123
   - Confirm Password: password123
4. Click "Register"

**Expected Results**:
- ✅ Success message: "Registration successful! Please login."
- ✅ Redirected to login page after 2 seconds
- ✅ New user appears in database

**Negative Test**:
- Try registering with same username → "Username or email already exists"
- Leave fields empty → "Please fill in all fields"
- Passwords don't match → "Passwords do not match"
- Password < 6 chars → "Password must be at least 6 characters long"

---

### TC003: User Login
**Objective**: Test user authentication

**Steps**:
1. Go to Login page
2. Enter username: `john doe` or use admin credentials
3. Enter password: `password123` or `admin123`
4. Click Login

**Expected Results**:
- ✅ Success message: "Login successful! Redirecting..."
- ✅ Redirected to homepage after 2 seconds
- ✅ Username appears in top navigation
- ✅ Session created

**Negative Test**:
- Wrong password → "Invalid username or password"
- Non-existent user → "Invalid username or password"
- Leave fields empty → "Please fill in all fields"

---

### TC004: View Products
**Objective**: Test product catalog functionality

**Steps**:
1. Click "Products" in navigation
2. View all available products

**Expected Results**:
- ✅ All active products display in grid
- ✅ Product details show (name, price, category, stock)
- ✅ "Add to Cart" button visible for logged-in users
- ✅ "Login to Purchase" link for non-logged-in users
- ✅ Out of stock items show "Out of Stock"

---

### TC005: Place Order (Purchase)
**Objective**: Test order placement functionality

**Precondition**: User must be logged in

**Steps**:
1. Go to Products page
2. Select quantity for a product
3. Click "Add to Cart" button
4. Check dashboard for order

**Expected Results**:
- ✅ Order created in database
- ✅ Product quantity decreases
- ✅ Order appears in user dashboard
- ✅ Order status shows as "completed"

---

### TC006: User Dashboard
**Objective**: Test user profile and order history

**Steps**:
1. Login as user
2. Click "Dashboard" in navigation
3. Review account info and orders

**Expected Results**:
- ✅ User information displays correctly
- ✅ All user's orders listed with details:
  - Product name
  - Price
  - Quantity
  - Total
  - Order date
  - Status

---

### TC007: Admin Login and Dashboard
**Objective**: Test admin panel access

**Steps**:
1. Login as admin (username: admin, password: admin123)
2. Click "Admin Panel"

**Expected Results**:
- ✅ Admin dashboard displays stats:
  - Total Users count
  - Total Products count
  - Total Orders count
  - Total Revenue
- ✅ Recent orders table shown
- ✅ Navigation shows links to manage sections

---

### TC008: Manage Users (Admin)
**Objective**: Test user management functionality

**Steps**:
1. In admin panel, click "Manage Users"
2. View all users in table
3. Click "Deactivate" on a user
4. Try to login as that user

**Expected Results**:
- ✅ All users display in table
- ✅ User status changes to "inactive"
- ✅ Inactive user cannot login
- ✅ Activate button restores access

**Additional Test**:
- Click "Delete" on test user → User removed from database
- Cannot delete primary admin → Error message shows

---

### TC009: Manage Products (Admin)
**Objective**: Test product management functionality

**Steps**:
1. In admin panel, click "Manage Products"
2. Fill in "Add New Product" form:
   - Name: Test Laptop
   - Category: Electronics
   - Price: 999.99
   - Quantity: 5
   - Description: Test product
3. Click "Add Product"

**Expected Results**:
- ✅ Success message: "Product added successfully"
- ✅ Product appears in products list
- ✅ Product appears on public products page

**Edit Product**:
1. Click "Edit" button on a product
2. Change details (e.g., price: 899.99)
3. Click update

**Expected Results**:
- ✅ Product updated in database
- ✅ Changes reflected on public site

**Delete Product**:
1. Click "Delete" on a product
2. Confirm deletion

**Expected Results**:
- ✅ Product removed from database
- ✅ No longer appears on public site

---

### TC010: Manage Orders (Admin)
**Objective**: Test order status management

**Steps**:
1. In admin panel, click "Manage Orders"
2. View all orders
3. Select order status from dropdown (pending/completed/cancelled)

**Expected Results**:
- ✅ All orders display with customer info
- ✅ Status dropdown updates order status
- ✅ Status reflects in user's dashboard

---

### TC011: Session and Logout
**Objective**: Test session management and logout

**Steps**:
1. Login as user
2. Click "Logout" button
3. Try to access dashboard

**Expected Results**:
- ✅ Session terminated
- ✅ Redirected to homepage
- ✅ Cannot access dashboard (redirected to login)
- ✅ Username no longer appears in navigation

---

### TC012: Responsive Design
**Objective**: Test mobile responsiveness

**Steps**:
1. Open site on desktop (1920px)
2. Resize to tablet (768px)
3. Resize to mobile (375px)
4. Test navigation and forms

**Expected Results**:
- ✅ Layout adjusts properly at each breakpoint
- ✅ Navigation remains accessible
- ✅ All forms remain functional
- ✅ No horizontal scrolling needed
- ✅ Grid layouts adapt to screen size

---

### TC013: Security - Password Hashing
**Objective**: Verify passwords are hashed

**Steps**:
1. Register a user
2. Open PhpMyAdmin
3. Check users table password field

**Expected Results**:
- ✅ Password is hashed (not plain text)
- ✅ Different passwords have different hashes
- ✅ Login still works with plain text password

---

### TC014: Foreign Key Relationships
**Objective**: Test data integrity

**Steps**:
1. Admin creates an order for a user
2. Delete the user
3. Check if order is also deleted

**Expected Results**:
- ✅ Order is deleted when user is deleted (CASCADE)
- ✅ Data integrity maintained

---

### TC015: Input Validation
**Objective**: Test form validation

**Steps**:
1. Try to register with invalid email format
2. Try to add product with negative price
3. Submit form with script tags

**Expected Results**:
- ✅ Invalid emails rejected
- ✅ Negative values prevented
- ✅ Script injection prevented (htmlspecialchars)

---

## User Flow Scenarios

### Scenario 1: New Customer Journey
1. User visits homepage
2. Browses products
3. Registers account
4. Logs in
5. Views product details
6. Places order
7. Views order in dashboard
8. Logs out
**Expected**: Smooth flow without errors

### Scenario 2: Admin Store Management
1. Admin logs in
2. Views dashboard statistics
3. Adds new product
4. Edits existing product
5. Views customer orders
6. Updates order status
7. Manages user accounts
**Expected**: All operations complete successfully

### Scenario 3: Order Processing
1. Customer places order for 2 laptops
2. Product stock decreases from 10 to 8
3. Admin views order as pending
4. Admin marks order as completed
5. Customer sees order status updated
**Expected**: Order flow works end-to-end

---

## Browser Compatibility Testing

Test on:
- ✅ Chrome (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Edge (latest)
- ✅ Mobile Chrome
- ✅ Mobile Safari

**Expected**: Consistent experience across all browsers

---

## Performance Testing

### Database Queries
- Homepage loads < 1 second
- Admin dashboard < 2 seconds
- Product list < 1 second
- User list (100 users) < 2 seconds

### Expected Results
- ✅ All pages load quickly
- ✅ No timeout errors
- ✅ Smooth navigation

