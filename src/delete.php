<?php
session_start();
include('db.php');

// Silme işlemi için gelen veri
if (isset($_POST['delete']) && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    
    // Veritabanında silme işlemi
    $query = "DELETE FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        echo "Yazı silindi!";
    } else {
        echo "Silme işlemi başarısız: " . mysqli_error($conn);
    }
}

// Yönlendirme
header("Location: admin.php");  // Silme işlemi tamamlandıktan sonra browse.php'ye yönlendiriyoruz.
exit();
?>
