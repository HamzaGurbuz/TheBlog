<?php
include('db.php');

session_start();

$hata = ''; // Hata mesajı için değişken

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: welcome.php");
            exit();
        } else {
            $hata = "Geçersiz şifre!";
        }
    } else {
        $hata = "Kullanıcı bulunamadı!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="css\Wstyle.css">
    <script src="script\script.js" defer></script>
</head>
<body>
    <h2>Giriş Yap</h2>

    <?php if (!empty($hata)) echo "<p style='color: red;'>$hata</p>"; ?>

    <form method="POST" action="login.php">
        <label for="email">E-posta:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Şifre:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Giriş Yap">
    </form>

    <h5>Henüz bir hesabın yok mu?</h5>
    <a href="register.php">Kayıt ol</a> |
    <a href="index.php">Ana Sayfa</a>

</body>
</html>
