<?php
// Admin Paneli (admin.php)

// Oturumu başlat
session_start();
include('includes/db.php');

// Kullanıcının admin olup olmadığını kontrol et
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Yetkisi olmayanları yönlendir
    exit();
}

// Yeni haber ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = htmlspecialchars($_POST['title']); // XSS güvenliği için özel karakterleri temizle
    $content = htmlspecialchars($_POST['content']); // İçerik temizleme
    $category = htmlspecialchars($_POST['category']); // Kategori ekleme (opsiyonel)

    // Dosya yükleme işlemi kaldırıldı
    $image = null; // Dosya yüklenmeyecek

    // Haber veritabanına ekle
    $stmt = $conn->prepare("INSERT INTO news (title, content, category, image, created_at) VALUES (:title, :content, :category, :image, NOW())");
    $stmt->execute(['title' => $title, 'content' => $content, 'category' => $category, 'image' => $image]);
    $message = "Haber başarıyla eklendi!"; // İşlem mesajı
}

// Haberleri listele
$stmt = $conn->prepare("SELECT * FROM news ORDER BY created_at DESC"); 
$stmt->execute();
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h1>Admin Paneli</h1>
        <nav>
            <a href="index.php">Anasayfa</a>
            <a href="logout.php">Çıkış Yap</a>
        </nav>
    </header>
    <main>
        <section class="admin-form">
            <h2>Yeni Haber Ekle</h2>
            <!-- Haber ekleme formu -->
            <?php if (isset($message)): ?>
                <p class="success-message"><?= $message; ?></p>
            <?php endif; ?>
            <form method="post">
                <input type="text" name="title" placeholder="Haber Başlığı" required>
                <textarea name="content" placeholder="Haber İçeriği" required></textarea>
                <select name="category" required>
                    <option value="">Kategori Seçin</option>
                    <option value="futbol">Futbol</option>
                    <option value="ufc">UFC</option>
                    <option value="formula1">Formula 1</option>
                </select>
                <!-- Dosya yükleme kısmı kaldırıldı -->
                <button type="submit">Haber Ekle</button>
            </form>
        </section>

        <section class="news">
            <h2>Mevcut Haberler</h2>
            <?php if (count($news) > 0): ?>
                <div class="news-container">
                    <?php foreach ($news as $article): ?>
                        <article class="news-item">
                            <h2><?= htmlspecialchars($article['title']); ?></h2>
                            <p><?= nl2br(htmlspecialchars($article['content'])); ?></p>
                            <?php if ($article['image']): ?>
                                <img src="<?= htmlspecialchars($article['image']); ?>" alt="Haber Resmi">
                            <?php endif; ?>
                            <small>Tarih: <?= $article['created_at']; ?> | Kategori: <?= htmlspecialchars($article['category']); ?></small>
                            <a class="delete-btn" href="delete.php?id=<?= $article['id']; ?>">Sil</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Henüz hiç haber eklenmemiş.</p>
            <?php endif; ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Spor Haberleri Admin Paneli</p>
    </footer>
</body>
</html>
