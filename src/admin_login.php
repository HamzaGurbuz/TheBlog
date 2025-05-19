<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_user = "admin";
    $admin_pass = "6436"; // Gerçekte daha güvenli şifrele ama örnek bu

    if ($_POST["username"] === $admin_user && $_POST["password"] === $admin_pass) {
        $_SESSION["admin_logged_in"] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Hatalı kullanıcı adı ya da şifre";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Giriş</title>
    <link rel="stylesheet" href="css\Wstyle.css">
</head>
<body>
    <h2>Admin Giriş</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        Kullanıcı Adı: <input type="text" name="username"><br>
        Şifre: <input type="password" name="password"><br>
        <input type="submit" value="Giriş Yap">
    </form>
    <p>
</body>
</html>
