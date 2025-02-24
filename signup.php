<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    
    if (!$username || !$password) {
        $error = "Please fill out all fields.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $error = "Username already taken.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $password]);
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>OrderTaker - Sign Up</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body class="login-body">
<div class="login-container">
    <h2 class="brand-title">OrderTaker</h2> <!-- Brand name above the logo -->
    <div class="logo-container">

      <img src="images/ordertaker-logo.png" alt="OrderTaker Logo" class="logo-img" />
    </div>
    <h2 class="form-title">SIGN UP</h2>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="">
      <div class="input-group">
        <input type="text" name="username" placeholder="USERNAME" required />
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="PASSWORD" required />
      </div>
      <button type="submit" class="primary-btn form-btn">REGISTER</button>
    </form>
    <p class="signup-text">Already have an account? <a href="index.php">Login here</a></p>
  </div>
</body>
</html>
