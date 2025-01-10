<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php"); // Oturum kapandıktan sonra ana sayfaya yönlendirme
exit;
?>
