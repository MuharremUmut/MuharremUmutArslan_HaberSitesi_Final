<?php
session_start();
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Şifreyi hashle

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    
    if ($stmt->execute()) {
        echo "Kayıt başarılı! <a href='login.php'>Giriş yap</a>";
    } else {
        echo "Bir hata oluştu.";
    }
}
?>
