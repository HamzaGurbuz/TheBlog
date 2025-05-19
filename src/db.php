<?php

// Veritabanı bağlantısı

$host = "localhost";
$db = "blog";
$user = "root"; // XAMPP'de varsayılan kullanıcı adı
$pass = ""; // XAMPP'de varsayılan şifre boş

// Bağlantıyı kurma
$conn = new mysqli($host, $user, $pass, $db);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

echo "";
?>