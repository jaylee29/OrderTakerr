<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Admin login check
    if ($username === "admin" && $password === "bsit") {
        $_SESSION["username"] = "admin";
        $stmt = $pdo->prepare("INSERT INTO login_history (username, login_time) VALUES (?, NOW())");
        $stmt->execute(["admin"]);
        header("Location: menu.php");
        exit;
    } else {
        // Regular user login
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        if ($stmt->rowCount() > 0) {
            $_SESSION["username"] = $username;
            $stmt2 = $pdo->prepare("INSERT INTO login_history (username, login_time) VALUES (?, NOW())");
            $stmt2->execute([$username]);
            header("Location: menu.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>OrderTaker - Login</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body class="login-body">

  <div class="login-container">
    <h2 class="brand-title">OrderTaker</h2> <!-- Brand name above the logo -->
    <div class="logo-container">
      <img src="images/ordertaker-logo.png" alt="OrderTaker Logo" class="logo-img" />
    </div>
    <h2 class="form-title">LOGIN</h2>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="">
      <div class="input-group">
        <input type="text" name="username" placeholder="USERNAME" required />
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="PASSWORD" required />
      </div>
      <button type="submit" class="primary-btn form-btn">LOGIN</button>
    </form>
    <p class="signup-text">Not a member? <a href="signup.php">Sign up now</a></p>
  </div>
</body>
</html>
