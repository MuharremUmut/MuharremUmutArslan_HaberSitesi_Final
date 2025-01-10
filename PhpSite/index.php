<?php
session_start();
include('includes/db.php'); 

// Haberleri veritabanından çek
$stmt = $conn->prepare("SELECT * FROM news ORDER BY created_at DESC");
$stmt->execute();
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOLİGAN SPOR</title>
    <link rel="stylesheet" href="style.css"> <!-- Mevcut stil dosyanız -->
    <link rel="stylesheet" href="news.css"> <!-- Yeni stil dosyanız -->
</head>
<body>
    <header>
        <h1>HOLİGAN HABER</h1>
        <div class="header-container">
            <!-- Sol Üst Köşe: Spor Seçenekleri -->
            <div class="sport-options-left">
                <a href="futbol.php">Futbol</a>
                <a href="ufc.php">UFC</a>
                <a href="formula1.php">Formula 1</a>
            </div>
            <!-- Sağ Üst Köşe: Giriş ve Kayıt -->
            <div class="auth-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="user_home.php">Anasayfa</a>
                    <a href="admin.php">Hesabım</a>
                    <a href="logout.php">Çıkış Yap</a>
                <?php else: ?>
                    <a href="login.php">Giriş Yap</a>
                    <a href="register.php">Kayıt Ol</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <!-- Spor Seçenekleri -->
        <section class="content">
            <h2>Güncel Spor Seçenekleri</h2>
            <div class="sport-options">
                <div class="sport-item">
                    <h3>Futbol</h3>
                    <p>Beşiktaş bir dünya yıldızını daha renklerine bağladı. RAFA SİLVA...</p>
                    <a href="futbol.php" class="btn">Detaylar</a>
                </div>
                <div class="sport-item">
                    <h3>UFC</h3>
                    <p>UFC'de TÜRK'ün yumruk sesleri.</p>
                    <a href="ufc.php" class="btn">Detaylar</a>
                </div>
                <div class="sport-item">
                    <h3>Formula 1</h3>
                    <p>Max Verstappen 4 yıl üst üste şampiyon.</p>
                    <a href="formula1.php" class="btn">Detaylar</a>
                </div>
                <div class="sport-item">
                    <h3>UFC</h3>
                    <p>Khamzat Chımaev patrondan hakettiği kemeri istedi.</p>
                    <a href="ufc.php" class="btn">Detaylar</a>
                </div>
            </div>
        </section>

        <!-- Haberler -->
        <section class="news">
            <?php if (count($news) > 0): ?>
                <div class="news-container">
                    <?php foreach ($news as $article): ?>
                        <article class="news-item">
                            <!-- Haber resmi -->
                            <?php if ($article['image']): ?>
                                <img src="images/<?php echo htmlspecialchars($article['image']); ?>" alt="Haber Resmi">
                            <?php endif; ?>
                            <div class="news-content">
                                <h2><?php echo htmlspecialchars($article['title']); ?></h2>
                                <p><?php echo htmlspecialchars(substr($article['content'], 0, 100)); ?>...</p>
                                <small>Tarih: <?php echo htmlspecialchars($article['created_at']); ?> | Kategori: <?php echo htmlspecialchars($article['category']); ?></small>
                                <!-- Haberi detay sayfasına yönlendirme -->
                                <a href="news_detail.php?id=<?php echo $article['id']; ?>" class="btn">Haberi İncele</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Henüz hiç haber eklenmemiş.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 HOLİGAN HABER</p>
    </footer>
</body>
</html>
