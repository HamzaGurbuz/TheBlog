<?php
session_start();
include('db.php');

// Yazıları çekiyoruz
$sql = "SELECT id, title, content, writer, image FROM posts ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ana Sayfa</title>
    <link rel="stylesheet" href="css\Wstyle.css">
    <style>
        body {
            background: linear-gradient(to right, #83a4d4, #b6fbff);
            font-family: Arial, sans-serif;
            padding: 0 20px;
        }

        header {
            text-align: center;
            margin: 20px 0;
            background: linear-gradient(to right, #74ebd5, #acb6e5);
        }

        nav a {
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
            color: #2c3e50;
        }

        .main-content {
            text-align: center;
        }

        .post-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .post-preview {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-self: start;
            height: 100%;
            text-align: left;
        }

        .post-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .post-preview h2 {
            margin-top: 0;
            color: #2c3e50;
        }

        .read-more {
            display: inline-block;
            margin-top: auto;
            color: rgb(249, 249, 249);
            background-color: #3498db;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .read-more:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<header>
    <h1>Hoş Geldiniz</h1>
    <nav>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="register.php">Kayıt Ol</a> |
            <a href="login.php">Giriş Yap</a> |
            <a href="contact.php">İletişim</a>
        <?php else: ?>
            <a href="write.php">Yazı Yaz</a> |
            <a href="browse.php">Gezin</a> |
            <a href="logout.php">Çıkış Yap</a> |
            <a href="contact.php">İletişim</a>
        <?php endif; ?>
    </nav>
</header>

<div class="main-content">
    <h2>Blog Sitemize Hoş Geldiniz!</h2>
    <p>Yazılarınızı paylaşmak ve gezmek için giriş yapın.</p>

    <div class="post-container">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $preview = mb_substr($row['content'], 0, 200) . '...';
            echo "<div class='post-preview'>";
            if (!empty($row['image_url'])) {
                echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Yazı Resmi'>";
            }
            echo "<h2>" . htmlspecialchars($row["title"]) . "</h2>";
            echo "<p><strong>Yazar: </strong>" . htmlspecialchars($row["writer"]) . "</p>";
            echo "<p>" . nl2br(htmlspecialchars($preview)) . "</p>";

            if (isset($_SESSION['user_id'])) {
                echo "<a class='read-more' href='post.php?id=" . $row["id"] . "'>Devamını oku</a>";
            } else {
                echo "<a class='read-more' href='login.php'>Devamını oku</a>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>Henüz paylaşılmış yazı yok.</p>";
    }

    $conn->close();
    ?>
    </div>
</div>
</body>
</html>
