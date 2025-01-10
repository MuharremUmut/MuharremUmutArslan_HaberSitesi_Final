<?php
session_start();
include('includes/db.php');

// Kayıt işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $password = htmlspecialchars(trim($_POST['password'] ?? ''));

    // Kullanıcı adı ve şifre kontrolü
    if (!empty($username) && !empty($password)) {
        // Kullanıcıyı veritabanına ekle
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password); // Şifre düz metin olarak saklanıyor (güvenli değil)

        if ($stmt->execute()) {
            // Başarılı kayıt
            $_SESSION['username'] = $username;
            header("Location: login.php"); // Kayıt olduktan sonra giriş sayfasına yönlendir
            exit();
        } else {
            $error = "Kayıt sırasında bir hata oluştu.";
        }
    } else {
        $error = "Tüm alanları doldurduğunuzdan emin olun.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="register-form">
        <h1>Kayıt Ol</h1>
        <form action="register.php" method="POST">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" placeholder="Kullanıcı adınızı girin" required>

            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" placeholder="Şifrenizi girin" required>

            <button type="submit">Kayıt Ol</button>
        </form>

        <?php
        if (isset($error)) {
            echo "<p style='color: red;'>$error</p>";
        }
        ?>

        <a href="login.php">Zaten hesabınız var mı? Giriş yapın</a>
    </div>
</body>
</html>
