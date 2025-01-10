<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Giriş yapılmadıysa login sayfasına yönlendirme
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Anasayfası</title>
    <link rel="stylesheet" href="user_home.css">
</head>
<body>
    <header>
        <h1>HOŞGELDİN HOLİGAN</h1>
        <nav>
            <a href="account.php">Hesabım</a>
            <a href="logout.php">Çıkış Yap</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>Anasayfaya Hoşgeldiniz</h2>
            <p>Bu sayfadan kendi kullanıcı bilgilerinize erişebilirsiniz.</p>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Spor Haberleri</p>
    </footer>
</body>
</html>
