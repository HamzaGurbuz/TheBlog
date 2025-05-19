<?php
include('db.php');

$hata = ''; // Hata mesajı için değişken

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Kullanıcı adı veya e-posta kontrolü
    $checkSql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        $hata = "Bu kullanıcı adı veya e-posta zaten kayıtlı.";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: welcome.php");
            exit();
        } else {
            $hata = "Hata: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="css\Wstyle.css">
    <script src="script\script.js" defer></script>
</head>
<body>
    <h2>Kullanıcı Kayıt Formu</h2>

    <?php if (!empty($hata)) echo "<p style='color: red;'>$hata</p>"; ?>

    <form method="POST" action="register.php">
        <label for="username">Kullanıcı Adı:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">E-posta:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Şifre:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Kayıt Ol">
    </form>

    <h5>Zaten bir hesabın var mı?</h5>
    <a href="login.php">Giriş Yap</a> |
    <a href="index.php">Ana Sayfa</a>

</body>
</html>
