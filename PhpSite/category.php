<?php
// Veritabanı bağlantısı
$conn = new mysqli("localhost", "root", "", "news_site");

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Kategorileri al
$category_query = "SELECT * FROM categories";
$category_result = $conn->query($category_query);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kategoriler</title>
</head>
<body>
    <h1>Kategoriler</h1>

    <?php while ($category = $category_result->fetch_assoc()) { ?>
        <h2><?php echo $category['name']; ?></h2>
        <?php
        // Bu kategoriye ait haberleri al
        $news_query = "SELECT * FROM news WHERE category_id = " . $category['id'];
        $news_result = $conn->query($news_query);

        while ($news = $news_result->fetch_assoc()) {
        ?>
            <p>
                <a href="news_detail.php?id=<?php echo $news['id']; ?>"><?php echo $news['title']; ?></a><br>
                <small>Yayınlanma Tarihi: <?php echo $news['created_at']; ?></small>
            </p>
        <?php } ?>
    <?php } ?>

</body>
</html>

<?php $conn->close(); ?>
