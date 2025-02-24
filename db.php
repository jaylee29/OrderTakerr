<?php
// db.php – Database connection using PDO
$host = "localhost";
$dbname = "ordertaker"; // your database name
$user = "root";         // your database username
$pass = "";             // your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
