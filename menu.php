<?php
session_start();
require 'db.php';
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}
$username = $_SESSION["username"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order"])) {
    $deliveryAddress = trim($_POST["deliveryAddress"]);
    $contactNumber = trim($_POST["contactNumber"]);
    $items = $_POST["items"]; // JSON string from the JavaScript cart
    $total = $_POST["total"];
    $orderNumber = rand(100000, 999999);
    
    $stmt = $pdo->prepare("INSERT INTO orders (order_number, customer, order_time, delivery_address, contact_number, items, total) VALUES (?, ?, NOW(), ?, ?, ?, ?)");
    $stmt->execute([$orderNumber, $username, $deliveryAddress, $contactNumber, $items, $total]);
    
    $receipt = "Order #$orderNumber\nDate: " . date("Y-m-d H:i:s") . "\nCustomer: $username\nDelivery Address: $deliveryAddress\nContact: $contactNumber\nTotal: $total";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Menu - OrderTaker</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header class="navbar">
    <div class="logo">
      <h2>OrderTaker</h2>
    </div>
    <!-- Navigation Links -->
    <nav>
      <a href="history.php" class="nav-link">View History</a>
      <a href="logout.php" class="nav-link">Logout</a>
    </nav>
  </header>
  <main class="menu-page">
    <h1>Welcome to the Menu!</h1>
    
    <!-- Food Items Section -->
    <section class="menu-section">
      <h2>Food Items</h2>
      <div class="menu-grid">
        <div class="menu-item">
          <img src="images/pizza.jpg" alt="Pizza" class="menu-item-img">
          <h2>Pizza</h2>
          <p>Price: 199</p>
          <button onclick="addToCart('Pizza', 199)" class="secondary-btn">Order</button>
        </div>
        <div class="menu-item">
          <img src="images/burger.jpg" alt="Burger" class="menu-item-img">
          <h2>Burger</h2>
          <p>Price: 159</p>
          <button onclick="addToCart('Burger', 159)" class="secondary-btn">Order</button>
        </div>
        <div class="menu-item">
          <img src="images/fries.jpg" alt="Fries" class="menu-item-img">
          <h2>Fries</h2>
          <p>Price: 40</p>
          <button onclick="addToCart('Fries', 40)" class="secondary-btn">Order</button>
        </div>
        <div class="menu-item">
          <img src="images/footlong.jpg" alt="Footlong Sandwich" class="menu-item-img">
          <h2>Footlong Sandwich</h2>
          <p>Price: 115</p>
          <button onclick="addToCart('Footlong Sandwich', 115)" class="secondary-btn">Order</button>
        </div>
        <div class="menu-item">
          <img src="images/popcorn.jfif" alt="Popcorn" class="menu-item-img">
          <h2>Popcorn</h2>
          <p>Price: 75</p>
          <button onclick="addToCart('Popcorn', 75)" class="secondary-btn">Order</button>
        </div>
      </div>
    </section>
    
    <!-- Drinks Section -->
    <section class="menu-section">
      <h2>Drinks</h2>
      <div class="menu-grid">
        <div class="menu-item">
          <img src="images/coke.jfif" alt="Coke" class="menu-item-img">
          <h2>Coke</h2>
          <p>Price: 20</p>
          <button onclick="addToCart('Coke', 20)" class="secondary-btn">Order</button>
        </div>
        <div class="menu-item">
          <img src="images/lemon-juice.png" alt="Lemon Juice" class="menu-item-img">
          <h2>Lemon Juice</h2>
          <p>Price: 20</p>
          <button onclick="addToCart('Lemon Juice', 20)" class="secondary-btn">Order</button>
        </div>
        <div class="menu-item">
          <img src="images/pineapple-juice.png" alt="Pineapple Juice" class="menu-item-img">
          <h2>Pineapple Juice</h2>
          <p>Price: 20</p>
          <button onclick="addToCart('Pineapple Juice', 20)" class="secondary-btn">Order</button>
        </div>
      </div>
    </section>
    
    <h3>Your Cart</h3>
    <div id="cart"></div>
    <!-- Hidden fields to store cart details -->
    <form method="post" id="orderForm" action="">
      <input type="hidden" name="items" id="itemsInput" value="" />
      <input type="hidden" name="total" id="totalInput" value="0" />
      <h3>Delivery Details</h3>
      <div class="input-group">
        <input type="text" name="deliveryAddress" placeholder="Enter delivery address" class="delivery-input" required />
      </div>
      <div class="input-group">
        <input type="text" name="contactNumber" placeholder="Enter contact number" class="delivery-input" required />
      </div>
      <button type="submit" name="order" class="primary-btn">Place Order</button>
    </form>
    <?php if(isset($receipt)) { echo "<pre>$receipt</pre>"; } ?>
  </main>
  <script src="script.js"></script>
</body>
</html>
