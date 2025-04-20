<?php
session_start();
include('db.php');

// Kullanıcı giriş yapmamışsa, uyarı göster
if (!isset($_SESSION['username'])) {
    die("Lütfen giriş yapın!");
}

// Yazı gönderme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $writer = $_SESSION['username']; // Session'dan kullanıcı adı
    $approved = 0; // Başlangıçta onaylanmamış

    // Yazıyı veritabanına ekle
    $query = "INSERT INTO posts (title, content, writer, approved) VALUES ('$title', '$content', '$writer', '$approved')";
    if (mysqli_query($conn, $query)) {
        echo "Yazınız başarıyla gönderildi, admin onaylayacak.";
    } else {
        echo "Hata oluştu: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yazı Gönder</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1>Yazı Gönder</h1>
        <nav>
            <a href="welcome.php">Ana Sayfa</a> |
            <a href="logout.php">Çıkış Yap</a>
        </nav>
    </header>

    <div class="main-content">
        <h2>Yazınızı Gönderin</h2>
        
        <!-- Yazı gönderme formu -->
        <form action="write.php" method="POST">
            <div class="form-group">
                <label for="title">Başlık:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="content">İçerik:</label>
                <textarea id="content" name="content" rows="5" required></textarea>
            </div>

            <button type="submit">Yazıyı Gönder</button>
        </form>
    </div>
</body>
</html>
