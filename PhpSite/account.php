<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Giriş yapılmadıysa login sayfasına yönlendirme
    exit;
}

include('includes/db.php');

// Kullanıcı bilgilerini al
$stmt = $conn->prepare("SELECT username, role FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Kullanıcının takip ettiği kategorileri al
$categoryStmt = $conn->prepare("SELECT category_name FROM user_categories WHERE user_id = :id");
$categoryStmt->execute([':id' => $_SESSION['user_id']]);
$categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hesabım</title>
    <link rel="stylesheet" href="user_home.css">
</head>
<body>
    <header>
        <h1>Hesap Bilgilerim</h1>
        <nav>
            <a href="index.php">Anasayfa</a>
            <a href="logout.php">Çıkış Yap</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>Kullanıcı Bilgileri</h2>
            <p><strong>Kullanıcı Adı:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Rol:</strong> <?php echo htmlspecialchars($user['role'] === 'admin' ? 'Admin' : 'Okuyucu'); ?></p>
            <p><strong>Takip Ettiği Kategoriler:</strong> 
                <?php echo !empty($categories) ? htmlspecialchars(implode(', ', $categories)) : 'Henüz takip edilen bir kategori yok.'; ?>
            </p>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Spor Haberleri</p>
    </footer>
</body>
</html>
