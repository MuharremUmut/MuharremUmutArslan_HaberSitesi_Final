<?php
session_start();
include('includes/db.php');

// Futbol ile ilgili haberleri çek
$stmt = $conn->prepare("SELECT * FROM news WHERE category = 'futbol' ORDER BY created_at DESC");
$stmt->execute();
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futbol Haberleri - HOLİGAN SPOR</title>
    <link rel="stylesheet" href="futbol.css">
</head>
<body>
    <header>
        <h1>Futbol Haberleri</h1>
        <a href="index.php" class="btn">Ana Sayfa</a>
    </header>
    <main>
        <section class="content">
            <h2>Güncel Spor Seçenekleri</h2>
            <div class="sport-options">
                <div class="sport-item">
                    <h3>Futbol</h3>
                    <p>Beşiktaş bir dünya yıldızını daha renklerine bağladı. RAFA SİLVA...</p>
                    <a href="futbol.php" class="btn">Detaylar</a>
                </div>
            <div class="news-container">
                <?php foreach ($news as $article): ?>
                    <div class="news-card">
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($article['content'], 0, 100)); ?>...</p>
                        <small>Tarih: <?php echo htmlspecialchars($article['created_at']); ?></small>
                        <a href="detail.php?id=<?php echo $article['id']; ?>" class="btn">Haberi İncele</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 HOLİGAN SPOR</p>
    </footer>
</body>
</html>