<?php 
session_start();
include('includes/db.php');

// ID parametresini al
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $news_id = $_GET['id'];

    // Haber detayını veritabanından al
    $stmt = $conn->prepare("SELECT * FROM news WHERE id = :id");
    $stmt->bindParam(':id', $news_id);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kategoriyi kontrol et
    if (!$article) {
        echo "Haber bulunamadı.";
        exit;
    }

    // Kategoriye göre CSS dosyasını belirle
    $category = $article['category']; // Kategoriyi veritabanından al

    // Kategoriye göre CSS dosyasını seç
    if ($category == 'futbol') {
        $cssFile = 'futbol.css';
    } elseif ($category == 'basketbol') {
        $cssFile = 'basketbol.css';  // basketbol.css dosyasını eklemeyi unutma
    } elseif ($category == 'ufc') {
        $cssFile = 'ufc.css';
    } elseif ($category == 'formula1') {
        $cssFile = 'formula1.css';
    } else {
        $cssFile = 'default.css';  // Varsayılan CSS dosyası
    }
} else {
    echo "Geçersiz haber ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?></title>
    <link rel="stylesheet" href="<?php echo $cssFile; ?>"> <!-- Dinamik CSS dosyası -->
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($article['title']); ?></h1>
    </header>

    <main>
        <div class="news-detail">
            <p><strong>Yayınlanma Tarihi: </strong><?php echo htmlspecialchars($article['created_at']); ?></p>
            <div class="news-content">
                <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
            </div>
        </div>

        <!-- Ana Sayfa Butonu -->
        <a href="index.php" class="btn-back-home">Ana Sayfa</a>
    </main>

    <footer>
        <p>&copy; 2024 HOLİGAN HABER</p>
    </footer>
</body>
</html>
