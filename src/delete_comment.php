<?php
include('db.php');

if (isset($_POST['delete_comment']) && isset($_POST['comment_id'])) {
    $comment_id = intval($_POST['comment_id']);
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : null;

    $query = "DELETE FROM comments WHERE id = $comment_id";
    if (mysqli_query($conn, $query)) {
        $redirect = $post_id ? "post.php?id=$post_id" : "admin.php";
        header("Location: $redirect");
        exit;
    } else {
        echo "Yorum silinemedi: " . mysqli_error($conn);
    }
} else {
    echo "Geçersiz istek.";
}
?>
