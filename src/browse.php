<?php
include('db.php');

// Arama sorgusu kontrolü
$search = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';
if ($search != '') {
    $sql = "SELECT id, title, content, writer, image FROM posts 
            WHERE title LIKE '%$search%' OR content LIKE '%$search%' OR writer LIKE '%$search%' 
            ORDER BY writer DESC";
} else {
    $sql = "SELECT id, title, content, writer, image FROM posts ORDER BY writer DESC";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Gezin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: linear-gradient(to right, #83a4d4, #b6fbff);
        }

        h1 {
            color: #2c3e50;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 250px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button, .clear-button {
            padding: 10px 15px;
            margin-left: 5px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        button:hover, .clear-button:hover {
            background-color: #2980b9;
        }

        .post-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .post-preview {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .post-preview h2 {
            margin-top: 0;
            color: #2c3e50;
        }

        .read-more {
            display: inline-block;
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .read-more:hover {
            text-decoration: underline;
        }

        .back-button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #2980b9;
        }

        .post-image {
            margin-top: 10px;
        }

        .post-image img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<h1>Aktif Yazılar</h1>

<!-- Arama Formu -->
<form method="GET">
    <input type="text" name="q" placeholder="Bir kelime ara..." value="<?php echo htmlspecialchars($search); ?>" />
    <button type="submit">Ara</button>
    <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>" class="clear-button">Temizle</a>
</form>

<div class="post-container">
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $preview = mb_substr($row['content'], 0, 200) . '...';
        echo "<div class='post-preview'>";
        echo "<h2><a href='post.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["title"]) . "</a></h2>";
        echo "<p><strong>Yazar: </strong>" . htmlspecialchars($row["writer"]) . "</p>";
        echo "<p>" . nl2br(htmlspecialchars($preview)) . "</p>";
        if (!empty($row['image'])) {
            echo "<div class='post-image'><img src='" . htmlspecialchars($row['image']) . "' alt='Yazı Görseli'></div>";
        }
        echo "<a class='read-more' href='post.php?id=" . $row["id"] . "'>Devamını oku</a>";
        echo "</div>";
    }
} else {
    echo "<p>Aramanıza uygun yazı bulunamadı.</p>";
}
?>
</div>

<a class="back-button" href="welcome.php">Ana Sayfaya Dön</a>

</body>
</html>
