<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ana Sayfa</title>
    <link rel="stylesheet" href="Wstyle.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1>Hoş Geldiniz</h1>
        <nav>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php">Kayıt Ol</a> |
                <a href="login.php">Giriş Yap</a>
            <?php else: ?>
                <a href="write.php">Yazı Yaz</a> |
                <a href="browse.php">Gezin</a> |
                <a href="logout.php">Çıkış Yap</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="main-content">
        <h2>Blog Sitemize Hoş Geldiniz!</h2>
        <p>Yazılarınızı paylaşmak ve gezmek için giriş yapın.</p>
    </div>
</body>
</html>
