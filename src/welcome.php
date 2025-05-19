<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Kullanıcıyı karşılamak için
$user_id = $_SESSION['user_id'];

// Veritabanı bağlantısı
include('db.php');

// Kullanıcı adı veya bilgilerini almak isterseniz:
$query = "SELECT username FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ana Sayfa</title>
    <link rel="stylesheet" href="css\Wstyle.css">
    <script src="script\script.js" defer></script>
</head>
<body>
    <header>
        <h1>Hoş Geldiniz, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <nav>
            <a href="welcome.php">Ana Sayfa</a> |
            <a href="logout.php">Çıkış Yap</a> |
            <a href="contact.php">İletişim</a>
        </nav>
    </header>

    <div class="main-content">
        <h2>Seçiminizi Yapın</h2>
        <p>Blog sayfamıza hoş geldiniz! Ne yapmak istersiniz?</p>
        <div class="options">
            <a href="browse.php" class="btn">Gezin</a>
            <a href="write.php" class="btn">Yazı Yaz</a>
        </div>
    </div>
</body>
</html>
