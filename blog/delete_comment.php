<?php
include('db.php');

if (isset($_POST['delete_comment']) && isset($_POST['comment_id'])) {
    $comment_id = intval($_POST['comment_id']);
    $query = "DELETE FROM comments WHERE id = $comment_id";
    if (mysqli_query($conn, $query)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        echo "Yorum silinemedi: " . mysqli_error($conn);
    }
} else {
    echo "Geçersiz istek.";
}
?>
