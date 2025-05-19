<?php
session_start();
include('db.php');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Yazılar
$query = "SELECT posts.id, posts.title, posts.content, posts.approved, posts.writer FROM posts";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Sorgu hatası: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yazıları Gezin</title>
    <link rel="stylesheet" href="css\admin-style.css">
    <style>
        .comment-box {
            background-color: #f9f9f9;
            border-left: 3px solid #3498db;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .comment-actions {
            margin-top: 5px;
        }
        .comment-actions form {
            display: inline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Yazıları Gezin</h1>
        <nav>
            <a href="index.php">Ana Sayfa</a> |
            <a href="logout.php">Çıkış Yap</a>
        </nav>
    </header>

    <div class="main-content">
        <h2>Aktif Yazılar</h2>
        
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="post">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <p><strong>Yazar:</strong> <?php echo htmlspecialchars($row['writer']); ?></p>
                <p><strong>Onay Durumu:</strong> <?php echo $row['approved'] ? 'Onaylı' : 'Onaysız'; ?></p>

                <!-- Onayla -->
                <?php if ($row['approved'] == 0): ?>
                    <form method="POST" action="approve.php">
                        <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="approve">Onayla</button>
                    </form>
                <?php endif; ?>

                <!-- Sil -->
                <form method="POST" action="delete.php">
                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete">Sil</button>
                </form>

                <!-- Yorumlar -->
                <h4>Yorumlar:</h4>
                <?php
                $post_id = $row['id'];
                $comment_query = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
                $comment_result = mysqli_query($conn, $comment_query);
                if ($comment_result && mysqli_num_rows($comment_result) > 0):
                    while ($comment = mysqli_fetch_assoc($comment_result)): ?>
                        <div class="comment-box">
                            <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> <?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                            <div class="comment-actions">
                                <form method="POST" action="delete_comment.php" onsubmit="return confirm('Yorumu silmek istediğinize emin misiniz?');">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                    <button type="submit" name="delete_comment">Yorumu Sil</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile;
                else:
                    echo "<p>Henüz yorum yok.</p>";
                endif;
                ?>
            </div>
        <?php endwhile; ?>

        <?php if (mysqli_num_rows($result) == 0): ?>
            <p>Henüz yayımlanmış yazı yok.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
