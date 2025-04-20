<?php
session_start();
include('db.php');

if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);
    $query = "SELECT * FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
} else {
    $row = null;
}

// Yorum ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $comment = $conn->real_escape_string($_POST['comment']);
    $username = $_SESSION['username'] ?? 'Bilinmeyen';

    $insert = "INSERT INTO comments (post_id, username, comment) VALUES ($post_id, '$username', '$comment')";
    mysqli_query($conn, $insert);
}

// Yorumları çekme
$comment_query = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
$comments = mysqli_query($conn, $comment_query);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row ? htmlspecialchars($row['title']) : "Yazı Bulunamadı"; ?></title>
    <link rel="stylesheet" href="post-style.css">
    <style>
        textarea {
            width: 100%;
            height: 60px;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        .comment-box {
            margin-top: 40px;
        }

        .comment {
            background-color: #f8f8f8;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        .comment .author {
            font-weight: bold;
            color: #2c3e50;
        }

        .delete-link {
            float: right;
            color: red;
            text-decoration: none;
            font-size: 12px;
        }

        .delete-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($row): ?>
            <h1><?php echo htmlspecialchars($row['title']); ?></h1>
            <p><strong>Yazar: </strong><?php echo htmlspecialchars($row['writer']); ?></p>
            <p><strong>Admin Onayı: </strong><?php echo $row['approved'] == 1 ? "Onaylı" : "Onaysız"; ?></p>
            <p>(Eğer Bu Metin Admin tarafından onaylanmamışsa silinebilir)</p>
            <div class="content">
                <?php echo nl2br(htmlspecialchars($row['content'])); ?>
            </div>

            <!-- Yorum Ekleme -->
            <div class="comment-box">
                <h3>Yorum Yap</h3>
                <form method="POST">
                    <textarea name="comment" placeholder="Yorumunuzu yazın...(Topluluk kurallarına uygun davranmaya özen gösterin)" required></textarea><br>
                    <button type="submit">Gönder</button>
                </form>
            </div>

            <!-- Yorumlar -->
            <div class="comments">
                <h3>Yorumlar</h3>
                <?php while($c = mysqli_fetch_assoc($comments)): ?>
                    <div class="comment">
                        <span class="author"><?php echo htmlspecialchars($c['username']); ?></span>
                        <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $c['username']): ?>
                            <a class="delete-link" href="delete_comment.php?id=<?php echo $c['id']; ?>&post_id=<?php echo $post_id; ?>">Sil</a>
                        <?php endif; ?>
                        <p><?php echo nl2br(htmlspecialchars($c['comment'])); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <h2>Yazı bulunamadı</h2>
        <?php endif; ?>

        <a href="browse.php" class="back-link">← Geri Dön</a>
    </div>
</body>
</html>
