<?php
// Oturumu başlat
session_start();
include('includes/db.php');

// Admin kontrolü
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Yetkisi olmayanları yönlendir
    exit();
}

// Silinecek haberin ID'si
if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    // Veritabanından haberi sil
    $stmt = $conn->prepare("DELETE FROM news WHERE id = :id");
    $stmt->bindParam(':id', $news_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: admin.php"); // Silme başarılıysa admin sayfasına yönlendir
        exit();
    } else {
        echo "Haber silinemedi!";
    }
} else {
    echo "Geçersiz haber ID!";
}
?>
