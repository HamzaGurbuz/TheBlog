<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İletişim</title>
    <link rel="stylesheet" href="css\style.css">
</head>
<body>

<header>
    <h1>İletişim Sayfası</h1>
    <nav>
        <a href="index.php">Anasayfa</a> |
        <a href="login.php">Giriş</a> |
        <a href="contact.php">İletişim</a>
    </nav>
</header>

<div class="main-content">
    <h2>Bize Ulaşın</h2>

    <?php
    include("db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $isim = $conn->real_escape_string($_POST["isim"]);
        $email = $conn->real_escape_string($_POST["email"]);
        $mesaj = $conn->real_escape_string($_POST["mesaj"]);

        $sql = "INSERT INTO mails (isim, email, mesaj) VALUES ('$isim', '$email', '$mesaj')";


        if ($conn->query($sql) === TRUE) {
            echo "<p>Teşekkürler, <strong>$isim</strong>. Mesajınız kaydedildi.</p>";
        } else {
            echo "<p>Hata oluştu: " . $conn->error . "</p>";
        }

        $conn->close();
    } else {
    ?>

    <form method="POST" action="contact.php">
        <div class="form-group">
            <label for="isim">İsim</label>
            <input type="text" id="isim" name="isim" required>
        </div>

        <div class="form-group">
            <label for="email">E-posta</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="mesaj">Mesajınız</label>
            <textarea id="mesaj" name="mesaj" rows="5" required></textarea>
        </div>

        <button type="submit">Gönder</button>
    </form>

    <?php } ?>
</div>

</body>
</html>
