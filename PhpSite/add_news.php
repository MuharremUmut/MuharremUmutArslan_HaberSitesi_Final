<?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news_site";

// Bağlantıyı kur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    // Veritabanına veri ekleme
    $query = "INSERT INTO news (title, content, category_id, created_at) 
              VALUES ('$title', '$content', '$category_id', NOW())";

    if ($conn->query($query) === TRUE) {
        echo "Haber başarıyla eklendi.";
        header("Location: index.php"); // Ekledikten sonra anasayfaya yönlendir
        exit();
    } else {
        echo "Hata: " . $conn->error;
    }
}

// Kategorileri al
$category_query = "SELECT * FROM categories";
$category_result = $conn->query($category_query);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Haber Ekle</title>
</head>
<body>
    <h1>Haber Ekle</h1>
    <form action="add_news.php" method="POST">
        <label for="title">Başlık:</label><br>
        <input type="text" name="title" required><br><br>

        <label for="content">İçerik:</label><br>
        <textarea name="content" required></textarea><br><br>

        <label for="category_id">Kategori Seç:</label><br>
        <select name="category_id" required>
            <?php while ($row = $category_result->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select><br><br>

        <input type="submit" value="Ekle">
    </form>
</body>
</html>

<?php $conn->close(); ?>
