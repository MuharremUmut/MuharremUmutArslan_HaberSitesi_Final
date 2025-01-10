<?php
session_start();
include('includes/db.php');

// Giriş kontrolü
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $password = htmlspecialchars(trim($_POST['password'] ?? ''));

    // Kullanıcıyı veritabanında kontrol et
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) { // Şifre kontrolü (hash kullanılmıyor)
        // Başarılı giriş, oturumda kullanıcı bilgilerini sakla
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role']; // Kullanıcının rolünü sakla (örneğin: admin veya user)

        // Admin ise admin paneline yönlendir, değilse ana sayfaya
        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Kullanıcı adı veya şifre hatalı!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-form">
        <h1>Giriş Yap</h1>
        <form action="login.php" method="POST">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" placeholder="Kullanıcı adınızı girin" required>

            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" placeholder="Şifrenizi girin" required>

            <button type="submit">Giriş Yap</button>
        </form>

        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?= $error; ?></p>
        <?php endif; ?>

        <a href="register.php">Hesabınız yok mu? Kaydolun</a>
    </div>
</body>
</html>
