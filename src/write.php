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
    $writer = $_SESSION['username'];
    $approved = 0;

    // Resim dosyalarını işleme
    $imagePaths = [];
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'][0])) {
        $totalFiles = count($_FILES['image']['name']);
        for ($i = 0; $i < $totalFiles; $i++) {
            $imageTmpName = $_FILES['image']['tmp_name'][$i];
            $imageName = basename($_FILES['image']['name'][$i]);
            $imagePath = 'uploads/' . uniqid() . '_' . $imageName;

            if (move_uploaded_file($imageTmpName, $imagePath)) {
                $imagePaths[] = $imagePath;
            } else {
                echo "Resim yüklenirken bir hata oluştu.";
                exit;
            }
        }
    }

    // Resimleri virgülle ayırarak veritabanına kaydet
    $imagePathsStr = implode(',', $imagePaths);

    $query = "INSERT INTO posts (title, content, writer, approved, image) 
              VALUES ('$title', '$content', '$writer', '$approved', '$imagePathsStr')";

    if (mysqli_query($conn, $query)) {
        echo "✅ Yazınız başarıyla gönderildi, admin onaylayacak.";
    } else {
        echo "❌ Hata oluştu: " . mysqli_error($conn);
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
            <a href="logout.php">Çıkış Yap</a> |
            <a href="contact.php">İletişim</a>
        </nav>
    </header>

    <div class="main-content">
        <h2>Yazınızı Gönderin</h2>
        <form action="write.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Başlık:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="content">İçerik:</label>
                <textarea id="content" name="content" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Resimleri Yükle (isteğe bağlı):</label>
                <input type="file" id="image" name="image[]" accept="image/*" multiple>
            </div>

            <button type="submit">Yazıyı Gönder</button>
        </form>
    </div>
</body>
</html>
