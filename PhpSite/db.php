<?php
$servername = "localhost";
$username = "root";  // XAMPP için genellikle 'root'
$password = "";      // XAMPP için genellikle boş
$dbname = "holigan";

// PDO ile veritabanına bağlanma
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Hata modu ayarla
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>