<?php
session_start();
require 'db.php';
if (!isset($_SESSION["username"]) || $_SESSION["username"] != "admin") {
    header("Location: menu.php");
    exit;
}
$orders = $pdo->query("SELECT * FROM orders ORDER BY order_time DESC")->fetchAll(PDO::FETCH_ASSOC);
$logins = $pdo->query("SELECT * FROM login_history ORDER BY login_time DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>OrderTaker - History</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header class="navbar">
    <div class="logo">
      <h2>OrderTaker History</h2>
    </div>
    <nav>
      <a href="menu.php" class="nav-link">Back to Menu</a>
    </nav>
  </header>
  <main class="history-page">
    <h1>Order & Login History</h1>
    <section class="history-section">
      <h2>Order History</h2>
      <?php if(count($orders) == 0) {
          echo "<p>No orders placed yet.</p>";
      } else {
          foreach($orders as $order) {
              echo "<div class='history-record'>";
              echo "<p><strong>Order #:</strong> {$order['order_number']}</p>";
              echo "<p><strong>Date:</strong> {$order['order_time']}</p>";
              echo "<p><strong>Customer:</strong> {$order['customer']}</p>";
              echo "<p><strong>Delivery Address:</strong> {$order['delivery_address']}</p>";
              echo "<p><strong>Contact:</strong> {$order['contact_number']}</p>";
              echo "<p><strong>Items:</strong> {$order['items']}</p>";
              echo "<p><strong>Total:</strong> \${$order['total']}</p>";
              echo "<hr /></div>";
          }
      } ?>
    </section>
    <section class="history-section">
      <h2>Login History</h2>
      <?php if(count($logins) == 0) {
          echo "<p>No logins recorded yet.</p>";
      } else {
          foreach($logins as $login) {
              echo "<div class='history-record'>";
              echo "<p><strong>User:</strong> {$login['username']}</p>";
              echo "<p><strong>Date/Time:</strong> {$login['login_time']}</p>";
              echo "<hr /></div>";
          }
      } ?>
    </section>
  </main>
</body>
</html>
